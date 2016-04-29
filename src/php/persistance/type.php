<?php
	class Type {

		require_once 'connectionDB.php';

		/**
		Name of the type
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
		* Insert in the database the name of the type
		*/
		public function save () {
			$insert = $this->db->prepare("INSERT INTO TYPE(name) 
				VALUES (?)");
			return $insert->execute(array($this->name));
		}

		/**
		* Test if the name of the type already exist in the database 
		*/
		function exist() {
			$exist = $this->db->prepare("SELECT 1 FROM TYPE WHERE name = ? ");
			$exist->execute(array($this->name));
			return count($exist->fetchAll()) >= 1;
		}

		/**
		* Update the name of the type in the database
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
	    * @return name
	    */
		public function getName() {
			return $this->name;
		}

		/**
		* Sets the Name of the localisation.
		*
		* @param name $newName the name
		*/
		public function setName($newName) {
			$this->name = $newName;
		}
	}