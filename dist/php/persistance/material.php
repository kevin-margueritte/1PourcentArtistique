<?php

	require_once 'connectionDB.php';

	class Material {

<<<<<<< HEAD
=======
		require_once 'connectionDB.php';

>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		/**
		Name of the material used for the art
		@var name
		*/
		private $name;

		private $db;

<<<<<<< HEAD
		public function __construct ($name = null)
=======
		public function __construct ($name)
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
		{
			$this->db = connection();
			$this->name = $name;
		}

		/**
		* Insert into material
		*/
		public function save () {
<<<<<<< HEAD
			$insert = $this->db->prepare("INSERT INTO MATERIAL VALUES (?)");
=======
			$insert = $this->db->prepare("INSERT INTO MATERIAL(name) 
				VALUES (?)");
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
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

<<<<<<< HEAD
		/**
		* Get all material
		*/
		function getAll() {
			$get = $this->db->prepare("SELECT name FROM MATERIAL");
			$get->execute();
			return $get->fetchAll(PDO::FETCH_COLUMN, 0);
		}

=======
>>>>>>> 2aac822b22c85f8e9f310618b46d871e8a447bab
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