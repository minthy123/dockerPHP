<?php
    class DockerRunService {
        private static $DOCKER_RUN_COMMAND="docker run --rm --name <container_name> <port> <image_name>";

        function __construct() {

        }

        function handlePort() {
            // TODO: get all expose instructor and make a list port to pulish
            // Ex: -p 80:80 -p 8000:8000
            
            return "-P";
        }

        function handleContainerName() {
            return "test_container";
        }

        function handleImageName() {
            return "test_image";
        }

        function generateDockerRunCommand(){
            $result = self::$DOCKER_RUN_COMMAND;
            $result = str_replace("<container_name>", $this->handleContainerName(), $result); 
            $result = str_replace("<port>", $this->handlePort(), $result); 
            $result = str_replace("<image_name>", $this->handleImageName(), $result); 
            
            return $result;
        }
    }


?>