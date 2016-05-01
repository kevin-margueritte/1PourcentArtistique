<?php
	
	require_once 'connectionDB.php';
	
	class Compose {

		/**
		Name of the material used by art
		@var nameMaterial
		*/
		private $nameMaterial;

		/**
		Id of the art
		@var idArt
		*/
		private $idArt;

		private $db;

		public function __construct ($nameMaterial, $idArt)
		{
			$this->db = connection();
			$this->nameMaterial = $nameMaterial;
			$this->idArt = $idArt;
		}

		/**
		* Save in the database 
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO COMPOSE(nameMaterial, idArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameMaterial, $this->idArt));
		}

		/**
		* Test if exist in the database 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM COMPOSE WHERE nameMaterial = ? AND idArt = ?");
			$exist->execute(array($this->nameMaterial, $this->idArt));
			return count($exist->fetchAll()) >= 1;
		}

		function delete() {
			$delete = $this->db->prepare("DELETE FROM COMPOSE WHERE nameMaterial = ? AND idArt = ?");
			return $delete->execute(array($this->nameMaterial, $this->idArt));
		}
	
	    /**
	     * Gets the Name of the material used by art.
	     *
	     * @return nameMaterial
	     */
	    public function getNameMaterial()
	    {
	        return $this->nameMaterial;
	    }

	    /**
	     * Sets the Name of the material used by art.
	     *
	     * @param nameMaterial $newNameMaterial the name material
	     */
	    private function setNameMaterial($newNameMaterial)
	    {
	        $this->nameMaterial = $newNameMaterial;
	    }

	    /**
	     * Gets the Name of the art.
	     *
	     * @return idArt
	     */
	    public function getIdArt()
	    {
	        return $this->idArt;
	    }

	    /**
	     * Sets the Name of the art.
	     *
	     * @param idArt $newidArt the name art
	     */
	    private function setIdArt($newidArt)
	    {
	        $this->idArt = $newidArt;
	    }
	}