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
		private $historiqueHTMLFile;

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

		public function __construct ($name = null, $creationYear = null, $nameLocation = null, $presentationHTMLFile = null, $historiqueHTMLFile = null, $soundFile = null, 
			$isPublic = null, $type = null, $id = null, $imageFile = null)
		{
			$this->db = connection();
			$this->name = $name;
			$this->creationYear = $creationYear;
			$this->nameLocation = $nameLocation;
			$this->presentationHTMLFile = $presentationHTMLFile;
			$this->historiqueHTMLFile = $historiqueHTMLFile;
			$this->soundFile = $soundFile;
			$this->isPublic = $isPublic;
			$this->type = $type;
			$this->id = $id;
			$this->imageFile = $imageFile;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO ART(name, creationYear, presentationHTMLFile, 
				historiqueHTMLFile, soundFile, isPublic, type, nameLocation, imageFile) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			return $insert->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historiqueHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->imageFile));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE ART SET
					name = ?,
					creationYear = ?, 
					presentationHTMLFile = ?, 
					historiqueHTMLFile = ?, 
					soundFile = ?, 
					isPublic = ?, 
					type = ?,
					nameLocation = ?,
					imageFile = ?
				WHERE id = ?");
			return $update->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historiqueHTMLFile, $this->soundFile, $this->isPublic, $this->type, $this->nameLocation, $this->id, $this->imageFile));
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
			$query = $this->db->prepare("SELECT id, name, creationYear, presentationHTMLFile, historiqueHTMLFile, soundFile, isPublic, type, imageFile FROM Art");
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
			$query = $this->db->prepare("SELECT ART.name, ART.creationYear, ART.type, LOCATION.longitude, LOCATION.latitude
										 FROM ART, LOCATION, LOCATED
										 WHERE ART.name = LOCATED.nameArt
										 AND LOCATION.name = LOCATED.nameLocation");
			$query->execute();
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
	     * Sets the value of imageFile.
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
	    private function setPresentationHTMLFile($newPresentationHTMLFile)
	    {
	        $this->presentationHTMLFile = $newPresentationHTMLFile;
	    }

	    /**
	     * Gets the value of historiqueHTMLFile.
	     *
	     * @return historiqueHTMLFile
	     */
	    public function getHistoriqueHTMLFile()
	    {
	        return $this->historiqueHTMLFile;
	    }

	    /**
	     * Sets the value of historiqueHTMLFile.
	     *
	     * @param  $newHistoriqueHTMLFile the historique HTML file
	     */
	    private function setHistoriqueHTMLFile($newHistoriqueHTMLFile)
	    {
	        $this->historiqueHTMLFile = $newHistoriqueHTMLFile;
	    }

	    /**
	     * Gets the value of soundFile.
	     *
	     * @return soundFile
	     */
	    public function getsoundFile()
	    {
	        return $this->soundFile;
	    }

	    /**
	     * Sets the value of soundFile.
	     *
	     * @param  $newsoundFile the sound file
	     */
	    private function setsoundFile($newsoundFile)
	    {
	        $this->soundFile = $newsoundFile;
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