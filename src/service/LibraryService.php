<?php
    include_once('../dao/LibraryDao.php');
    include_once('../dao/CommandDao.php');
    include_once('../dao/DependenceDao.php')
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
                $library->setCommands([]);
                foreach ($commands as $command) {
                    if ($command->getLibraryId() == $library->getId()) {
                        $library->addCommand($command);
                    }
                }
            }
        }

        public function getLibraries($inputLibraryIds) {
            $libraryIds = $this->loadAllDependentLibraryId($inputLibraryIds);

            $librariesInDB = $this->libraryDao->getAll();//($libraryIds);
            
            $libraries = Array();
            foreach ($librariesInDB as $tmp) {
                if (in_array($tmp->getId(), $libraryIds)) {
                    $libraries->add($tmp);
                }
            }

            $commands = $this->commandDao->getAll();

            $this->mapCommandAndLibrary($libraries, $commands);
        }

        private function loadAllDependentLibraryId($libraryIds) {

            //queue
            $queue = $libraryIds;
            $top=0;
            $sizeOfQueue=0; 

            $result = Array();

            $dependence = $this->dependenceDao->getAll();

            whlile ($top <= $sizeOfQueue) {
                //pop queue
                $libId = $queue[$top];
                $top++;

                if (in_array($libId, $result)) {
                    continue;
                }

                arary_push($result, $libId);
               
                foreach ($dependence as $de) {
                    if ($de->getLibraryId() != $libId) {
                        continue;
                    }

                    //push to queue
                    array_push($queue, $de->getParentLibraryId());
                    $sizeOfQueue++;
                }

            }

            return $result;
        }

        
    }
?>