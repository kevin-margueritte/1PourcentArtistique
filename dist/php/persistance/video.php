<?php
	class Video {
		/**
		Name of the video file
		@var titleFile
		*/
		private $titleFile;

		/**
		Name of the art
		@var nameArt
		*/
		private $nameArt;

		public function __construct ($titleFile, $nameArt)
		{
			$this->titleFile = $titleFile;
			$this->nameArt = $nameArt;
		}

	
	    /**
	     * Gets the Name of the video file.
	     *
	     * @return titleFile
	     */
	    public function getTitleFile()
	    {
	        return $this->titleFile;
	    }

	    /**
	     * Sets the Name of the video file.
	     *
	     * @param titleFile $newTitleFile the title file
	     */
	    private function setTitleFile($newTitleFile)
	    {
	        $this->titleFile = $newTitleFile;
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