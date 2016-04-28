<?php

	require_once 'connectionDB.php';

	class Author {
		/**
		Correspond to the name and surname of the author of the art
		@var fullName
		*/
		private $fullName;

		/**
		Date of birth
		@var yearBirth
		*/
		private $yearBirth;

		/**
		Date of death
		@var yearDeath
		*/
		private $yearDeath;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($fullName = null, $yearBirth = null, $yearDeath = null)
		{
			$this->db = connection();
			$this->fullName = $fullName;
			$this->yearBirth = $yearBirth;
			$this->yearDeath = $yearDeath;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO AUTHOR(fullName, yearBirth, yearDeath) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->fullName, $this->yearBirth, $this->yearDeath));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE AUTHOR SET
					yearBirth = ?,
					yearDeath = ?
				WHERE fullName = ?");
			return $update->execute(array($this->yearBirth, $this->yearDeath,$this->fullName));
		}

		function getAll() {
			$get = $this->db->prepare("SELECT * FROM AUTHOR");
			$get->execute();
			return $get->fetchAll();
		}

		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM AUTHOR WHERE fullName = ? ");
			$exist->execute(array($this->fullName));
			return count($exist->fetchAll()) >= 1;
		}
	
	    /**
	     * Gets the Correspond to the name and surname of the author of the art.
	     *
	     * @return fullName
	     */
	    public function getFullName()
	    {
	        return $this->fullName;
	    }

	    /**
	     * Sets the Correspond to the name and surname of the author of the art.
	     *
	     * @param fullName $newFullName the full name
	     */
	    private function setFullName($newFullName)
	    {
	        $this->fullName = $newFullName;
	    }

	    /**
	     * Gets the Date of birth.
	     *
	     * @return yearBirth
	     */
	    public function getYearBirth()
	    {
	        return $this->yearBirth;
	    }

	    /**
	     * Sets the Date of birth.
	     *
	     * @param yearBirth $newYearBirth the year birth
	     */
	    private function setYearBirth($newYearBirth)
	    {
	        $this->yearBirth = $newYearBirth;
	    }

	    /**
	     * Gets the Date of death.
	     *
	     * @return yearDeath
	     */
	    public function getYearDeath()
	    {
	        return $this->yearDeath;
	    }

	    /**
	     * Sets the Date of death.
	     *
	     * @param yearDeath $newYearDeath the year death
	     */
	    private function setYearDeath($newYearDeath)
	    {
	        $this->yearDeath = $newYearDeath;
	    }
	}