<?php
    include_once('../dao/LibraryDao.php');
    include_once('../dao/CommandDao.php');
    include_once('../dao/DependenceDao.php');
    
    class LibraryService {
        
        private $libraryDao;
        private $commandDao;
        private $dependenceDao;

        function __construct(){
            $this->libraryDao = new LibraryDao();
            $this->commandDao = new CommandDao();
            $this->dependenceDao = new DependenceDao();
        }

        private function mapCommandAndLibrary($libraries, $commands) {
            foreach ($libraries as $library) {
                $library->setCommands(Array());
                foreach ($commands as $command) {
                    if ($command->getLibraryId() == $library->getId()) {
                        $library->addCommand($command);
                    }
                }
            }
        }

        public function getLibraries($inputLibraryIds) {
            $libraryIds = $this->loadAllDependentLibraryId($inputLibraryIds);
            
            $librariesInDB = $this->libraryDao->getAll();
                        
            $libraries = Array();
            foreach ($librariesInDB as $tmp) {
                if (in_array($tmp->getId(), $libraryIds)) {
                    array_push($libraries, $tmp);
                }
            }
            
            $commands = $this->commandDao->getAll();
            
            $this->mapCommandAndLibrary($libraries, $commands);

            return $libraries;
        }

        private function loadAllDependentLibraryId($libraryIds) {

            // stack
            $queue = $libraryIds;
            $top=0;
            $sizeOfQueue=0; 

            $result = Array();

            $dependences = $this->dependenceDao->getAll();

            while ($top < $sizeOfQueue + 1) {
                // pop stack
                $libId=$queue[$top];
                $top++;

                if (in_array($libId, $result)) {
                    continue;
                }

                array_push($result, $libId);
               
                foreach ($dependences as $de) {
                    if ($de->getLibraryId() != $libId) {
                        continue;
                    }

                    //push to stack
                    array_push($queue, $de->getParentLibraryId());
                    $sizeOfQueue++;
                }

            }

            return $result;
        }

        
    }
?>