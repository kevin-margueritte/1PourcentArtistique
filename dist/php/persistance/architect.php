<?php

	require_once 'connectionDB.php';

	class Architect {

		/**
		Full name of the architect (name & surname)
		@var fullName
		*/
		private $fullName;

		private $db;

		public function __construct ($fullName)
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