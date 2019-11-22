<?php

    class DockerBuildService {
        static private $DOCKER_BUILD_COMMAND="docker build --rm --no-cache -t <image_name> -f <dockerfile_name> .";

        private $buildCommand;

        function __construct() {
        }

        function handleName($imageName) {
            return $imageName == null ? "test_image" : $imageName;
        }

        function handleDockerfileName() {
            return "/tmp/dockerfile";
        }

        function generateDockerBuildCommand($dockerfile)
        {
            $result = self::$DOCKER_BUILD_COMMAND;
            $result = str_replace("<image_name>", $this->handleName($dockerfile->getImageName()), $result);
            $result = str_replace("<dockerfile_name>", $this->handleDockerfileName(), $result);
            $this->buildCommand = $result;
            return $result;
        }
    }


?>