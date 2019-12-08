<?
	class HostEntity {

	    private $id;

		private $name;
		private $ip;
		private $port;

//		private $dockerSocketPath;

		function __construct(){
			// no constructor
		}

		public static function fromDao(int $id, string $name, string $ip, int $port) {
		    $instance = new self();
		    $instance->setName($name);
		    $instance->setId($id);
		    $instance->setIp($ip);
		    $instance->setPort($port);
//		    $instance->setDockerSocketPath($dockerSocketPath);

		    return $instance;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id): void
        {
            $this->id = $id;
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
//        public function getDockerSocketPath()
//        {
//            return $this->dockerSocketPath;
//        }
//
//        /**
//         * @param mixed $dockerSocketPath
//         */
//        public function setDockerSocketPath($dockerSocketPath): void
//        {
//            $this->dockerSocketPath = $dockerSocketPath;
//        }

		
	}
?>