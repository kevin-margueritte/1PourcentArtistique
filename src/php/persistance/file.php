<?php
	class File {

		private $src;
		private $artName;

		public function __construct ($artName) {
			$this->src = $_SERVER["DOCUMENT_ROOT"].'/assets/oeuvres/';
			$this->artName = str_replace(' ','_', $artName);
		}

		function createFolder() {
			if ( !file_exists($this->src . $this->artName) ) {
				mkdir($this->src . $this->artName, 0700, true);
			}
		}

		function deleteFolder () {
			return File::DeleteFolderAux($this->src . $this->artName . '/');
		}

		private static function deleteFolderAux($dir) {
			$files = array_diff(scandir($dir), array('.','..')); 
		    foreach ($files as $file) { 
		      (is_dir("$dir/$file")) ? File::deleteFolderAux("$dir/$file") : unlink("$dir/$file"); 
		    } 
		    return rmdir($dir);
		}

		function renameFolder($newName) {
			if (!file_exists($this->src . $newName)) {
				rename($this->src . $newName, $this->src . $this->artName);
			}
		}

		function uploadFile($file) {
			if (!empty($file)) {
				move_uploaded_file($file['tmp_name'], $this->src . $this->artName . '/' . $file['name']);
			}
		}

		function removeFile($nameFile) {
			if (file_exists($this->src . $this->artName . '/' . $nameFile)) {
				return unlink($this->src . $this->artName . '/' .$nameFile);
			}
			return false;
		}

		function getSrc() {
			return $this->src;
		}

		function getOeuvreName() {
			return $this->oeuvreName;
		}

		function createDescriptionHTMLFile($content) {
			file_put_contents($this->src . $this->artName . '/' . 'description.html', $content);
		}

		function createHistoricHTMLFile($content) {
			file_put_contents($this->src . $this->artName . '/' . 'historic.html', $content);
		}

		function createBiographyHTMLFile($content, $authorName) {
			file_put_contents($this->src . $this->artName . '/' . 'biography' . str_replace(' ','_', $authorName) .'.html', $content);
		}

	}

