<?php
    require_once('../model/Container.php');
    require_once('DockerClient.php');

    class ContainerClient {
        private static $STOP_CONTAINER_COMMAND = '/containers/%s/stop';
        private static $START_CONTAINER_COMMAND = '/containers/%s/start';
        private static $RESTART_CONTAINER_COMMAND = '/containers/%s/restart?t=5';
        private static $KILL_CONTAINER_COMMAND = '/containers/%s/kill';

        private static $LIST_ALL_CONTAINERS = '/containers/json';

        private $dockerClient;

        public function __construct() {
            $this->dockerClient = new DockerClient();
        }

        public function getAllContainers() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand(self::$LIST_ALL_CONTAINERS);
            foreach ($jsonArray as $key=>$json) {
                array_push($result, Container::fromJSONObject($json));
            }

            return $result;
        }

        public function stopConatiner($container) {
            $result = [];
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::$STOP_CONTAINER_COMMAND, $container->getId()));
        }

        public function startConatiner($container) {
            $result = [];
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::$START_CONTAINER_COMMAND, $container->getId()));
        }

        private static function replaceContainerId($command, $containerId){
            return sprintf($command, $containerId);
        }
	
    }

    if (isset($_GET['list-all'])) {
        $a = new ContainerClient();
        var_dump($a->getAllContainers());
    }
?>