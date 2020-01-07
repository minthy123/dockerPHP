<?php
    include_once (__DIR__."/../restclient/ImageClient.php");
    include_once (__DIR__.'/../service/HostService.php');
    include_once (__DIR__.'/../service/ImageService.php');

    $host = null;
    if (isset($_GET['host-id']) && !empty($_GET['host-id'])) {
        $hostService = new HostService();
        $host = $hostService->getHostById((int)$_GET['host-id']);
    }

    if (isset($_GET['image-id'])) {
        $imageClient = new ImageClient($host);

        if ($_GET['operation'] == 'delete') {
            $imageClient->deleteImage($_GET['image-id']);
        }
    }

    //create new Container
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['image-id'])) {
            $image = new Image();
            $image->setId($_POST['image-id']);

            $imageService = new ImageService($host);

            include (__DIR__."/../model/DockerRunCommand.php");
            $dockerRunCommand = new DockerRunCommand();
            $dockerRunCommand->setImageName($_POST['image-id']);
            $dockerRunCommand->setIsGPU($imageService->isOSNeededGPU($image));

            if (isset($_POST['host-id']) && !empty($_POST['host-id'])) {
                $hostService = new HostService();
                $host = $hostService->getHostById((int)$_POST['host-id']);
            }

            $dockerRunCommand->setHost($host);

            include_once (__DIR__.'/../restclient/CommandExecution.php');
            $commandExecution = new CommandExecution();
            $cmd = $commandExecution->replaceHost($dockerRunCommand->toString(), $_POST['host-id']);

            //var_dump($cmd);
            $commandExecution->executeSteam($cmd);
        }
    }
?>