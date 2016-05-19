<?php
	class File {

		/**
		* Path of the file
		* @var string
		*/
		private $src;

		/**
		* Name of the art
		* @var string
		*/
		private $artName;

		/**
		* Constructor
		* @param string $artName
		*/
		public function __construct ($artName) {
			$this->src = $_SERVER["DOCUMENT_ROOT"].'/assets/oeuvres/';
			$this->artName = str_replace(' ','_', $artName);
		}

		/**
		 * Create a folder with the name of the art
		 */
		function createFolder() {
			if ( !file_exists($this->src . $this->artName) ) {
				mkdir($this->src . $this->artName, 0700, true);
			}
		}

		/**
		 * Delete a folder with the name of the art
		 */
		function deleteFolder () {
			return File::DeleteFolderAux($this->src . $this->artName . '/');
		}

		/**
		 * Delete the file in the folder before delete the folder
		 */
		private static function deleteFolderAux($dir) {
			$files = array_diff(scandir($dir), array('.','..')); 
		    foreach ($files as $file) { 
		      (is_dir("$dir/$file")) ? File::deleteFolderAux("$dir/$file") : unlink("$dir/$file"); 
		    } 
		    return rmdir($dir);
		}

		/**
		 * Rename the folder by the new name of the art
		 */
		function renameFolder($newName) {
			if (!file_exists($this->src . $newName)) {
				rename($this->src . $newName, $this->src . $this->artName);
			}
		}

		/**
		 * Permit to upload a file in the folder of the art
		 */
		function uploadFile($file) {
			if (!empty($file)) {
				move_uploaded_file($file['tmp_name'], $this->src . $this->artName . '/' . $file['name']);
			}
		}

		/**
		 * Permit to remove a file in the folder of the art
		 */
		function removeFile($nameFile) {
			if (file_exists($this->src . $this->artName . '/' . $nameFile)) {
				return unlink($this->src . $this->artName . '/' .$nameFile);
			}
			return false;
		}

		/**
	     * Get the source of the file
	     *
	     * @return string $src
	     */
		function getSrc() {
			return $this->src;
		}

		/**
	     * Get the name of the art
	     *
	     * @return string $oeuvreName
	     */
		function getOeuvreName() {
			return $this->oeuvreName;
		}

		/**
		 * Upload the file containing the description of the art
		 */
		function createDescriptionHTMLFile($content) {
			file_put_contents($this->src . $this->artName . '/' . 'description.html', $content);
		}

		/**
		 * Upload the file containing the historic of the art
		 */
		function createHistoricHTMLFile($content) {
			file_put_contents($this->src . $this->artName . '/' . 'historic.html', $content);
		}

		/**
		 * Upload the file containing the biography of the art
		 */
		function createBiographyHTMLFile($content, $authorName) {
			file_put_contents($this->src . $this->artName . '/' . 'biography' . str_replace(' ','_', $authorName) .'.html', $content);
		}

	}