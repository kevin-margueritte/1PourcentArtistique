<?php
	class Architect {

		require_once 'connectionDB.php';

		/**
		Full name of the architect (name & surname)
		@var fullName
		*/
		private $fullName;

		/**
		Name of the art who participate to the art
		@var nameArt
		*/
		private $nameArt;

		private $db;

		public function __construct ($fullName, $nameArt)
		{
			$this->db = connection();
			$this->fullName = $fullName;
			$this->nameArt = $nameArt;
		}

		/**
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO ARCHITECT(fullName, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->fullName, $this->nameArt));
		}

		/**
		* Udpdate the name of the art with the name of the architect in the database 
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE ARCHITECT SET
					nameArt = ?
				WHERE fullName = ?");
			return $update->execute(array($this->nameArt, $this->fullName));
		}

		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM ARCHITECT WHERE fullName = ? ");
			$exist->execute(array($this->fullName));
			return count($exist->fetchAll()) >= 1;
		}
	
	    /**
	     * Gets the Full name of the architect (name & surname).
	     *
	     * @return fullName
	     */
	    public function getFullName()
	    {
	        return $this->fullName;
	    }

	    /**
	     * Sets the Full name of the architect (name & surname).
	     *
	     * @param fullName $newFullName the full name
	     */
	    private function setFullName($newFullName)
	    {
	        $this->fullName = $newFullName;
	    }

	    /**
	     * Gets the Name of the art who participate to the art.
	     *
	     * @return nameArt
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art who participate to the art.
	     *
	     * @param nameArt $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}