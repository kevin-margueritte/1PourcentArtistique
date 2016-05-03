<?php
	
	require_once 'connectionDB.php';
	
	class Historic {

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
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO HISTORIC(nameFile, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameFile, $this->idArt));
		}

		/**
		* Test if exist in the databse 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM HISTORIC WHERE nameFile = ? AND idArt  = ? ");
			$exist->execute(array($this->nameFile, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		public function delete() {
			$delete = $this->db->prepare("DELETE FROM HISTORIC WHERE nameFile = ? AND idArt = ?");
			return $delete->execute(array($this->nameFile, $this->idArt));
		}
	
	    /**
	     * Gets the Name of the photography.
	     *
	     * @return nameFile
	     */
	    public function getNameFil()
	    {
	        return $this->nameFile;
	    }

	    /**
	     * Sets the Name of the photography.
	     *
	     * @param nameFile $newNameFile the name file
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