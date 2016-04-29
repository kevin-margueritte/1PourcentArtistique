<?php
	class Historic {

		require_once 'connectionDB.php';

		/**
		Name of the photography
		@var nameFil
		*/
		private $nameFil;

		/**
		Name of the art
		@var nameArt
		*/
		private $nameArt;

		private $db;

		public function __construct ($nameFil, $nameArt)
		{
			$this->db = connection();
			$this->nameFil = $nameFil;
			$this->nameArt = $nameArt;
		}

		/**
		* Save in the database
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO HISTORIC(nameFile, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameFil, $this->nameArt));
		}

		/**
		* Test if exist in the databse 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM HISTORIC WHERE nameFile = ? AND nameArt  = ? ");
			$exist->execute(array($this->nameFil, $this->nameArt));
			return count($exist->fetchAll()) >= 1;
		}
	
	    /**
	     * Gets the Name of the photography.
	     *
	     * @return nameFil
	     */
	    public function getNameFil()
	    {
	        return $this->nameFil;
	    }

	    /**
	     * Sets the Name of the photography.
	     *
	     * @param nameFil $newNameFil the name fil
	     */
	    private function setNameFil($newNameFil)
	    {
	        $this->nameFil = $newNameFil;
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