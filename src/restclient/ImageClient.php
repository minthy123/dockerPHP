<?php
    require_once('../model/Image.php');
    require_once('DockerClient.php');

    class ImageClient {
        private $dockerClient;

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

    $a = new ImageClient();
    //$a->getAllImages();
    var_dump($a->getAllImages());
?>