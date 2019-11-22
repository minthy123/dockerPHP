<?php
	class Image {
		private $name;
		private $id;
		private $created;
		private $tag;

		public function __construct() {
			// no-contruct
		}

		public static function fromJSONObject($obj) {
			$instance = new self();

        	$instance->setName($obj['RepoTags'][0]);
			$instance->setSize($obj['Size']);
			$instance->setId(str_replace("sha256:", "", $obj['Id']));
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

		public function setSize($size) {
			$this->size = $size;
		}

		public function getSize() {
			return $this->size;
		}

		public function setCreated($created) {
			$this->created = $created;
		}

		public function getCreated() {
			return $this->created;
		}
	}

?>