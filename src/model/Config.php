<?php
    class Config {
        private $projectName;
        private $version;
        private $uploadFolder;
		private $dockerfileFolder;
		private $dockerSocketPath;
        private $dockerCount;

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

		public function toJson() {
			$obj = [];

			$obj['project_name'] = $this->getProjectName();
			$obj['version'] =$this->setVersion();

			$obj['upload_folder'] = $this->setUploadFolder();
			$obj['dockerfile_folder'] = $this->setDockerfileFolder();
			$obj['docker_count'] = $this->setDockerCount();
			$obj['docker_unix_socket'] = $this->setDockerSocketPath();

			return json_encode($obj);
		}
    }
?>