<?php
    include_once('LibraryService.php');
    class DockerfileService {
        
        private $libraryService;

        function __construct(){
            $this->libraryService = new LibraryService();
        }

        // function createCommand($library) {
        //     $commnads = [];
        //     foreach ($library->getCommands() as $command) {
        //         $string .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
        //     }

        //     $string = "";
        //     foreach ($library->getCommands() as $command) {
        //         $string .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
        //     }
            
        //     return $string;
        // }

        function createCommand($libraries) {
            $commnads = [];
            foreach ($libraries as $library) {
                array_push($commands, $library->getCommands());               
            }

            $commands = self::mergeCommands($commands);


            return self::convertCommandToDockerfile($commands);
        }

        private static convertCommandToDockerfile($commands) {
            $result = "";
            foreach ($commands as $command) {
                $result .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
            }

            return $result;
        }

        private static function mergeCommands($commands) {
            $result = [];
            $cmd = new CommandEntity(0, "CMD", "", 0);
            $expose = new CommandEntity(0, "EXPOSE", "", 0);

            foreach ($commands as $command) {
                if ($command->getDockerInstruction() === "CMD") {
                    $cmd->setCmd($cmd->getCmd().'|'.$command->getCmd());
                } else if ($command->getDockerInstruction() === "EXPOSE") {
                    $cmd->expose($cmd->getCmd().' '.$command->getCmd());
                } else {
                    array_push($result, $commands);
                }
            }

            array_push($result, $expose);
            array_push($result, $cmd);

            return $result;
        }

        function createDockerfile() {
            $libraries = $this->libraryService->getLibraries(Array(2));

            $result = "";

            foreach ($libraries as $library) {
                $result .= $this->createCommand($library);
            }

            return $result."\n";
        }
    }
?>