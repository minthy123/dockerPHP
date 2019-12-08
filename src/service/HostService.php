<?php
    include_once ("/var/www/html/src/entity/HostEntity.php");
    include_once ("/var/www/html/src/dao/HostDao.php");

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

        public function getHostById(int $hostId) : HostEntity {
            return $this->hostDao->getHostById($hostId);
        }

        public function editHost(HostEntity $hostEntity) : void {
            $this->editHost($hostEntity);
        }

        public function removeHostById(int $hostId) : void {
            $this->hostDao->removeHost($hostId);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $hostService = new HostService();

        $hostEntity = new HostEntity();
//        $hostEntity->setDockerSocketPath($_POST['docker_socket_path']);
        $hostEntity->setIp($_POST['ip']);
        $hostEntity->setPort($_POST['port']);
        $hostEntity->setName($_POST['name']);

        $hostService->addHost($hostEntity);
    }

    if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        $hostService = new HostService();
        $hostService->removeHostById($_GET['id']);
    }

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        parse_str(file_get_contents('php://input'), $_PUT);
        $hostService = new HostService();

        $hostEntity = new HostEntity();
//        $hostEntity->setDockerSocketPath($_PUT['docker_socket_path']);
        $hostEntity->setIp($_PUT['ip']);
        $hostEntity->setPort($_PUT['port']);
        $hostEntity->setName($_PUT['name']);
        $hostEntity->setId($_PUT['id']);

        $hostService->editHost($hostEntity);
    }

?>