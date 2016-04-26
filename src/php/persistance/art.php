<?php
	class Art {
		/**
		Name of the art
		@var name
		*/
		private $name;

		/**
		Date of creation
		var @creationDate
		*/
		private $creationDate;

		/**
		*/
		private $presentationHTMLFile;

		/**
		*/
		private $historiqueHTMLFile;

		/**
		*/
		private $sonFile;

		/**
		Know if the art is public or not
		@var isPublic
		*/
		private $isPublic;

		/**
		Type of the art
		@var type
		*/
		private $type;

		public function construct ($name, $creationDate, $presentationHTMLFile, $historiqueHTMLFile, $sonFile, $isPublic, $type)
		{
			$this->name = $name;
			$this->creationDate = $creationDate;
			$this->presentationHTMLFile = $presentationHTMLFile;
			$this->historiqueHTMLFile = $historiqueHTMLFile;
			$this->sonFile = $sonFile;
			$this->isPublic = $isPublic;
			$this->type = $type;
		}

	
	    /**
	     * Gets the value of name.
	     *
	     * @return name
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Sets the value of name.
	     *
	     * @param $newName the name
	     */
	    private function setName($newName)
	    {
	        $this->name = $newName;
	    }

	    /**
	     * Gets the value of creationDate.
	     *
	     * @return creationDate
	     */
	    public function getCreationDate()
	    {
	        return $this->creationDate;
	    }

	    /**
	     * Sets the value of creationDate.
	     *
	     * @param  $newCreationDate the creation date
	     */
	    private function setCreationDate($newCreationDate)
	    {
	        $this->creationDate = $newCreationDate;
	    }

	    /**
	     * Gets the value of presentationHTMLFile.
	     *
	     * @return presentationHTMLFile
	     */
	    public function getPresentationHTMLFile()
	    {
	        return $this->presentationHTMLFile;
	    }

	    /**
	     * Sets the value of presentationHTMLFile.
	     *
	     * @param  $newPresentationHTMLFile the presentation HTML lfile
	     */
	    private function setPresentationHTMLFile($newPresentationHTMLFile)
	    {
	        $this->presentationHTMLFile = $newPresentationHTMLFile;
	    }

	    /**
	     * Gets the value of historiqueHTMLFile.
	     *
	     * @return historiqueHTMLFile
	     */
	    public function getHistoriqueHTMLFile()
	    {
	        return $this->historiqueHTMLFile;
	    }

	    /**
	     * Sets the value of historiqueHTMLFile.
	     *
	     * @param  $newHistoriqueHTMLFile the historique HTML file
	     */
	    private function setHistoriqueHTMLFile($newHistoriqueHTMLFile)
	    {
	        $this->historiqueHTMLFile = $newHistoriqueHTMLFile;
	    }

	    /**
	     * Gets the value of sonFile.
	     *
	     * @return sonFile
	     */
	    public function getSonFile()
	    {
	        return $this->sonFile;
	    }

	    /**
	     * Sets the value of sonFile.
	     *
	     * @param  $newSonFile the son file
	     */
	    private function setSonFile($newSonFile)
	    {
	        $this->sonFile = $newSonFile;
	    }

	    /**
	     * Gets the value of isPublic.
	     *
	     * @return isPublic
	     */
	    public function getIsPublic()
	    {
	        return $this->isPublic;
	    }

	    /**
	     * Sets the value of isPublic.
	     *
	     * @param  $newIsPublic the is public
	     */
	    private function setIsPublic($newIsPublic)
	    {
	        $this->isPublic = $newIsPublic;
	    }

	    /**
	     * Gets the value of type.
	     *
	     * @return type
	     */
	    public function getType()
	    {
	        return $this->type;
	    }

	    /**
	     * Sets the value of type.
	     *
	     * @param  $newType the type
	     */
	    private function setType($newType)
	    {
	        $this->type = $newType;
	    }
	}