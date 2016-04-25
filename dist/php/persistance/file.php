<?php
	class File {

		private $src;
		private $oeuvreName;

		public function __construct ($oeuvreName) {
			$this->src = $_SERVER["DOCUMENT_ROOT"].'/assets/oeuvres/';
			$this->oeuvreName = $oeuvreName;
		}

		function createFolder() {
			if ( !file_exists($this->src . $this->oeuvreName) ) {
				mkdir($this->src . $this->oeuvreName, 0700, true);
			}
		}

		function uploadFile($file) {
			if (!empty($file)) {
				move_uploaded_file($file['tmp_name'], $this->src . $this->oeuvreName . '/' . $file['name']);
			}
		}

		function removeFile($nameFile) {
			return unlink($this->src . $this->oeuvreName . '/' .$nameFile);
		}

	}