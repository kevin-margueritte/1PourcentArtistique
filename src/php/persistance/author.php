<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Author {
		/**
		*Correspond to the name and surname of the author of the art
		* @var string
		*/
		private $fullName;

		/**
		* Date of birth
		* @var integer
		*/
		private $yearBirth;

		/**
		* Date of death
		* @var integer
		*/
		private $yearDeath;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $fullName
		* @param integer $yearBirth
		* @param integer $yearDeath
		*/
		public function __construct ($fullName = null, $yearBirth = null, $yearDeath = null)
		{
			$this->db = connection();
			$this->fullName = $fullName;
			$this->yearBirth = $yearBirth;
			$this->yearDeath = $yearDeath;
		}

		/**
		* Save in the database
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO AUTHOR(fullName, yearBirth, yearDeath) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->fullName, $this->yearBirth, $this->yearDeath));
		}

		/**
		 * Update the years of an author in the database with the name of the author
		 * @return If the update work
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE AUTHOR SET
					yearBirth = ?,
					yearDeath = ?
				WHERE fullName = ?");
			return $update->execute(array($this->yearBirth, $this->yearDeath,$this->fullName));
		}

		/**
		* Retrieve all authors 
		* @return All authors informations
		*/
		function getAll() {
			$get = $this->db->prepare("SELECT * FROM AUTHOR");
			$get->execute();
			return $get->fetchAll();
		}

		/**
		* Test if the author exist in the database by his name
		* @return integer 0 or 1
		*/
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
	     * @param string $newFullName the full name
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
	     * @param integer $newYearBirth the year birth
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
	     * @param integer $newYearDeath the year death
	     */
	    private function setYearDeath($newYearDeath)
	    {
	        $this->yearDeath = $newYearDeath;
	    }
	}