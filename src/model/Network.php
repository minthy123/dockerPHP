<?php
    include_once ("Port.php");
    class Network {
        private $bridge;
        private $sandboxId;

        private $ports;
        private $sandboxKey;
        private $endpointId;
        private $gateway;
        private $ipAddress;
        private $macAddress;


        function __construct() {
        }

        public static function fromJsonObject($obj){
            $instance = new self();

            $instance->setBridge($obj['Bridge']);
            $instance->setSandboxId($obj['SandboxID']);
            $instance->setSandboxKey($obj['SandboxKey']);
            $instance->setGateway($obj['Gateway']);
            $instance->setIpAddress($obj['IPAddress']);
            $instance->setMacAddress($obj['MacAddress']);
            $instance->setEndpointId($obj['EndpointID']);

            $ports = [];
            foreach ($obj['Ports'] as $key=>$value) {
                $port = new Port();
                $port->setIP($value[0]['HostIp']);
                $port->setPrivatePort($key);
                $port->setPublicPort($value[0]['HostPort']);

                array_push($ports, $port);
            }

            $instance->setPorts($ports);

            return $instance;
        }

        /**
         * @return mixed
         */
        public function getBridge()
        {
            return $this->bridge;
        }

        /**
         * @param mixed $bridge
         */
        public function setBridge($bridge): void
        {
            $this->bridge = $bridge;
        }

        /**
         * @return mixed
         */
        public function getSandboxId()
        {
            return $this->sandboxId;
        }

        /**
         * @param mixed $sandboxId
         */
        public function setSandboxId($sandboxId): void
        {
            $this->sandboxId = $sandboxId;
        }

        /**
         * @return mixed
         */
        public function getPorts()
        {
            return $this->ports;
        }

        /**
         * @param mixed $ports
         */
        public function setPorts($ports): void
        {
            $this->ports = $ports;
        }

        /**
         * @return mixed
         */
        public function getSandboxKey()
        {
            return $this->sandboxKey;
        }

        /**
         * @param mixed $sandboxKey
         */
        public function setSandboxKey($sandboxKey): void
        {
            $this->sandboxKey = $sandboxKey;
        }

        /**
         * @return mixed
         */
        public function getEndpointId()
        {
            return $this->endpointId;
        }

        /**
         * @param mixed $endpointId
         */
        public function setEndpointId($endpointId): void
        {
            $this->endpointId = $endpointId;
        }

        /**
         * @return mixed
         */
        public function getGateway()
        {
            return $this->gateway;
        }

        /**
         * @param mixed $gateway
         */
        public function setGateway($gateway): void
        {
            $this->gateway = $gateway;
        }

        /**
         * @return mixed
         */
        public function getIpAddress()
        {
            return $this->ipAddress;
        }

        /**
         * @param mixed $ipAddress
         */
        public function setIpAddress($ipAddress): void
        {
            $this->ipAddress = $ipAddress;
        }

        /**
         * @return mixed
         */
        public function getMacAddress()
        {
            return $this->macAddress;
        }

        /**
         * @param mixed $macAddress
         */
        public function setMacAddress($macAddress): void
        {
            $this->macAddress = $macAddress;
        }
    }
?>