<?php

	require_once 'connectionDB.php';

	class Photography {

		/**
		Name of the photography
		@var nameFile
		*/
		private $nameFile;

		/**
		Name of the art
		@var idArt
		*/
		private $idArt;

		private $db;

		public function __construct ($nameFile, $idArt)
		{
			$this->db = connection();
			$this->nameFile = $nameFile;
			$this->idArt = $idArt;
		}

		/**
		* Insert into photography with nameFile and idArt
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO PHOTOGRAPHY(nameFile, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameFile, $this->idArt));
		}

		public function delete() {
			$delete = $this->db->prepare("DELETE FROM PHOTOGRAPHY WHERE nameFile = ? AND idArt = ?");
			return $delete->execute(array($this->nameFile, $this->idArt));
		}

		/** 
		* Test if the name of the photography exist in the database
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM PHOTOGRAPHY WHERE nameFile = ? ");
			$exist->execute(array($this->nameFile));
			return count($exist->fetchAll()) >= 1;
		}
	
	    /**
	     * Gets the Name of the photography.
	     *
	     * @return nameFil
	     */
	    public function getNameFil()
	    {
	        return $this->nameFile;
	    }

	    /**
	     * Sets the Name of the photography.
	     *
	     * @param nameFil $newNameFil the name fil
	     */
	    private function setNameFil($newNameFile)
	    {
	        $this->nameFile = $newNameFile;
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