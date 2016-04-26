<?php
	class Type {
		/**
		Name of the type
		@var name
		*/
		private $name;

		public function __construct ($name)
		{
			$this->name = $name;
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