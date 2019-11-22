<?php
	class OSAndLibraries {
		private $os;

		private $libraries;

		public function __construct($os, $libraries) {
			$this->os = $os;
			$this->libraries = $libraries;
		}

		function getOS() {
			return $this->os;
		}

		function setOS($os) {
			$this->os = $os;
		}

		function setLibraries($libraries) {
			$this->libraries = $libraries;
		}

		function getLibraries() {
			return $this->libraries;
		}
	}
?>