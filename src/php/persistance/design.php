<?php
	class Design {
		/**
		Full name of the author
		@var nameAuthor
		*/
		private $nameAuthor;

		/**
		Name of the art
		@var nameArt
		*/
		private $nameArt;

		public function __construct ($nameAuthor, $nameArt)
		{
			$this->nameAuthor = $nameAuthor;
			$this->nameArt = $nameArt;
		}
	
	    /**
	     * Gets the Full name of the author.
	     *
	     * @return nameAuthor
	     */
	    public function getNameAuthor()
	    {
	        return $this->nameAuthor;
	    }

	    /**
	     * Sets the Full name of the author.
	     *
	     * @param nameAuthor $newNameAuthor the name author
	     */
	    private function setNameAuthor($newNameAuthor)
	    {
	        $this->nameAuthor = $newNameAuthor;
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