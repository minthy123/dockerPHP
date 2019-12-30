<?php
    include_once (__DIR__."/../restclient/ImageClient.php");

    $host = null;
    if (isset($_GET['host-id']) && !empty($_GET['host-id'])) {
        include_once (__DIR__.'/../service/HostService.php');
        $hostService = new HostService();
        $host = $hostService->getHostById((int)$_GET['host-id']);
    }

    if (isset($_GET['image-id'])) {
        $imageClient = new ImageClient($host);

        if ($_GET['operation'] == 'delete') {
            $imageClient->deleteImage($_GET['image-id']);
        }
    }
?>