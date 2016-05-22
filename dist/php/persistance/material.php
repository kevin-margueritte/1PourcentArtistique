<?php
	/*Connects to the database*/
	require_once 'connectionDB.php';

	class Material {

		/**
		* Name of the material used for the art
		* @var string
		*/
		private $name;

		/**
		* Connexion on the database 
		* @var string
		*/
		private $db;

		/**
		* Constructor
		* @param string $name
		*/
		public function __construct ($name = null)
		{
			$this->db = connection();
			$this->name = $name;
		}

		/**
		* Save the material in the database with his name
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO MATERIAL VALUES (?)");
			return $insert->execute(array($this->name));
		}

		/**
		* Test if the material already existe in the databse by his name 
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM MATERIAL WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		 * Update the name of the material by his name
		 * @return If the update worked
		 */
		function update () {
			$update = $this->db->prepare(
				"UPDATE MATERIAL SET
					name = ?
				WHERE name = ?");
			return $update->execute(array($this->name, $this->name));
		}

		/**
		 * Retrieves all informations about material in the database
		 * @return All material
		 */
		function getAll() {
			$get = $this->db->prepare("SELECT name FROM MATERIAL");
			$get->execute();
			return $get->fetchAll(PDO::FETCH_COLUMN, 0);
		}

	    /**
	     * Gets the Name of the material used for the art.
	     *
	     * @return string
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the Name of the material used for the art.
	     *
	     * @param string $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
	    }
	}