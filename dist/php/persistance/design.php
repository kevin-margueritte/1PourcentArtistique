<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Design {
		/**
		* Full name of the author
		* @var string
		*/
		private $nameAuthor;

		/**
		* ID of the art
		* @var integer
		*/
		private $idArt;

		/**
		* Biography of the author
		* @var string
		*/
		private $biographyHTMLFile;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $nameAuthor
		* @param integer $idArt
		* @param string biographyHTMLFile
		*/
		public function __construct ($nameAuthor, $idArt, $biographyHTMLFile = null)
		{
			$this->db = connection();
			$this->nameAuthor = $nameAuthor;
			$this->idArt = $idArt;
			$this->biographyHTMLFile = $biographyHTMLFile;
		}

		/**
		* Save in the database
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO DESIGN(nameAuthor, idArt, biographyHTMLFile) 
				VALUES (?, ?, ?)");
			return $insert->execute(array($this->nameAuthor, $this->idArt, $this->biographyHTMLFile));
		}

		/**
		* Test if an author have designed an art by the name of the author an the id of the art
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM DESIGN WHERE nameAuthor = ? AND idArt = ?");
			$exist->execute(array($this->nameAuthor, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the biography for an author correspond to an art
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE DESIGN SET
					biographyHTMLFile = ?
				WHERE nameAuthor = ? AND idArt = ?");
			return $update->execute(array($this->biographyHTMLFile, $this->nameAuthor, $this->idArt));
		}

		/**
		* Delete the designed by the name of the author and the id of the art
		* @return If the deletion worked
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
	     * @param string $newBiographyHTMLFile the biography HTML file
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
	     * @param string $newNameAuthor the name author
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
	     * @param integer $newidArt the name art
	     */
	    private function setidArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}