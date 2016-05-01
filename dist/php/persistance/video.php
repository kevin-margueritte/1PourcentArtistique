<?php

	require_once 'connectionDB.php';

	class Video {

		/**
		Name of the video file
		@var titleFile
		*/
		private $titleFile;

		/**
		Name of the art
		@var idArt
		*/
		private $idArt;

		private $db;

		public function __construct ($titleFile, $idArt)
		{
			$this->db = connection();
			$this->titleFile = $titleFile;
			$this->idArt = $idArt;
		}

		/**
		* Insert into video database whith title and name of the art
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO VIDEO(titleFile, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->titleFile, $this->idArt));
		}

		/**
		* Test in the database if the video exist for an art
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM VIDEO WHERE titleFile = ? AND idArt = ?");
			$exist->execute(array($this->titleFile, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		function delete() {
			$delete = $this->db->prepare("DELETE FROM VIDEO WHERE titleFile = ? AND idArt = ?");
			return $delete->execute(array($this->titleFile, $this->idArt));
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
	     * @return idArt
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param idArt $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}