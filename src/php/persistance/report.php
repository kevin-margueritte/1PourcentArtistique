<?php

	/********
	****** A SUPPRIMER - N'EST PAS UTILISE !!!
	*********/

	require_once 'connectionDB.php';

	class Report {

		/**
		Name of the video file
		@var titleFileVideo
		*/
		private $titleFileVideo;

		/**
		Name of the art who correspond the video
		@idArt
		*/
		private $idArt;

		private $db;

		public function __construct ($idArt, $titleFileVideo)
		{
			$this->db = connection();
			$this->idArt = $idArt;
			$this->titleFileVideo = $titleFileVideo;
		}

		/**
		* Insert into report with title for an art
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO REPORT(titleFileVideo, idArt) 
				VALUES (?, ?)");
			$insert->execute(array($this->titleFileVideo, $this->idArt));
			var_dump($insert->errorInfo());
			return $insert->execute(array($this->titleFileVideo, $this->idArt));
		}

		/**
		* Test if the report exist in the database with title video for an art
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM REPORT WHERE titleFileVideo = ? AND idArt = ?");
			$exist->execute(array($this->titleFileVideo, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		function delete() {
			$delete = $this->db->prepare("DELETE FROM REPORT WHERE titleFileVideo = ? AND idArt = ?");
			return $delete->execute(array($this->titleFileVideo, $this->idArt));
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
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art who correspond the video.
	     *
	     * @param  $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}