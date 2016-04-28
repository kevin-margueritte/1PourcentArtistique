<?php
	class Report {

		require_once 'connectionDB.php';


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

		private $db;

		public function __construct ($nameArt, $titleFileVideo)
		{
			$this->db = connection();
			$this->nameArt = $nameArt;
			$this->titleFileVideo = $titleFileVideo;
		}

		/**
		* Insert into report with title for an art
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO REPORT(titleFileVideo, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->titleFileVideo, $this->nameArt));
		}

		/**
		* Test if the report exist in the database with title video for an art
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM REPORT WHERE titleFileVideo = ? AND nameArt = ?");
			$exist->execute(array($this->titleFileVideo, $this->nameArt));
			return count($exist->fetchAll()) >= 1;
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