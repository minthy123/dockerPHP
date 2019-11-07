<?php
    include_once('LibraryService.php');
    class DockerfileService {
        
        private $libraryService;

        function __construct(){
            $this->libraryService = new LibraryService();
        }

        function createCommand($library) {
            $string = "";
            foreach ($library->getCommands() as $command) {
                $string .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
            }
            
            return $string;
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