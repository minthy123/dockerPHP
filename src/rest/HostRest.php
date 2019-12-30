<?php
    include_once (__DIR__. "/../service/HostService.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $hostService = new HostService();

        $hostEntity = new HostEntity();
    //        $hostEntity->setDockerSocketPath($_POST['docker_socket_path']);
        $hostEntity->setIp($_POST['ip']);
        $hostEntity->setPort($_POST['port']);
        $hostEntity->setName($_POST['name']);

        $hostService->addHost($hostEntity);
    }

//var_dump($_POST);

    if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        parse_str(file_get_contents('php://input'), $_DELETE);
        $hostService = new HostService();
        $hostService->removeHostById($_DELETE['host-id']);
    }

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        parse_str(file_get_contents('php://input'), $_PUT);
        $hostService = new HostService();

        $hostEntity = new HostEntity();
    //        $hostEntity->setDockerSocketPath($_PUT['docker_socket_path']);
        $hostEntity->setIp($_PUT['ip']);
        $hostEntity->setPort($_PUT['port']);
        $hostEntity->setName($_PUT['name']);
        $hostEntity->setId($_PUT['host-id']);

        $hostService->editHost($hostEntity);
    }
?>