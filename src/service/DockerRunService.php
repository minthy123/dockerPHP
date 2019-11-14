<?php
    require_once('../entity/CommandEntity.php');

    class DockerRunService {
        private static $DOCKER_RUN_COMMAND="docker run --rm --name <container_name> <port> <image_name>";

        function __construct() {
            //no construct
        }

        function handlePort($commands, $isAutoGenerate) {
            if (is_null($commands) || count($commands) == 0) {
                return "";
            } 

            if ($isAutoGenerate) {
                return "-P";
            }

            $result = "";

            foreach ($commands as $command) {
                if ($command->getDockerInstruction() === "EXPOSE") {
                    $result .= "-p ".$command->getCmd().":".$command->getCmd();
                }
            }

            return $result;
        }

        function handleContainerName() {
            return "test_container";
        }

        function handleImageName() {
            return "test_image";
        }

        function generateDockerRunCommand(){
            $result = self::DOCKER_RUN_COMMAND;
            $result = str_replace("<container_name>", $this->handleContainerName(), $result); 
            $result = str_replace("<port>", $this->handlePort(null, false), $result); 
            $result = str_replace("<image_name>", $this->handleImageName(), $result); 
            
            return $result;
        }

        function createDockerRunFromCommands($dockerfile) {
            $result = self::$DOCKER_RUN_COMMAND;
            $result = str_replace("<container_name>", $this->handleContainerName(), $result); 
            $result = str_replace("<port>", $this->handlePort($dockerfile->getExpose(), false), $result); 
            $result = str_replace("<image_name>", $this->handleImageName(), $result); 
            
            return $result;
        }

        function createDockerRunFromCommands($commands) {

        }
    }


?>