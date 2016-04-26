<?php
	class Material {
		/**
		Name of the material used for the art
		@var name
		*/
		private $name;

		public function __construct ($name)
		{
			$this->name = $name;
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