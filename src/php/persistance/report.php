<?php
	class Report {
		/**
		Name of the video file
		@var titleFileVideo
		*/
		private $titleFileVideo;

		/**
		Name of the art who correspond the video
		@nameArt
		*/
		private $nameArt;

		public function __construct ($nameArt, $titleFileVideo)
		{
			$this->nameArt = $nameArt;
			$this->titleFileVideo = $titleFileVideo;
		}

	    /**
	     * Gets the Name of the video file.
	     *
	     * @return titleFileVideo
	     */
	    public function getTitleFileVideo()
	    {
	        return $this->titleFileVideo;
	    }

	    /**
	     * Sets the Name of the video file.
	     *
	     * @param titleFileVideo $newTitleFileVideo the title file video
	     */
	    private function setTitleFileVideo($newTitleFileVideo)
	    {
	        $this->titleFileVideo = $newTitleFileVideo;
	    }

	    /**
	     * Gets the Name of the art who correspond the video.
	     *
	     * @return 
	     */
	    public function getNameArt()
	    {
	        return $this->nameArt;
	    }

	    /**
	     * Sets the Name of the art who correspond the video.
	     *
	     * @param  $newNameArt the name art
	     */
	    private function setNameArt($newNameArt)
	    {
	        $this->nameArt = $newNameArt;
	    }
	}