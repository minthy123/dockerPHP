<?php
    include_once (__DIR__."/../restclient/ContainerClient.php");

    $host = null;
    if (isset($_GET['host-id']) && !empty($_GET['host-id'])) {
        include_once (__DIR__.'/../service/HostService.php');
        $hostService = new HostService();
        $host = $hostService->getHostById((int)$_GET['host-id']);
    }

    $containerClient = new ContainerClient($host);
    if (isset($_GET['container-id'])) {
        switch ($_GET['operation']) {
            case 'CHECK' :
                include_once (__DIR__."/../restclient/CommandExecution.php");
                $commandExecution = new CommandExecution();

                $logCommand = "docker ";
                if ($host != null) {
                    $logCommand .= sprintf("-H tcp://%s:%d", $host->getIp(), $host->getPort());
                }
                $logCommand .= " logs -f " .$_GET['container-id']. " ";

                $commandExecution->executeSteam($logCommand);
                break;

            case 'DOWNLOAD':
                header("Content-type:application/x-tar");
                header("Content-Disposition:attachment;filename=downloaded.tar");

                echo $containerClient->downloadContainer($_GET['container-id'], $_GET['path']);
                break;

            case 'DELETE' :
                $containerClient->deleteContainer($_GET['container-id']);
                break;

            case 'START' :
                $containerClient->startConatiner($_GET['container-id']);
                break;

            case 'STOP' :
                $containerClient->stopConatiner($_GET['container-id']);
                break;

            case 'RESTART' :
                $containerClient->restartContainer($_GET['container-id']);
                break;
        }
    }

    if (isset($_POST['container-id'])) {
        $containerClient->uploadContainer($_POST['container-id'], $_POST['path'], $_FILES['uploadFile']);
    }

?>