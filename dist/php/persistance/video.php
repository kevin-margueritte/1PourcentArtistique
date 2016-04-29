<?php
	class Video {

		require_once 'connectionDB.php';


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

		private $db;

		public function __construct ($titleFile, $nameArt)
		{
			$this->db = connection();
			$this->titleFile = $titleFile;
			$this->nameArt = $nameArt;
		}

		/**
		* Insert into video database whith title and name of the art
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO VIDEO(titleFile, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->titleFile, $this->nameArt));
		}

		/**
		* Test in the database if the video exist for an art
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM VIDEO WHERE titleFile = ? AND nameArt = ?");
			$exist->execute(array($this->titleFile, $this->nameArt));
			return count($exist->fetchAll()) >= 1;
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