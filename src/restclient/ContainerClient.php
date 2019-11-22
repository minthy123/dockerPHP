<?php
    require_once('/var/www/html/src/model/Container.php');
    require_once('DockerClient.php');

    class ContainerClient {
        const STOP_CONTAINER_COMMAND = '/containers/%s/stop';
        const START_CONTAINER_COMMAND = '/containers/%s/start';
        const RESTART_CONTAINER_COMMAND = '/containers/%s/restart?t=5';
        const KILL_CONTAINER_COMMAND = '/containers/%s/kill';
        const LIST_ALL_CONTAINERS = '/containers/json?all=1';


        private $dockerClient;

        public function __construct() {
            $this->dockerClient = new DockerClient();
        }

        public function getAllContainers() {
            $result = [];
            $jsonArray = $this->dockerClient->dispatchCommand(self::LIST_ALL_CONTAINERS);

            foreach ($jsonArray as $key=>$json) {
                array_push($result, Container::fromJSONObject($json));
            }

            return $result;
        }

        public function stopConatiner($id) {
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::STOP_CONTAINER_COMMAND, $id));

        }
        public function startConatiner($id) {
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::START_CONTAINER_COMMAND, $id));
        }

        public function killContainer($id) {
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::KILL_CONTAINER_COMMAND, $id));
        }

        public function restartContainer($id) {
            $this->dockerClient->postCommand(
                $this->replaceContainerId(self::RESTART_CONTAINER_COMMAND, $id));
        }

        private static function replaceContainerId($command, $containerId){
            return sprintf($command, $containerId);
        }
	
    }

    if (isset($_GET['container-id'])) {
        $containerClient = new ContainerClient();

        switch ($_GET['operation']) {
            case 'DELETE' :
                $containerClient->killContainer($_GET['container-id']);
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
?>