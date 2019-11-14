<?php

    require_once('../restclient/CommandExecution.php');
    class DockerBuildService {
        static private $DOCKER_BUILD_COMMAND="docker build --rm -t <image_name> -f <dockerfile_name> .";

        private $buildCommand;

        function __construct() {
        }

        function handleName() {
            return "test_image";
        }

        function handleDockerfileName() {
            return "/tmp/dockerfile";
        }

        function generateDockerBuildCommand(){
            $result =  self::$DOCKER_BUILD_COMMAND;
            $result = str_replace("<image_name>", $this->handleName(), $result); 
            $result = str_replace("<dockerfile_name>", $this->handleDockerfileName(), $result); 
            $this->buildCommand = $result;
            return $result;
        }

        function excuteCommand($dockerfile) {
            $commandExecution = new CommandExecution();
            $this->saveDockerfile($dockerfile->toString(false), 'dockerfile');

            echo $commandExecution->execute($this->buildCommand);
        }

        private function saveDockerfile($content, $filename) {
            try {
                $filename = "/tmp/" . $filename;
                if(!file_exists($filename)){
                    touch($filename);
                    chmod($filename, 0777);
                }

                $dockerfile1 = fopen($filename, "w") or die("Unable to open file!");


                fwrite($dockerfile1, $content);
                fclose($dockerfile1);
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }


?>