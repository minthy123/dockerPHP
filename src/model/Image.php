<?php
	class Image {
		private $name;
		private $id;
		private $created;
		private $virtualSize;
		private $dockerVersion;
		private $author;
		private $os;
		private $architecture;
		private $size;
		private $tag;
		private $parentId;

		private $env;
		private $exposePorts;
		private $workingDir;
		private $entryPoint;

		public function __construct() {
			// no-contruct
		}

		public static function fromJSONObject($obj) {
			$instance = new self();

        	$instance->setName($obj['RepoTags'][0]);
			$instance->setSize($obj['Size']);
            $instance->setVirtualSize($obj['VirtualSize']);
            $instance->setCreated($obj['Created']);

            $instance->setId(str_replace("sha256:", "", $obj['Id']));
        	return $instance;
		}

        public static function fromJSONDetail($obj) {
            $instance = new self();

            $instance->setId($obj['Id']);
            $instance->setName($obj['RepoTags'][0]);
            $instance->setSize($obj['Size']);
            $instance->setVirtualSize($obj['VirtualSize']);
            $instance->setOS($obj['Os']);
            $instance->setAuthor($obj['Author']);
            $instance->setDockerVersion($obj['DockerVersion']);
            $instance->setArchitecture($obj['Architecture']);
            $instance->setCreated($obj['Created']);
            $instance->setParentId($obj['Parent']);

            //config
            $instance->setEnv($obj['Config']['Env']);
            $instance->setWorkingDir($obj['Config']['WorkingDir']);
            $instance->setEntryPoint($obj['Config']['Entrypoint']);
            $instance->setExposePorts(array_keys($obj['Config']['ExposedPorts']));

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

        /**
         * @return mixed
         */
        public function getVirtualSize()
        {
            return $this->virtualSize;
        }

        /**
         * @param mixed $virtualSize
         */
        public function setVirtualSize($virtualSize): void
        {
            $this->virtualSize = $virtualSize;
        }

        /**
         * @return mixed
         */
        public function getDockerVersion()
        {
            return $this->dockerVersion;
        }

        /**
         * @param mixed $dockerVersion
         */
        public function setDockerVersion($dockerVersion): void
        {
            $this->dockerVersion = $dockerVersion;
        }

        /**
         * @return mixed
         */
        public function getAuthor()
        {
            return $this->author;
        }

        /**
         * @param mixed $author
         */
        public function setAuthor($author): void
        {
            $this->author = $author;
        }

        /**
         * @return mixed
         */
        public function getOs()
        {
            return $this->os;
        }

        /**
         * @param mixed $os
         */
        public function setOs($os): void
        {
            $this->os = $os;
        }

        /**
         * @return mixed
         */
        public function getArchitecture()
        {
            return $this->architecture;
        }

        /**
         * @param mixed $architecture
         */
        public function setArchitecture($architecture): void
        {
            $this->architecture = $architecture;
        }

        /**
         * @return mixed
         */
        public function getEnv()
        {
            return $this->env;
        }

        /**
         * @param mixed $env
         */
        public function setEnv($env): void
        {
            $this->env = $env;
        }

        /**
         * @return mixed
         */
        public function getExposePorts()
        {
            return $this->exposePorts;
        }

        /**
         * @param mixed $exposePorts
         */
        public function setExposePorts($exposePorts): void
        {
            $this->exposePorts = $exposePorts;
        }

        /**
         * @return mixed
         */
        public function getWorkingDir()
        {
            return $this->workingDir;
        }

        /**
         * @param mixed $workingDir
         */
        public function setWorkingDir($workingDir): void
        {
            $this->workingDir = $workingDir;
        }

        /**
         * @return mixed
         */
        public function getEntryPoint()
        {
            return $this->entryPoint;
        }

        /**
         * @param mixed $entryPoint
         */
        public function setEntryPoint($entryPoint): void
        {
            $this->entryPoint = $entryPoint;
        }

        /**
         * @return mixed
         */
        public function getParentId()
        {
            return $this->parentId;
        }

        /**
         * @param mixed $parentId
         */
        public function setParentId($parentId): void
        {
            $this->parentId = $parentId;
        }

	}

?>