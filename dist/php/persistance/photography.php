<?php
	class Photography {

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
		* Insert into photography with nameFile and nameArt
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO PHOTOGRAPHY(nameFile, nameArt) 
				VALUES (?, ?)");
			return $insert->execute(array($this->nameFil, $this->nameArt));
		}

		/** 
		* Test if the name of the photography exist in the database
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM PHOTOGRAPHY WHERE nameFile = ? ");
			$exist->execute(array($this->nameFil));
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