<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Video {

		/**
		* Name of the video file
		* @var string
		*/
		private $titleFile;

		/**
		* Name of the art
		* @var integer
		*/
		private $idArt;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $titleFile
		* @param integer $idArt
		*/
		public function __construct ($titleFile, $idArt)
		{
			$this->db = connection();
			$this->titleFile = $titleFile;
			$this->idArt = $idArt;
		}

		/**
		* Save the video for an art in the database
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO VIDEO(titleFile, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->titleFile, $this->idArt));
		}

		/**
		* Test Test in the database if the video exist for an art by his name and the id
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM VIDEO WHERE titleFile = ? AND idArt = ?");
			$exist->execute(array($this->titleFile, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Delete the video of an art with his name and the id of the art
		* @return If the deletion worked
		*/
		function delete() {
			$delete = $this->db->prepare("DELETE FROM VIDEO WHERE titleFile = ? AND idArt = ?");
			return $delete->execute(array($this->titleFile, $this->idArt));
		}

	    /**
	     * Gets the Name of the video file.
	     *
	     * @return string
	     */
	    public function getTitleFile()
	    {
	        return $this->titleFile;
	    }

	    /**
	     * Sets the Name of the video file.
	     *
	     * @param string $newTitleFile the title file
	     */
	    private function setTitleFile($newTitleFile)
	    {
	        $this->titleFile = $newTitleFile;
	    }

	    /**
	     * Gets the Name of the art.
	     *
	     * @return integer
	     */
	    public function getidArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param integer $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}