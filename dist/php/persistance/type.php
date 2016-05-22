<?php
	class Type {
		/*Connects to the database*/
		require_once 'connectionDB.php';

		/**
		* Name of the type
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
		public function __construct ($name)
		{
			$this->db = connection();
			$this->name = $name;
		}

		/**
		* Save the type for an art
		* @return If it is save
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO TYPE(name) 
				VALUES (?)");
			return $insert->execute(array($this->name));
		}


		/**
		* Test if the name of the type already exist in the database  by his name
		* @return integer 0 or 1
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM TYPE WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the name of the type in the database
		* * @return If the update worked
		*/
		function update () {
			$update = $this->db->prepare(
				"UPDATE TYPE SET
					name = ?
				WHERE name = ?");
			return $update->execute(array($this->name,$this->name));
		}

		/**
	    * Gets the Name of the localisation.
	    *
	    * @return string
	    */
		public function getName() {
			return $this->name;
		}

		/**
		* Sets the Name of the localisation.
		*
		* @param string $newName the name
		*/
		public function setName($newName) {
			$this->name = $newName;
		}
	}