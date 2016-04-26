<?php
	class Compose {
		/**
		Name of the material used by art
		@var nameMaterial
		*/
		private $nameMaterial;

		/**
		Name of the art
		@var nameArt
		*/
		private $nameArt;

		public function __construct ($nameMaterial, $nameArt)
		{
			$this->nameMaterial = $nameMaterial;
			$this->nameArt = $nameArt;
		}
	
	    /**
	     * Gets the Name of the material used by art.
	     *
	     * @return nameMaterial
	     */
	    public function getNameMaterial()
	    {
	        return $this->nameMaterial;
	    }

	    /**
	     * Sets the Name of the material used by art.
	     *
	     * @param nameMaterial $newNameMaterial the name material
	     */
	    private function setNameMaterial($newNameMaterial)
	    {
	        $this->nameMaterial = $newNameMaterial;
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