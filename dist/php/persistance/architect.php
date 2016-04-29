<?php

	require_once 'connectionDB.php';

	class Architect {

<<<<<<< HEAD
=======
		require_once 'connectionDB.php';

>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		/**
		Full name of the architect (name & surname)
		@var fullName
		*/
		private $fullName;

		private $db;

<<<<<<< HEAD
		public function __construct ($fullName)
=======
		private $db;

		public function __construct ($fullName, $nameArt)
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		{
			$this->db = connection();
			$this->fullName = $fullName;
		}

		/**
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO ARCHITECT(fullName) 
				VALUES (?)");
			return $insert->execute(array($this->fullName));
		}

		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM ARCHITECT WHERE fullName = ? ");
			$exist->execute(array($this->fullName));
			return count($exist->fetchAll()) >= 1;
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
	}