<?php
	
	require_once 'connectionDB.php';
	
	class Compose {

<<<<<<< HEAD
=======
		require_once 'connectionDB.php';

>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
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

<<<<<<< HEAD
		public function __construct ($nameMaterial, $idArt)
=======
		private $db;

		public function __construct ($nameMaterial, $nameArt)
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
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
		* Save in the database 
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO COMPOSE(nameMaterial, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameMaterial, $this->nameArt));
		}

		/**
		* Test if exist in the database 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM COMPOSE WHERE nameMaterial = ? AND nameArt = ?");
			$exist->execute(array($this->nameMaterial, $this->nameArt));
			return count($exist->fetchAll()) >= 1;
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