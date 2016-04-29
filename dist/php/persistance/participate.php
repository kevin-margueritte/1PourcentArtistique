<?php

	require_once 'connectionDB.php';

	class Participate {

<<<<<<< HEAD
=======
		require_once 'connectionDB.php';

>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		/**
		Full name of the architect (name & surname)
		@var fullName
		*/
		private $fullName;

		/**
		ID of the art who participate to the art
		@var idArt
		*/
		private $idArt;

		private $db;

<<<<<<< HEAD
		public function __construct ($fullName, $idArt)
=======
		private $db;

		public function __construct ($fullName, $nameArt)
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		{
			$this->db = connection();
			$this->fullName = $fullName;
			$this->idArt = $idArt;
		}

		/**
		* Insert into participate 
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO PARTICIPATE(fullName, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->fullName, $this->idArt));
		}

		/**
		* Test if exist in the database
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM PARTICIPATE WHERE fullName = ? AND idArt = ? ");
			$exist->execute(array($this->fullName, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		function delete() {
			$delete = $this->db->prepare("DELETE FROM PARTICIPATE WHERE fullName = ? AND idArt = ?");
			return $delete->execute(array($this->fullName, $this->idArt));
		}

		/**
		* Insert into participate 
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO PARTICIPATE(fullName, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->fullName, $this->nameArt));
		}

		/**
		* Test if exist in the database
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM PARTICIPATE WHERE fullName = ? AND nameArt = ? ");
			$exist->execute(array($this->fullName, $this->nameArt));
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
	     * @return idArt
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art who participate to the art.
	     *
	     * @param idArt $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}