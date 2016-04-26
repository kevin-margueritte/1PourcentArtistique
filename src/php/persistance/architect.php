<?php
	class Architect {
		/**
		Full name of the architect (name & surname)
		@var fullName
		*/
		private $fullName;

		/**
		Name of the art who participate to the art
		@var nameArt
		*/
		private $nameArt;

		public function __construct ($fullName, $nameArt)
		{
			$this->fullName = $fullName;
			$this->nameArt = $nameArt;
		}
	
	    /**
	     * Gets the Full name of the architect (name & surname).
	     *
	     * @return fullName
	     */
	    public function getFullName()
	    {
	        return $this->fullName;
	    }

	    /**
	     * Sets the Full name of the architect (name & surname).
	     *
	     * @param fullName $newFullName the full name
	     */
	    private function setFullName($newFullName)
	    {
	        $this->fullName = $newFullName;
	    }

	    /**
	     * Gets the Name of the art who participate to the art.
	     *
	     * @return nameArt
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art who participate to the art.
	     *
	     * @param nameArt $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}