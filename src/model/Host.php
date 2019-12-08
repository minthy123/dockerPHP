<?
	class Host {
		private $name;

		private $ip;
		private $port;

		private $dockerSocketPath;

		function __construct(){
			// no constructor
		}

		public static function fromJsonObjects($obj){
			$instance = new self();

			$instance->setName($obj['name']);
			$instance->setIp($obj['ip']);
			$instance->setPort($obj['port']);
			$instance->setDockerSocketPath($obj['docker_socket_path']);

			return $instance;
		}

        public function toArray(): array {
            $obj = [];
            $obj['name'] = $this->getName();
            $obj['ip'] = $this->getIp();
            $obj['port'] = $this->getPort();
            $obj['docker_socket_path'] = $this->getDockerSocketPath();

            return $obj;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name): void
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getIp()
        {
            return $this->ip;
        }

        /**
         * @param mixed $ip
         */
        public function setIp($ip): void
        {
            $this->ip = $ip;
        }

        /**
         * @return mixed
         */
        public function getPort()
        {
            return $this->port;
        }

        /**
         * @param mixed $port
         */
        public function setPort($port): void
        {
            $this->port = $port;
        }

        /**
         * @return mixed
         */
        public function getDockerSocketPath()
        {
            return $this->dockerSocketPath;
        }

        /**
         * @param mixed $dockerSocketPath
         */
        public function setDockerSocketPath($dockerSocketPath): void
        {
            $this->dockerSocketPath = $dockerSocketPath;
        }

		
	}
?>