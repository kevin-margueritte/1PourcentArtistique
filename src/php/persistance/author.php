<?php
	class Author {
		/**
		Correspond to the name and surname of the author of the art
		@var fullName
		*/
		private $fullName;

		/**
		Biography of the author
		@var biographyHTMLFile
		*/
		private $biographyHTMLFile;

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

		public function __construct ($fullName, $biographyHTMLFile, $yearBirth, $yearDeath)
		{
			$this->fullName = $fullName;
			$this->biographyHTMLFile = $biographyHTMLFile;
			$this->yearBirth = $yearBirth;
			$this->yearDeath = $yearDeath;
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
	     * Gets the Biography of the author.
	     *
	     * @return biographyHTMLFile
	     */
	    public function getBiographyHTMLFile()
	    {
	        return $this->biographyHTMLFile;
	    }

	    /**
	     * Sets the Biography of the author.
	     *
	     * @param biographyHTMLFile $newBiographyHTMLFile the biography HTML file
	     */
	    private function setBiographyHTMLFile($newBiographyHTMLFile)
	    {
	        $this->biographyHTMLFile = $newBiographyHTMLFile;
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