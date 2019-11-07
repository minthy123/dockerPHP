<?php
    require_once('../model/Container.php');
    require_once('DockerClient.php');

    class ContainerClient {
        private $dockerClient;

        public function __construct() {
            $this->dockerClient = new DockerClient();
        }

        public function getAllContainers() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand('/containers/json');
            foreach ($jsonArray as $key=>$json) {
                array_push($result, Container::fromJSONObject($json));
            }

            return $result;
        }
	
    }

    $a = new ContainerClient();
    //$a->getAllImages();
    var_dump($a->getAllContainers());
?>