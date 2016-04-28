<?php
	class Material {

		require_once 'connectionDB.php';

		/**
		Name of the material used for the art
		@var name
		*/
		private $name;

		private $db;

		public function __construct ($name)
		{
			$this->db = connection();
			$this->name = $name;
		}

		/**
		* Insert into material
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO MATERIAL(name) 
				VALUES (?)");
			return $insert->execute(array($this->name));
		}

		/**
		* Test if the material exist in the database
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM MATERIAL WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the name of the material in the database
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE MATERIAL SET
					name = ?
				WHERE name = ?");
			return $update->execute(array($this->name, $this->name));
		}

	    /**
	     * Gets the Name of the material used for the art.
	     *
	     * @return name
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the Name of the material used for the art.
	     *
	     * @param name $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
	    }
	}