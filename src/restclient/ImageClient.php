<?php
    require_once('../model/Image.php');
    require_once('DockerClient.php');

    class ImageClient {
        private $dockerClient;

        private static $STOP_IMAGE_COMMAND = '/images/%s/stop';
        private static $START_IMAGE_COMMAND = '/images/%s/start';
        private static $RESTART_IMAGE_COMMAND = '/images/%s/restart?t=5';
        private static $KILL_IMAGE_COMMAND = '/images/%s/kill';

        public function __construct() {
            $this->dockerClient = new DockerClient();
        }

        public function getAllImages() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand('/images/json');
            foreach ($jsonArray as $key=>$json) {
                array_push($result, Image::fromJSONObject($json));
            }

            return $result;
        }
	
    }


    if (isset($_GET['list-all'])) {
        $a = new ImageClient();
        var_dump($a->getAllImages());
    }
?>