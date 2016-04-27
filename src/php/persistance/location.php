<?php
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
		Name of the art at this localisation
		@var nameArt
		*/
		private $nameArt;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($name, $longitude, $latitude, $nameArt)
		{
			$this->db = connection();
			$this->name = $name;
			$this->longitude = $longitude;
			$this->latitude = $latitude;
			$this->nameArt = $nameArt;
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