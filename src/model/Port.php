<?php
	class Port {
		private $ip;
		private $privatePort;
		private $publicPort;
		private $type;

		public function __construct() {
			// no-contruct
		}

		public static function fromJSONObject($obj) {
			$instance = new self();
			$instance->setIP($obj["IP"]);
			$instance->setPrivatePort($obj["PrivatePort"]);
			$instance->setPublicPort($obj["PublicPort"]);
			$instance->setType($obj["Type"]);

			return $instance;
		}

		public function getIP() {
			return $this->ip;
		}

		public function setIP($ip) {
			$this->ip = $ip;
		}

		public function setPrivatePort($privatePort) {
			$this->privatePort = $privatePort;
		}

		public function getPrivatePort() {
			return $this->privatePort;
		}

		public function setPublicPort($publicPort) {
			$this->publicPort = $publicPort;
		}

		public function getPublicPort() {
			return $this->publicPort;
		}

		public function setType($type) {
			$this->type = $type;
		}

		public function getType() {
			return $this->type;
		}
	}

?>