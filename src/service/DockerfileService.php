<?php
    include_once('LibraryService.php');
    include_once('../model/Dockerfile.php');
    class DockerfileService {
        
        private $libraryService;

        function __construct(){
            $this->libraryService = new LibraryService();
        }

        function createCommand($libraries) {
            $commands = [];
            foreach ($libraries as $library) {
                foreach ($library->getCommands() as $command) {
                    array_push($commands, $command);
                }               
            }


            return self::mergeCommands($commands);
        }

        private static function convertCommandToDockerfile($commands) {
            $result = "";
            foreach ($commands as $command) {
                $result .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
            }

            return $result;
        }

        private static function mergeCommands($commands) {
            $dockerfile = new Dockerfile();
            $cmd = new CommandEntity(0, "CMD", "", 0);
            $expose = new CommandEntity(0, "EXPOSE", "", 0);
            $runs = [];

            foreach ($commands as $command) {
                if ($command->getDockerInstruction() == "CMD") {
                    $cmd->setCmd($cmd->getCmd().'|'.$command->getCmd());
                } else if ($command->getDockerInstruction() == "EXPOSE") {
                    $cmd->expose($cmd->getCmd().' '.$command->getCmd());
                } else if ($command->getDockerInstruction() == "FROM"){
                    $dockerfile->setFrom($command);
                } else {
                    array_push($runs, $command);
                }
            }

            if ($expose->getCmd() != "") { 
                $dockerfile->setExpose($expose);
            }

            if ($cmd->getCmd() != "") {
                $dockerfile->setCmd($cmd);
            }

            $dockerfile->setRuns($runs);

            return $dockerfile;
        }
        
        function createDockerfile($libraryIds) {
            $libraries = $this->libraryService->getLibraries($libraryIds);

            return $this->createCommand($libraries);
        }
    }
?>