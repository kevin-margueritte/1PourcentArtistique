<?php
	require_once 'connectionDB.php';

	class Art {
		/**
		Name of the art
		@var name
		*/
		private $name;

		/**
		Date of creation
		var @creationYear
		*/
		private $creationYear;

		/**
		*/
		private $presentationHTMLFile;

		/**
		*/
		private $historicHTMLFile;

		/**
		*/
		private $soundFile;

		/**
		Know if the art is public or not
		@var isPublic
		*/
		private $isPublic;

		/**
		Type of the art
		@var type
		*/
		private $type;

		/**
		Id of the art
		@var id
		*/
		private $id;

		/**
		Location of the art
		@var nameLocation
		*/
		private $nameLocation;

		/**
		Image of the art
		@var imageFile
		*/
		private $imageFile;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name = null, $creationYear = null, $nameLocation = null, $presentationHTMLFile = null, $historicHTMLFile = null, $soundFile = null, 
			$isPublic = null, $type = null, $id = null, $imageFile = null)
		{
			$this->db = connection();
			$this->name = $name;
			$this->creationYear = $creationYear;
			$this->nameLocation = $nameLocation;
			$this->presentationHTMLFile = $presentationHTMLFile;
			$this->historicHTMLFile = $historicHTMLFile;
			$this->soundFile = $soundFile;
			$this->isPublic = $isPublic;
			$this->type = $type;
			$this->id = $id;
			$this->imageFile = $imageFile;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO ART(name, creationYear, presentationHTMLFile, 
				historicHTMLFile, soundFile, isPublic, type, nameLocation, imageFile) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			return $insert->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historicHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->imageFile));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE ART SET
					name = ?,
					creationYear = ?, 
					presentationHTMLFile = ?, 
					historicHTMLFile = ?, 
					soundFile = ?, 
					isPublic = ?, 
					type = ?,
					nameLocation = ?,
					imageFile = ?
				WHERE id = ?");
			return $update->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historicHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->imageFile, $this->id));
		}

		function existByName() {
			$exist = $this->db->prepare("SELECT 1 FROM ART WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		function existById() {
			$exist = $this->db->prepare("SELECT 1 FROM ART WHERE id = ? ");
			$exist->execute(array($this->id));
			return count($exist->fetchAll()) >= 1;
		}

		function selectAllArts()
		{
			$query = $this->db->prepare("SELECT id, name, creationYear, presentationHTMLFile,
			 historicHTMLFile, soundFile, isPublic, type, imageFile FROM Art ORDER BY(name) ASC");
			$query->execute();
			return $query->fetchAll();
		}

		function getAllArtsForSearch()
		{
/*			$query = $this->db->prepare("SELECT art.name, art.creationYear, GROUP_CONCAT(DESIGN.nameAuthor SEPARATOR \", \") AS auteurs
FROM art, DESIGN
WHERE art.name = DESIGN.nameArt
GROUP BY art.name");*/
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$query = $this->db->prepare('
				SELECT 
					ART.name as name, 
					ART.creationYear as creationYear, 
					LISTAGG(DESIGN.nameAuthor, \', \') 
						WITHIN GROUP (ORDER BY DESIGN.nameAuthor) as auteurs
				FROM ART, DESIGN
				WHERE DESIGN.idart = ART.id
				GROUP BY (ART.name, ART.creationYear) 
				ORDER BY ART.name'
			);
			$query->execute();
			return $query->fetchAll();
		}

		function updateIsPublic() {
			$query = $this->db->prepare(
				"UPDATE ART SET isPublic = :isPublic where name = :name");
			$query->execute(array(
				'isPublic' => $this->isPublic,
				'name' => $this->name
				));
			return $query;
		}

		function delete() {
			$query = $this->db->prepare(
				"DELETE FROM ART WHERE name = :name");
			$query->execute(array(
				'name' => $this->name
				));
			return $query;
		}
		function getAllForAccueil() {
			/*$query = $this->db->prepare("SELECT ART.name, ART.creationYear, ART.type, ART.imageFile, LOCATION.longitude, LOCATION.latitude, GROUP_CONCAT(DESIGN.nameAuthor SEPARATOR \", \") AS auteurs
fROM ART, LOCATION, LOCATED, DESIGN
WHERE ART.name = LOCATED.nameArt
AND LOCATION.name = LOCATED.nameLocation
AND DESIGN.nameArt = ART.name
GROUP BY ART.name;");*/
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$query = $this->db->prepare('
				SELECT 
					ART.name as name, 
					ART.creationYear as creationYear, 
					ART.type as type, 
					ART.imageFile as imageFile, 
					LOCATION.longitude as longitude, 
					LOCATION.latitude as latitude, 
					LISTAGG(DESIGN.nameAuthor, \', \') 
						WITHIN GROUP (ORDER BY DESIGN.nameAuthor) as auteurs
				FROM ART, LOCATION, DESIGN
				WHERE LOCATION.name = ART.nameLocation AND DESIGN.idart = ART.id
				GROUP BY (ART.name, ART.creationYear, ART.type, ART.imageFile, LOCATION.longitude, LOCATION.latitude) 
				ORDER BY ART.name'
			);
			$query->execute();
			return $query->fetchAll();
		}

		function getAllInfoForAnArt() {
/*			$query = $this->db->prepare("SELECT art.id, art.name, art.creationYear, art.imageFile, art.presentationHTMLFile, art.historiqueHTMLFile, art.soundFile, art.type, LOCATED.nameLocation, GROUP_CONCAT(DISTINCT CONCAT_WS(\", \", DESIGN.nameAuthor, AUTHOR.yearBirth, AUTHOR.yearDEATH) SEPARATOR \"; \") AS auteurs ,GROUP_CONCAT(DISTINCT COMPOSE.nameMaterial SEPARATOR \", \") AS materiaux, GROUP_CONCAT(DISTINCT PARTICIPATE.fullName SEPARATOR \", \") AS architectes, GROUP_CONCAT(DISTINCT VIDEO.titleFile SEPARATOR \", \") AS videos, GROUP_CONCAT(DISTINCT PHOTOGRAPHY.nameFile SEPARATOR \", \") AS photographies, GROUP_CONCAT(DISTINCT HISTORIC.nameFile SEPARATOR \", \") AS photographies_historique FROM ART, LOCATION, LOCATED, DESIGN, AUTHOR, PARTICIPATE, COMPOSE, VIDEO, PHOTOGRAPHY, HISTORIC WHERE ART.name = LOCATED.nameArt AND LOCATION.name = LOCATED.nameLocation AND DESIGN.nameArt = ART.name AND AUTHOR.fullName = DESIGN.nameAuthor  AND PARTICIPATE.nameArt = art.name AND COMPOSE.nameArt = art.name AND VIDEO.nameArt = art.name AND PHOTOGRAPHY.nameArt = art.name AND HISTORIC.nameArt = art.name AND art.name = :name GROUP BY ART.name");*/
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$query = $this->db->prepare("
				SELECT DISTINCT
				  a.*,
				  l.longitude,
				  l.latitude,
				  v.titleFile AS video,
				  p.nameFile AS photo,
				  h.nameFile AS historic,
				  auth.*,
				  m.name AS material,
				  arch.fullname as architectName,
				  d.biographyHTMLFile as biography
				FROM 
				  Art a
				  LEFT JOIN Location l ON a.nameLocation = l.name 
				  LEFT JOIN Video v ON v.idArt = a.id
				  LEFT JOIN Participate p ON a.id = p.idArt
				  LEFT JOIN Architect arch ON p.fullName = arch.fullName
				  LEFT JOIN Photography p ON p.idArt = a.id
				  LEFT JOIN Historic h ON h.idArt = a.id
				  LEFT JOIN Design d ON a.id = d.idArt
				  LEFT JOIN Author auth ON auth.fullName = d.nameAuthor
				  LEFT JOIN Compose c ON c.idArt = a.id
				  LEFT JOIN Material m ON c.nameMaterial = m.name
				WHERE 
				  a.name = ?
			");
			$query->execute(array($this->name));
			return $query->fetchAll();
		}

		/**
	     * Gets the id.
	     *
	     * @return id
	     */
	    public function getId()
	    {
	    	$query = $this->db->prepare("SELECT id FROM ART WHERE name = ?");
	    	$query->execute(array($this->name));
	        return $query->fetchColumn();
	    }

	    /**
	     * Gets the value of name.
	     *
	     * @return name
	     */
	    public function getName()
	    {
	        $query = $this->db->prepare("SELECT name FROM ART WHERE id = ?");
	    	$query->execute(array($this->id));
	        return $query->fetchColumn();
	    }

	    /**
	     * Sets the value of name.
	     *
	     * @param $newName the name
	     */
	    public function setNameById($newName)
	    {
	        $this->name = $newName;
	    	$update = $this->db->prepare("UPDATE ART SET name = ? WHERE id = ?");
	    	return $update->execute(array($newName, $this->id));
	    }

	    /**
	     * Gets the value of imageFile.
	     *
	     * @return imageFile
	     */
	    public function getImageFile()
	    {
	        return $this->imageFile;
	    }

	    /**
	     * Sets the value of imageFile by name of the art.
	     *
	     * @param $newName the imageFile
	     */
	    public function setImageFileByName($newImage)
	    {
	    	$this->imageFile = $newImage;
	    	$update = $this->db->prepare("UPDATE ART SET imageFile = ? WHERE name = ?");
	    	return $update->execute(array($newImage, $this->name));
	    }

	    /**
	     * Gets the value of creationYear.
	     *
	     * @return creationYear
	     */
	    public function getCreationYear()
	    {
	        return $this->creationYear;
	    }

	    /**
	     * Sets the value of creationYear.
	     *
	     * @param  $newcreationYear the creation date
	     */
	    public function setCreationYear($newcreationYear)
	    {
	        $this->creationYear = $newcreationYear;
	    	$update = $this->db->prepare("UPDATE ART SET creationyear = ? WHERE id = ?");
	    	return $update->execute(array($newcreationYear, $this->id));
	    }

	    /**
	     * Gets the value of presentationHTMLFile.
	     *
	     * @return presentationHTMLFile
	     */
	    public function getPresentationHTMLFile()
	    {
	        return $this->presentationHTMLFile;
	    }

	    /**
	     * Sets the value of presentationHTMLFile.
	     *
	     * @param  $newPresentationHTMLFile the presentation HTML lfile
	     */
	    public function setPresentationHTMLFileByName($newPresentationHTMLFile)
	    {
	        $this->presentationHTMLFile = $newPresentationHTMLFile;
	    	$insert = $this->db->prepare("UPDATE ART SET presentationHTMLFile = ? WHERE name = ?");
	    	return $insert->execute(array($newPresentationHTMLFile, $this->name));
	    }

	    /**
	     * Gets the value of historicHTMLFile.
	     *
	     * @return historicHTMLFile
	     */
	    public function gethistoricHTMLFile()
	    {
	        return $this->historicHTMLFile;
	    }

	    /**
	     * Sets the value of historicHTMLFile.
	     *
	     * @param  $newhistoricHTMLFile the historique HTML file
	     */
	    public function sethistoricHTMLFile($newhistoricHTMLFile)
	    {
	        $this->historicHTMLFile = $newhistoricHTMLFile;
	    }

	    public function setHistoriqueHTMLFileByName($newhistoricHTMLFile)
	    {
	        $this->historicHTMLFile = $newhistoricHTMLFile;
	    	$insert = $this->db->prepare("UPDATE ART SET historicHTMLFile = ? WHERE name = ?");
	    	return $insert->execute(array($newhistoricHTMLFile, $this->name));
	    }

	    /**
	     * Gets the value of soundFile.
	     *
	     * @return soundFile
	     */
	    public function getSoundFile()
	    {
	        return $this->soundFile;
	    }

	    /**
	     * Sets the value of soundFile.
	     *
	     * @param  $newsoundFile the sound file
	     */
	    public function setSoundFile($newsoundFile)
	    {
	        $this->soundFile = $newsoundFile;
	    }

	    /**
	     * Sets the value of soundFile by the name of the art.
	     *
	     * @param  $newsoundFile
	     */
	    public function setSoundFileByName($newsoundFile)
	    {
	        $this->soundFile = $newsoundFile;
	    	$insert = $this->db->prepare("UPDATE ART SET soundFile = ? WHERE name = ?");
	    	return $insert->execute(array($newsoundFile, $this->name));
	    }

	    /**
	     * Gets the value of isPublic.
	     *
	     * @return isPublic
	     */
	    public function getIsPublic()
	    {
	        return $this->isPublic;
	    }

	    /**
	     * Sets the value of isPublic.
	     *
	     * @param  $newIsPublic the is public
	     */
	    public function setIsPublicById($newIsPublic)
	    {
	        $this->isPublic = $newIsPublic;
	    	$update = $this->db->prepare("UPDATE ART SET ispublic = ? WHERE id = ?");
	    	return $update->execute(array($newIsPublic, $this->id));
	    }

	    /**
	     * Gets the value of type.
	     *
	     * @return type
	     */
	    public function getType()
	    {
	        return $this->type;
	    }

	    /**
	     * Sets the value of type.
	     *
	     * @param  $newType the type
	     */
	    public function setType($newType)
	    {
	        $this->type = $newType;
	        $update = $this->db->prepare("UPDATE ART SET type = ? WHERE id = ?");
	    	return $update->execute(array($newType, $this->id));
	    }
	}