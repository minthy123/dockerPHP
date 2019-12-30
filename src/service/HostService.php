<?php
    include_once (__DIR__."/../entity/HostEntity.php");
    include_once (__DIR__."/../dao/HostDao.php");
    include_once (__DIR__."/../restclient/DockerClient.php");

    class HostService {
        private $hostDao;

        public function __construct() {
            $this->hostDao = new HostDao();
        }

        public function addHost(HostEntity $hostEntity) :void {
            $this->hostDao->addHost($hostEntity);
        }

        public function getAll() : array {
            return $this->hostDao->getAll();
        }

        public function getHostById(?int $hostId) : HostEntity {
            if (is_null($hostId))
                return null;

            return $this->hostDao->getHostById($hostId);
        }

        public function editHost(HostEntity $hostEntity) : void {
            if ($hostEntity == null) return;

            $this->hostDao->editHost($hostEntity);
        }

        public function removeHostById(?int $hostId) : void {
            if ($hostId == null) return;

            $this->hostDao->removeHost($hostId);
        }

        public function countHost() : int {
            return $this->hostDao->countHost();
        }

        public function ping(int $hostId) : int {
            $dockerClient = new DockerClient(self::getHostById($hostId));
            return $dockerClient->ping();
        }
    }

?>