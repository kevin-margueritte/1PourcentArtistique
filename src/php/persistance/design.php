<?php

	require_once 'connectionDB.php';

	class Design {
		/**
		Full name of the author
		@var nameAuthor
		*/
		private $nameAuthor;

		/**
		ID of the art
		@var idArt
		*/
		private $idArt;

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

		public function __construct ($nameAuthor, $idArt, $biographyHTMLFile = null)
		{
			$this->db = connection();
			$this->nameAuthor = $nameAuthor;
			$this->idArt = $idArt;
			$this->biographyHTMLFile = $biographyHTMLFile;
		}

		/**
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO DESIGN(nameAuthor, idArt, biographyHTMLFile) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->nameAuthor, $this->idArt, $this->biographyHTMLFile));
		}

		/**
		* Test if exist in the database 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM DESIGN WHERE nameAuthor = ? AND idArt = ?");
			$exist->execute(array($this->nameAuthor, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the biography for an architech correspond to an art
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE DESIGN SET
					biographyHTMLFile = ?
				WHERE nameAuthor = ? AND idArt = ?");
			return $update->execute(array($this->biographyHTMLFile, $this->nameAuthor, $this->idArt));
		}

		/**
		* Delete design
		*/
		function delete() {
			$delete = $this->db->prepare("DELETE FROM DESIGN WHERE idArt = ? AND nameAuthor = ?");
			return $delete->execute(array($this->idArt, $this->nameAuthor));
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
	    public function setBiographyHTMLFile($newBiographyHTMLFile)
	    {
	        $this->biographyHTMLFile = $newBiographyHTMLFile;
	    	$insert = $this->db->prepare("UPDATE DESIGN SET biographyHTMLFile = ? WHERE idArt = ? AND nameAuthor = ?");
	    	return $insert->execute(array($newBiographyHTMLFile, $this->idArt, $this->nameAuthor));
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