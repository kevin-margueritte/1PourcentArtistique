<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Participate {

		/**
		* Full name of the architect (name & surname)
		* @var string
		*/
		private $fullName;

		/**
		* ID of the art who participate to the art
		* @var integer
		*/
		private $idArt;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $fullName
		* @param integer $idArt
		*/
		public function __construct ($fullName, $idArt)
		{
			$this->db = connection();
			$this->fullName = $fullName;
			$this->idArt = $idArt;
		}

		/**
		* Save the participation of an architect in the database with his name and the id of the art
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO PARTICIPATE(fullName, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->fullName, $this->idArt));
		}

		/**
		* Test if the architect already existe in the databse by his name and the id of the art
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM PARTICIPATE WHERE fullName = ? AND idArt = ? ");
			$exist->execute(array($this->fullName, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Delete the participation of an architect with his name and the id of the art
		* @return If the deletion worked
		*/
		function delete() {
			$delete = $this->db->prepare("DELETE FROM PARTICIPATE WHERE fullName = ? AND idArt = ?");
			return $delete->execute(array($this->fullName, $this->idArt));
		}
	
	    /**
	     * Gets the Full name of the architect (name & surname).
	     *
	     * @return string
	     */
	    public function getFullName()
	    {
	        return $this->fullName;
	    }

	    /**
	     * Sets the Full name of the architect (name & surname).
	     *
	     * @param string $newFullName the full name
	     */
	    private function setFullName($newFullName)
	    {
	        $this->fullName = $newFullName;
	    }

	    /**
	     * Gets the Name of the art who participate to the art.
	     *
	     * @return integer
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art who participate to the art.
	     *
	     * @param integer $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}