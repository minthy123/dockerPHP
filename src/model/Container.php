<?php
	require_once(__DIR__.'/Image.php');
	require_once(__DIR__.'/Port.php');
	require_once (__DIR__.'/Network.php');

	class Container {
		
		private $id;
		private $name;
		private $created;
		private $command;

		private $hostnamePath;
		private $hostsPath;
		private $logPath;
		private $restartCount;
		private $platform;
		private $driver;
		private $path;

        private $state;
        private $status;
        private $startedAt;
        private $finishedAt;
        private $cmd;

        private $env;
        private $workingDir;
        private $entryPoint;

		private $mount;

		private $image;
		private $ports;

		private $network;

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
			$instance->setCommand($obj['Command']);

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

        public static function fromJSONDetail($obj) {
            $instance = new self();
            $image = new Image();
            $instance->setImage($image);

            //container
            $instance->setName($obj['Name']);
            $instance->setId($obj['Id']);
            $image->setId($obj['Image']);
            $instance->setRestartCount($obj['RestartCount']);
            $instance->setCommand($obj['Command']);
            $instance->setCreated($obj['Created']);
            $instance->setHostnamePath($obj['HostnamePath']);
            $instance->setHostsPath($obj['HostsPath']);
            $instance->setLogPath($obj['LogPath']);
            $instance->setPlatform($obj['Platform']);
            $instance->setDriver($obj['Driver']);
            $instance->setPath($obj['Path']);

             //state
            $instance->setState($obj['State']['Status']);
            $instance->setStartedAt($obj['State']['StartedAt']);
            $instance->setFinishedAt($obj['State']['FinishedAt']);

            //config
            $image->setName($obj['Config']['Image']);
            $instance->setEnv($obj['Config']['Env']);
            $instance->setCmd(join(" ",$obj['Config']['Cmd']));
            $instance->setWorkingDir($obj['Config']['WorkingDir']);
            $instance->setEntryPoint($obj['Config']['Entrypoint']);

            //network
            $instance->setNetwork(Network::fromJsonObject($obj['NetworkSettings']));

            return $instance;
        }

		public function getName() {
			return $this->name;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function setRestartCount($restartCount) {
		    $this->restartCount = $restartCount;
        }

        public function getRestartCount() {
            return $this->restartCount;
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

        public function setCreated($created) {
            $this->created = $created;
        }

        public function getCreated() {
            return $this->created;
        }

		public function setCommand($command) {
			$this->command = $command;
		}

		public function getCommand() {
			return $this->command;
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

        /**
         * @return mixed
         */
        public function getHostnamePath()
        {
            return $this->hostnamePath;
        }

        /**
         * @param mixed $hostnamePath
         */
        public function setHostnamePath($hostnamePath): void
        {
            $this->hostnamePath = $hostnamePath;
        }

        /**
         * @return mixed
         */
        public function getHostsPath()
        {
            return $this->hostsPath;
        }

        /**
         * @param mixed $hostsPath
         */
        public function setHostsPath($hostsPath): void
        {
            $this->hostsPath = $hostsPath;
        }

        /**
         * @return mixed
         */
        public function getLogPath()
        {
            return $this->logPath;
        }

        /**
         * @param mixed $logPath
         */
        public function setLogPath($logPath): void
        {
            $this->logPath = $logPath;
        }

        /**
         * @return mixed
         */
        public function getPlatform()
        {
            return $this->platform;
        }

        /**
         * @param mixed $platform
         */
        public function setPlatform($platform): void
        {
            $this->platform = $platform;
        }

        /**
         * @return mixed
         */
        public function getDriver()
        {
            return $this->driver;
        }

        /**
         * @param mixed $driver
         */
        public function setDriver($driver): void
        {
            $this->driver = $driver;
        }

        /**
         * @return mixed
         */
        public function getPath()
        {
            return $this->path;
        }

        /**
         * @param mixed $path
         */
        public function setPath($path): void
        {
            $this->path = $path;
        }

        /**
         * @return mixed
         */
        public function getMount()
        {
            return $this->mount;
        }

        /**
         * @param mixed $mount
         */
        public function setMount($mount): void
        {
            $this->mount = $mount;
        }

        /**
         * @return mixed
         */
        public function getStartedAt()
        {
            return $this->startedAt;
        }

        /**
         * @param mixed $startedAt
         */
        public function setStartedAt($startedAt): void
        {
            $this->startedAt = $startedAt;
        }

        /**
         * @return mixed
         */
        public function getFinishedAt()
        {
            return $this->finishedAt;
        }

        /**
         * @param mixed $finishedAt
         */
        public function setFinishedAt($finishedAt): void
        {
            $this->finishedAt = $finishedAt;
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
        public function getNetwork()
        {
            return $this->network;
        }

        /**
         * @param mixed $network
         */
        public function setNetwork($network): void
        {
            $this->network = $network;
        }

        public function isRunning(){
            return $this->state == "running";
        }

        /**
         * @return mixed
         */
        public function getCmd()
        {
            return $this->cmd;
        }

        /**
         * @param mixed $cmd
         */
        public function setCmd($cmd): void
        {
            $this->cmd = $cmd;
        }
	}

?>