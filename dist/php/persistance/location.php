<?php

	require_once 'connectionDB.php';

	class Location {
		/**
		Name of the localisation 
		@var name
		*/
		private $name;

		/**
		Longitude of the localisation
		@var longitude
		*/
		private $longitude;

		/**
		Latitude of the localisation
		@var latitude
		*/
		private $latitude;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name = null, $longitude = null, $latitude = null)
		{
			$this->db = connection();
			$this->name = $name;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
		}

		public function save () {
			$insert = $this->db->prepare("INSERT INTO LOCATION(name, longitude, latitude) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->name, $this->longitude, $this->latitude));
		}

		function update () {
			$update = $this->db->prepare(
				"UPDATE LOCATION SET
					longitude = ?, 
					latitude = ?
				WHERE name = ?");
			return $update->execute(array($this->longitude, $this->latitude, 
				$this->name));
		}

		function getAll() {
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$get = $this->db->prepare("SELECT * FROM LOCATION");
			$get->execute();
			return $get->fetchAll();
		}

		function getAllForSearch() {
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$get = $this->db->prepare("
				SELECT DISTINCT LOCATION.* 
				FROM LOCATION, ART
				WHERE ART.nameLocation = LOCATION.name AND ART.isPublic = 1"
				);
			$get->execute();
			return $get->fetchAll();
		}

		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM LOCATION WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		function changed() {
			$exist = $this->db->prepare("SELECT 1 FROM LOCATION WHERE longitude = ? AND  latitude = ?");
			$exist->execute(array($this->longitude, $this->latitude));
			return count($exist->fetchAll()) == 0;
		}

	    /**
	     * Gets the Name of the localisation.
	     *
	     * @return name
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the Name of the localisation.
	     *
	     * @param name $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
	    }

	    /**
	     * Gets the Longitude of the localisation.
	     *
	     * @return longitude
	     */
	    public function getLongitude()
	    {
	        return $this->longitude;
	    }

	    /**
	     * Sets the Longitude of the localisation.
	     *
	     * @param longitude $newLongitude the longitude
	     */
	    private function setLongitude($newLongitude)
	    {
	        $this->longitude = $newLongitude;
	    }

	    /**
	     * Gets the Latitude of the localisation.
	     *
	     * @return latitude
	     */
	    public function getLatitude()
	    {
	        return $this->latitude;
	    }

	    /**
	     * Sets the Latitude of the localisation.
	     *
	     * @param latitude $newLatitude the latitude
	     */
	    private function setLatitude($newLatitude)
	    {
	        $this->latitude = $newLatitude;
	    }

	    /**
	     * Gets the Name of the art at this localisation.
	     *
	     * @return nameArt
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art at this localisation.
	     *
	     * @param nameArt $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}