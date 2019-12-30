<?php
    include_once(__DIR__ . '/../../../service/HostService.php');
    $hostService = new HostService();
    $hosts = $hostService->getAll();

    $chosenHost = null;

    if (isset($_GET['host-id']) && !empty($_GET['host-id'])) {
        foreach ($hosts as $host) {
            if ((int)$_GET['host-id'] == $host->getId()) {
                $chosenHost = $host;
                break;
            }
        }
    } else {
        $_GET['host-id'] = $hosts[0]->getId();
        header("Location: http://" .$_SERVER['SERVER_NAME']. ":".$_SERVER['SERVER_PORT']. $_SERVER['PHP_SELF']. '?' . http_build_query($_GET));
    }
?>