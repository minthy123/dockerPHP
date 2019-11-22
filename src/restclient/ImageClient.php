<?php
    require_once('/var/www/html/src/model/Image.php');
    require_once('DockerClient.php');

    class ImageClient {
        private $dockerClient;

        const KILL_IMAGE_COMMAND = '/images/%s';
        const LIST_ALL_IMAGES = '/images/json';

        public function __construct() {
            $this->dockerClient = new DockerClient();
        }

        public function getAllImages() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand(self::LIST_ALL_IMAGES);
            foreach ($jsonArray as $key=>$json) {
                array_push($result, Image::fromJSONObject($json));
            }

            return $result;
        }

        public function deleteImage($id) {
            $this->dockerClient->deleteCommand(
                sprintf(self::KILL_IMAGE_COMMAND, $id));
        }
	
    }

    if (isset($_GET['image-id'])) {
        $imageClient = new ImageClient();

        if ($_GET['operation'] == 'delete') {
            $imageClient->deleteImage($_GET['image-id']);
        }
    }
?>