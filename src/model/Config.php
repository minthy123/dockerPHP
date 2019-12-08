<?php
//    include_once ("Host.php");

    class Config {
        private $projectName;
        private $version;
        private $uploadFolder;
		private $dockerfileFolder;
		private $dockerSocketPath;
        private $dockerCount;
        private $portTerminal;
        private $portExecContainer;
//        private $hosts;

        public function __construct() {
            //no construct
        }

        public static function fromJSONObject($obj) {
            $instance = new self();

            $instance->setProjectName($obj['project_name']);
            $instance->setVersion($obj['version']);
            $instance->setUploadFolder($obj['upload_folder']);
            $instance->setDockerfileFolder($obj['dockerfile_folder']);
            $instance->setDockerCount($obj['docker_count']);
            $instance->setDockerSocketPath($obj['docker_unix_socket']);
            $instance->setPortTerminal($obj['terminal_port']);
            $instance->setPortExecContainer($obj['terminal_docker_exec_port']);

//            if (!is_null($obj['hosts']) && !empty($obj['hosts'])) {
//                $hosts = [];
//                foreach ($obj['hosts'] as $host) {
//                    array_push($hosts, Host::fromJsonObjects($host));
//                }
//
//                $instance->setHosts($hosts);
//            }

            return $instance;
        }

        /**
         * Get the value of dockerCount
         */ 
        public function getDockerCount()
        {
                return $this->dockerCount;
        }

        /**
         * Set the value of dockerCount
         *
         * @return  self
         */ 
        public function setDockerCount($dockerCount)
        {
                $this->dockerCount = $dockerCount;

                return $this;
        }

        /**
         * Get the value of dockerfileFolder
         */ 
        public function getDockerfileFolder()
        {
                return $this->dockerfileFolder;
        }

        /**
         * Set the value of dockerfileFolder
         *
         * @return  self
         */ 
        public function setDockerfileFolder($dockerfileFolder)
        {
                $this->dockerfileFolder = $dockerfileFolder;

                return $this;
        }

        /**
         * Get the value of uploadFolder
         */ 
        public function getUploadFolder()
        {
                return $this->uploadFolder;
        }

        /**
         * Set the value of uploadFolder
         *
         * @return  self
         */ 
        public function setUploadFolder($uploadFolder)
        {
                $this->uploadFolder = $uploadFolder;

                return $this;
        }

        /**
         * Get the value of projectName
         */ 
        public function getProjectName()
        {
                return $this->projectName;
        }

        /**
         * Set the value of projectName
         *
         * @return  self
         */ 
        public function setProjectName($projectName)
        {
                $this->projectName = $projectName;

                return $this;
        }

        /**
         * Get the value of version
         */ 
        public function getVersion()
        {
                return $this->version;
        }

        /**
         * Set the value of version
         *
         * @return  self
         */ 
        public function setVersion($version)
        {
                $this->version = $version;

                return $this;
        }

		/**
		 * Get the value of dockerSocketPath
		 */ 
		public function getDockerSocketPath()
		{
				return $this->dockerSocketPath;
		}

		/**
		 * Set the value of dockerSocketPath
		 *
		 * @return  self
		 */ 
		public function setDockerSocketPath($dockerSocketPath)
		{
				$this->dockerSocketPath = $dockerSocketPath;

				return $this;
		}

        /**
         * @return mixed
         */
        public function getPortTerminal()
        {
            return $this->portTerminal;
        }

        /**
         * @param mixed $portTerminal
         */
        public function setPortTerminal($portTerminal): void
        {
            $this->portTerminal = $portTerminal;
        }

        /**
         * @return mixed
         */
        public function getPortExecContainer()
        {
            return $this->portExecContainer;
        }

        /**
         * @param mixed $portExecContainer
         */
        public function setPortExecContainer($portExecContainer): void
        {
            $this->portExecContainer = $portExecContainer;
        }


        /**
         * @return mixed
         */
//        public function getHosts()
//        {
//            return $this->hosts;
//        }
//
//        /**
//         * @param mixed $hosts
//         */
//        public function setHosts($hosts): void
//        {
//            $this->hosts = $hosts;
//        }

        public function increaseDockerCount() : void {
            $this->setDockerCount($this->getDockerCount() + 1);
        }


		public function toJson() {
			$obj = [];

			$obj['project_name'] = $this->getProjectName();
			$obj['version'] =$this->getVersion();

			$obj['upload_folder'] = $this->getUploadFolder();
			$obj['dockerfile_folder'] = $this->getDockerfileFolder();
			$obj['docker_count'] = $this->getDockerCount();
			$obj['docker_unix_socket'] = $this->getDockerSocketPath();
			$obj['terminal_port'] = $this->getPortTerminal();
			$obj['terminal_docker_exec_port'] = $this->getPortExecContainer();

//            $hostStrings = [];
//            foreach ($this->hosts as $host) {
//                array_push($hostStrings, $host->toArray());
//            }
//
//            $obj['hosts'] = $hostStrings;

			return json_encode($obj, JSON_PRETTY_PRINT);
		}
    }
?>