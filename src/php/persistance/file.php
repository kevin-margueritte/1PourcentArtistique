<?php
	class File {

		private $src;
		private $artName;

		public function __construct ($artName) {
			$this->src = $_SERVER["DOCUMENT_ROOT"].'/assets/oeuvres/';
			$this->artName = $artName;
		}

		function createFolder() {
			if ( !file_exists($this->src . $this->artName) ) {
				mkdir($this->src . $this->artName, 0700, true);
			}
		}

		function renameFolder($newName) {
			rename($this->src . $newName, $this->src . $this->artName);
		}

		function uploadFile($file) {
			if (!empty($file)) {
				move_uploaded_file($file['tmp_name'], $this->src . $this->artName . '/' . $file['name']);
			}
		}

		function removeFile($nameFile) {
			return unlink($this->src . $this->artName . '/' .$nameFile);
		}

		function getSrc() {
			return $this->src;
		}

		function getOeuvreName() {
			return $this->oeuvreName;
		}

	}

