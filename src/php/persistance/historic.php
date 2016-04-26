<?php
	class Historic {
		/**
		Name of the photography
		@var nameFil
		*/
		private $nameFil;

		/**
		Name of the art
		@var nameArt
		*/
		private $nameArt;

		public function __construct ($nameFil, $nameArt)
		{
			$this->nameFil = $nameFil;
			$this->nameArt = $nameArt;
		}
	
	    /**
	     * Gets the Name of the photography.
	     *
	     * @return nameFil
	     */
	    public function getNameFil()
	    {
	        return $this->nameFil;
	    }

	    /**
	     * Sets the Name of the photography.
	     *
	     * @param nameFil $newNameFil the name fil
	     */
	    private function setNameFil($newNameFil)
	    {
	        $this->nameFil = $newNameFil;
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