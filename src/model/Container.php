<?php
	require_once('Image.php');
	require_once('Port.php');

	class Container {
		
		private $id;
		private $name;
		private $created;
		private $state;
		private $status;

		private $image;

		private $ports;

		public function __construct() {
			//no-construct
		}

		public static function fromJSONObject($obj) {
			$instance = new self();

			//container
			$instance->setName($obj['Names'][0]);
			$instance->setId($obj['Id']);
			$instance->setStatus($obj['Status']);
			$instance->setState($obj['State']);

			//image
			$image = new Image();
			$image->setName($obj['Image']);
			$image->setId($obj['ImageID']);
			$instance->setImage($image);

			//ports
			$ports = [];
			foreach ($obj['Ports'] as $key=>$jsonPort) {
				array_push($ports, Port::fromJSONObject($jsonPort));
			}
			$instance->setPorts($ports);

			return $instance;
		}

		public function getName() {
			return $this->name;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function setTag($tag) {
			$this->tag = $tag;
		}

		public function getTag() {
			return $this->tag;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}

		public function setStatus($status) {
			$this->status = $status;
		}

		public function getStatus() {
			return $this->status;
		}

		public function setState($state) {
			$this->state = $state;
		}

		public function getState() {
			return $this->state;
		}

		public function setImage($image) {
			$this->image = $image;
		}

		public function getImage() {
			return $this->image;
		}

		public function setPorts($ports) {
			$this->ports = $ports;
		}

		public function getPorts() {
			return $this->ports;
		}
	}

?>