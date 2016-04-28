<?php

	require_once 'connectionDB.php';

	class Located {
		/**
		Name of the localisation 
		@var nameLocation
		*/
		private $nameLocation;

		/**
		Longitude of the art
		@var nameArt
		*/
		private $nameArt;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name, $nameArt)
		{
			$this->db = connection();
			$this->nameLocation = $name;
			$this->nameArt = $nameArt;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO LOCATED(nameLocation, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameLocation, $this->nameArt));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE LOCATED SET
					nameLocation = ?, 
					nameArt = ?
				WHERE nameLocation = ? AND nameArt = ?");
			return $update->execute(array($this->nameLocation, $this->nameArt, 
				$this->nameLocation, $this->nameArt));
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
	     * @return nameArt
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param nameArt $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}