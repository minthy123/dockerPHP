<?php
    include_once('../dao/LibraryDao.php');
    include_once('../dao/CommandDao.php');
    class DockerfileService {
        
        private $libraryDao;
        private $commandDao;

        function __construct(){
            $this->libraryDao = new LibraryDao();
            $this->commandDao = new CommandDao();
        }

        function createCommand($library) {
            $string = "";
            foreach ($library->getCommands() as $command) {
                $string .= $command->getDockerInstruction() . " " . $command->getCmd() . "\n";               
            }
            
            return $string;
        }

        function mapCommandAndLibrary($libraries, $commands) {
            foreach ($libraries as $library) {
                $library->setCommands([]);
                foreach ($commands as $command) {
                    if ($command->getLibraryId() == $library->getId()) {
                        $library->addCommand($command);
                    }
                }
            }
        }

        function createDockerfile() {
            $libraries = $this->libraryDao->getAll();
            $commands = $this->commandDao->getAll();

            $this->mapCommandAndLibrary($libraries, $commands);

            $result = "";
            foreach ($libraries as $library) {
                $result .= $this->createCommand($library);
            }

            return $result."\n";
        }
    }
?>