<?php

	require_once 'connectionDB.php';

	class Located {
		/**
		Name of the localisation 
		@var nameLocation
		*/
		private $nameLocation;

		/**
		Name of the art
		@var idArt
		*/
		private $idArt;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name, $idArt)
		{
			$this->db = connection();
			$this->nameLocation = $name;
			$this->idArt = $idArt;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO LOCATED(nameLocation, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameLocation, $this->idArt));
		}

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
	     * @return name
	     */
	    public function getNameLocation()
	    {
	        return $this->nameLocation;
	    }

	    /**
	     * Sets the Name of the localisation.
	     *
	     * @param name $newName the name
	     */
	    private function setNameLocation($newName)
	    {
	        $this->nameLocation = $newName;
	    }

	    /**
	     * Gets the Name of the art.
	     *
	     * @return idArt
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param idArt $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}