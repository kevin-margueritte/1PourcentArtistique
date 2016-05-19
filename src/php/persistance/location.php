<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Location {
		/**
		* Name of the localisation 
		* @var string
		*/
		private $name;

		/**
		* Longitude of the localisation
		* @var float
		*/
		private $longitude;

		/**
		* Latitude of the localisation
		* @var float
		*/
		private $latitude;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $name
		* @param float $longitude
		* @param float latitude
		*/
		public function __construct ($name = null, $longitude = null, $latitude = null)
		{
			$this->db = connection();
			$this->name = $name;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
		}

		/**
		* Save the location in the database with the latitude, location and his name
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO LOCATION(name, longitude, latitude) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->name, $this->longitude, $this->latitude));
		}

		/**
		 * Update the longitude and latitude by the name of the location
		 * @return If the update worked
		 */
		function update () {
			$update = $this->db->prepare(
				"UPDATE LOCATION SET
					longitude = ?, 
					latitude = ?
				WHERE name = ?");
			return $update->execute(array($this->longitude, $this->latitude, 
				$this->name));
		}

		/**
		 * Retrieves all informations about locations in the database
		 * @return All locations
		 */
		function getAll() {
			$this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			$get = $this->db->prepare("SELECT * FROM LOCATION");
			$get->execute();
			return $get->fetchAll();
		}

		/**
		* Test if the location already existe in the databse by his name 
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM LOCATION WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		 * Change the longitude and latitude of the name
		 * @return If the changement worked
		 */
		function changed() {
			$exist = $this->db->prepare("SELECT 1 FROM LOCATION WHERE longitude = ? AND  latitude = ?");
			$exist->execute(array($this->longitude, $this->latitude));
			return count($exist->fetchAll()) == 0;
		}

	    /**
	     * Gets the Name of the localisation.
	     *
	     * @return string name
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the Name of the localisation.
	     *
	     * @param string $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
	    }

	    /**
	     * Gets the Longitude of the localisation.
	     *
	     * @return float longitude
	     */
	    public function getLongitude()
	    {
	        return $this->longitude;
	    }

	    /**
	     * Sets the Longitude of the localisation.
	     *
	     * @param float $newLongitude the longitude
	     */
	    private function setLongitude($newLongitude)
	    {
	        $this->longitude = $newLongitude;
	    }

	    /**
	     * Gets the Latitude of the localisation.
	     *
	     * @return float latitude
	     */
	    public function getLatitude()
	    {
	        return $this->latitude;
	    }

	    /**
	     * Sets the Latitude of the localisation.
	     *
	     * @param float $newLatitude the latitude
	     */
	    private function setLatitude($newLatitude)
	    {
	        $this->latitude = $newLatitude;
	    }

	    /**
	     * Gets the Name of the art at this localisation.
	     *
	     * @return string nameArt
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art at this localisation.
	     *
	     * @param String $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}