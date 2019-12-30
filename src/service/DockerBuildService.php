<?php
    include_once ('ConfigService.php');

    class DockerBuildService {
        static private $DOCKER_BUILD_COMMAND="docker build --rm --no-cache -t <image_name> -f <dockerfile_name> .";

        private $buildCommand;
        private $configService;
        private $config;

        function __construct() {
            $this->configService = new ConfigService();
            $this->config = ConfigService::loadConfig();
        }

        function handleName($imageName) {
            return $imageName == null || empty($imageName) ? "test_image".ConfigService::loadConfig()->getDockerCount() : $imageName;
        }

        function generateDockerBuildCommand(Dockerfile $dockerfile) {
            $result = self::$DOCKER_BUILD_COMMAND;
            $result = str_replace("<image_name>", $this->handleName($dockerfile->getImageName()), $result);
            $result = str_replace("<dockerfile_name>", $dockerfile->getDockerfilePath(), $result);
            
            $this->buildCommand = $result;
            return $result;
        }
    }


?>