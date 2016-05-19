<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Located {
		/**
		* Name of the localisation 
		* @var string
		*/
		private $nameLocation;

		/**
		*Name of the art
		* @var integer
		*/
		private $idArt;

		/**
		Connection database
		@var $db
		*/
		
		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $name
		* @param integer $idArt
		*/
		public function __construct ($name, $idArt)
		{
			$this->db = connection();
			$this->nameLocation = $name;
			$this->idArt = $idArt;
		}

		/**
		* Save the name of the located position in the database
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO LOCATED(nameLocation, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameLocation, $this->idArt));
		}

		/**
		 * Update the name name of the location or the id of the art by the name of the location and the id of the art
		 * @return If the update worked
		 */
		function update () {
			$update = $this->db->prepare(
				"UPDATE LOCATED SET
					nameLocation = ?, 
					idArt = ?
				WHERE nameLocation = ? AND idArt = ?");
			return $update->execute(array($this->nameLocation, $this->idArt, 
				$this->nameLocation, $this->idArt));
		}

	    /**
	     * Gets the Name of the localisation.
	     *
	     * @return string name
	     */
	    public function getNameLocation()
	    {
	        return $this->nameLocation;
	    }

	    /**
	     * Sets the Name of the localisation.
	     *
	     * @param string $newName the name
	     */
	    private function setNameLocation($newName)
	    {
	        $this->nameLocation = $newName;
	    }

	    /**
	     * Gets the Name of the art.
	     *
	     * @return integer idArt
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param integer $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}