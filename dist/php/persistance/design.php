<?php

	require_once 'connectionDB.php';

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

		/**
		Biography of the author
		@var biographyHTMLFile
		*/
		private $biographyHTMLFile;

		/**
		Connection database
		@var $db
		*/
		private $db;

		public function __construct ($nameAuthor, $nameArt, $biographyHTMLFile = null)
		{
			$this->db = connection();
			$this->nameAuthor = $nameAuthor;
			$this->nameArt = $nameArt;
			$this->biographyHTMLFile = $biographyHTMLFile;
		}

		/**
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO DESIGN(nameAuthor, nameArt, biographyHTMLFile) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->nameAuthor, $this->nameArt, $this->biographyHTMLFile));
		}

		/**
		* Test if exist in the database 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM DESIGN WHERE nameAuthor = ? AND nameArt = ?");
			$exist->execute(array($this->nameAuthor, $this->nameArt));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the biography for an architech correspond to an art
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE DESIGN SET
					biographyHTMLFile = ?
				WHERE nameAuthor = ? AND nameArt = ?");
			return $update->execute(array($this->biographyHTMLFile, $this->nameAuthor, $this->nameArt));
		}

		/**
	     * Gets the Biography of the author.
	     *
	     * @return biographyHTMLFile
	     */
	    public function getBiographyHTMLFile()
	    {
	        return $this->biographyHTMLFile;
	    }

	    /**
	     * Sets the Biography of the author.
	     *
	     * @param biographyHTMLFile $newBiographyHTMLFile the biography HTML file
	     */
	    private function setBiographyHTMLFile($newBiographyHTMLFile)
	    {
	        $this->biographyHTMLFile = $newBiographyHTMLFile;
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