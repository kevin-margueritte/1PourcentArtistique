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
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name, $creationYear, $presentationHTMLFile = null, $historiqueHTMLFile = null, $soundFile = null, $isPublic = null, $type = null)
		{
			$this->db = connection();
			$this->name = $name;
			$this->creationYear = $creationYear;
			$this->presentationHTMLFile = $presentationHTMLFile;
			$this->historiqueHTMLFile = $historiqueHTMLFile;
			$this->soundFile = $soundFile;
			$this->isPublic = $isPublic;
			$this->type = $type;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO ART(name, creationYear, presentationHTMLFile, 
				historiqueHTMLFile, soundFile, isPublic, type) 
				VALUES (?, ?, ?, ?, ?, ?, ?)");
			return $insert->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historiqueHTMLFile, $this->soundFile, $this->isPublic, $this->type));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE ART SET
					creationYear = ?, 
					presentationHTMLFile = ?, 
					historiqueHTMLFile = ?, 
					soundFile = ?, 
					isPublic = ?, 
					type = ?
				WHERE name = ?");
			return $update->execute(array($this->name, $this->creationYear, $this->presentationHTMLFile, 
				$this->historiqueHTMLFile, $this->soundFile, $this->isPublic, $this->type));
		}

		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM ART WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		function selectAllOeuvres()
		{
			$query = $this->db->prepare("SELECT name, creationYear, presentationHTMLFile, historiqueHTMLFile, soundFile, isPublic, type FROM Art");
			$query->execute();
			return $query->fetchAll();
		}

		function updateIsPublic () {
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

	    /**
	     * Gets the value of name.
	     *
	     * @return name
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the value of name.
	     *
	     * @param $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
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