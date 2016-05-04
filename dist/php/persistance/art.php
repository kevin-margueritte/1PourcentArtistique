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
			$insert->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historicHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->imageFile));
			var_dump($insert->errorInfo());
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
				$this->historicHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->id, $this->imageFile));
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
			$query = $this->db->prepare("SELECT ART.name, ART.creationYear, ART.type, ART.imageFile, LOCATION.longitude, LOCATION.latitude, GROUP_CONCAT(DESIGN.nameAuthor SEPARATOR \", \") AS auteurs
fROM ART, LOCATION, LOCATED, DESIGN
WHERE ART.name = LOCATED.nameArt
AND LOCATION.name = LOCATED.nameLocation
AND DESIGN.nameArt = ART.name
GROUP BY ART.name;");
			$query->execute();
			return $query->fetchAll();
		}

		function getAllInfoForAnArt() {
			$query = $this->db->prepare("SELECT art.id, art.name, art.creationYear, art.imageFile, art.presentationHTMLFile, art.historiqueHTMLFile, art.soundFile, art.type, LOCATED.nameLocation, GROUP_CONCAT(DISTINCT CONCAT_WS(\", \", DESIGN.nameAuthor, AUTHOR.yearBirth, AUTHOR.yearDEATH) SEPARATOR \"; \") AS auteurs ,GROUP_CONCAT(DISTINCT COMPOSE.nameMaterial SEPARATOR \", \") AS materiaux, GROUP_CONCAT(DISTINCT PARTICIPATE.fullName SEPARATOR \", \") AS architectes, GROUP_CONCAT(DISTINCT VIDEO.titleFile SEPARATOR \", \") AS videos, GROUP_CONCAT(DISTINCT PHOTOGRAPHY.nameFile SEPARATOR \", \") AS photographies, GROUP_CONCAT(DISTINCT HISTORIC.nameFile SEPARATOR \", \") AS photographies_historique FROM ART, LOCATION, LOCATED, DESIGN, AUTHOR, PARTICIPATE, COMPOSE, VIDEO, PHOTOGRAPHY, HISTORIC WHERE ART.name = LOCATED.nameArt AND LOCATION.name = LOCATED.nameLocation AND DESIGN.nameArt = ART.name AND AUTHOR.fullName = DESIGN.nameAuthor  AND PARTICIPATE.nameArt = art.name AND COMPOSE.nameArt = art.name AND VIDEO.nameArt = art.name AND PHOTOGRAPHY.nameArt = art.name AND HISTORIC.nameArt = art.name AND art.name = :name GROUP BY ART.name");
			$query->execute(array(
				'name' => $this->name
				));
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
	    public function setName($newName)
	    {
	        $this->name = $newName;
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
	    	$insert = $this->db->prepare("UPDATE ART SET imageFile = ? WHERE name = ?");
	    	return $insert->execute(array($newImage, $this->name));
	    }

	    /**
	     * Gets the value of creationYear.
	     *
	     * @return creationYear
	     */
	    public function getcreationYear()
	    {
	        return $this->creationYear;
	    }

	    /**
	     * Sets the value of creationYear.
	     *
	     * @param  $newcreationYear the creation date
	     */
	    private function setcreationYear($newcreationYear)
	    {
	        $this->creationYear = $newcreationYear;
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
	    private function sethistoricHTMLFile($newhistoricHTMLFile)
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
	    private function setSoundFile($newsoundFile)
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
	    private function setIsPublic($newIsPublic)
	    {
	        $this->isPublic = $newIsPublic;
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
	    private function setType($newType)
	    {
	        $this->type = $newType;
	    }
	}