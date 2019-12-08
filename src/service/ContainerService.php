<?php
    include_once ("/var/www/html/src/restclient/ContainerClient.php");
    include_once ("/var/www/html/src/utils/Utils.php");
    include_once ("/var/www/html/src/service/ConfigService.php");

    class ContainerService {
        const DOCKER_COPY ="docker cp --rm --name <container_name> <port> <gpu> <image_name>";

        private $containerClient;

        function __construct() {
            $this->containerClient = new ContainerClient();
        }

        public function getFile($containerId, string $path) {
            return $this->containerClient->downloadContainer($containerId, $path);
        }

        public function putFile($containerId, string $path, $file) {
            $this->containerClient->uploadContainer($containerId, $path, $file);
        }
    }

    if (isset($_GET['container-id'])) {
        $containerService = new ContainerService();

        header("Content-type:application/x-tar");

// It will be called downloaded.pdf
        header("Content-Disposition:attachment;filename=downloaded.tar");

// The PDF source is in original.pdf

        echo $containerService->getFile($_GET['container-id'], $_GET['path']);
    }

    if (isset($_POST['container-id'])) {
        $containerService = new ContainerService();
        $containerService->putFile($_POST['container-id'], $_POST['path'], $_FILES['uploadFile']);
    }

?>