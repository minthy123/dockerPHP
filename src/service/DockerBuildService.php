<?php
    class DockerBuildService {
        static private $DOCKER_BUILD_COMMAND="docker build --rm -t <image_name> -f <dockerfile_name>";

        function __construct() {
        }

        function handleName() {
            return "test_image";
        }

        function handleDockerfileName() {
            return "dockerfile";
        }

        function generateDockerBuildCommand(){
            $result =  self::$DOCKER_BUILD_COMMAND;
            $result = str_replace("<image_name>", $this->handleName(), $result); 
            $result = str_replace("<dockerfile_name>", $this->handleDockerfileName(), $result); 
            return $result;
        }
    }
?>