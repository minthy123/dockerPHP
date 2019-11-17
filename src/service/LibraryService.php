<?php
    include_once('../dao/LibraryDao.php');
    include_once('../dao/CommandDao.php');
    include_once('../dao/DependenceDao.php');
    include_once('../model/OsAndLibraries.php');
    
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

        // public function getLibraries($inputLibraryIds) {
        //     $libraryIds = $this->loadAllDependentLibraryId($inputLibraryIds);
            
        //     $librariesInDB = $this->libraryDao->getAll();
                        
        //     $libraries = Array();
        //     foreach ($librariesInDB as $tmp) {
        //         if (in_array($tmp->getId(), $libraryIds)) {
        //             array_push($libraries, $tmp);
        //         }
        //     }
            
        //     $commands = $this->commandDao->getAll();
            
        //     $this->mapCommandAndLibrary($libraries, $commands);

        //     return $libraries;
        // }

        public function getLibrariesFromOS($osId, $inputLibraryIds) {
            $dependences = $this->dependenceDao->getAll();
            $libraryMapByIds = $this->getLibrariesMapById();
            
            $osAndLibraries = self::getOsAndLibraries($osId, $libraryMapByIds, $dependences);

            $libraryIds = $this->loadAllDependentLibraryId1($osAndLibraries, $libraryIds, $dependences);
            $libraries = self::getLibrariesFromId($libraryMapByIds, $libraryIds);
            
            $commands = $this->commandDao->getAll();
            $this->mapCommandAndLibrary($libraries, $commands);

            return $libraries;
        }

        private static function loadAllDependentLibraryId1($allowenceLibraryIds, $libraryIds, $dependences) {

            // queue
            $queue = $libraryIds;
            $top=0;
            $sizeOfQueue=count($libraryIds); 

            $result = Array();

            while ($top < $sizeOfQueue + 1) {
                // pop que
                $libId=$queue[$top];
                $top++;

                if (in_array($libId, $result) && !in_array($libId, $allowenceLibraryIds)) {
                    continue;
                }

                array_push($result, $libId);
               
                foreach ($dependences as $de) {
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

        // private function loadAllDependentLibraryId($libraryIds) {

        //     // queue
        //     $queue = $libraryIds;
        //     $top=0;
        //     $sizeOfQueue=count($libraryIds); 

        //     $result = Array();

        //     $dependences = $this->dependenceDao->getAll();

        //     while ($top < $sizeOfQueue + 1) {
        //         // pop que
        //         $libId=$queue[$top];
        //         $top++;

        //         if (in_array($libId, $result)) {
        //             continue;
        //         }

        //         array_push($result, $libId);
               
        //         foreach ($dependences as $de) {
        //             if ($de->getLibraryId() != $libId) {
        //                 continue;
        //             }

        //             //push to queue
        //             array_push($queue, $de->getParentLibraryId());
        //             $sizeOfQueue++;
        //         }

        //     }

        //     return $result;
        // }

        public function getLibrariesMapById() {
            $librariesInDB = $this->libraryDao->getAll();

            $libraryMapByIds = [];
            foreach ($librariesInDB as $library) {
                $libraryMapByIds[$library->getId()] = $library;
            }

            return $libraryMapByIds;
        }

        public function getLibrariesSeperateByOS() {
            $libraryMapByIds = $this->getLibrariesMapById();
            $dependences = $this->dependenceDao->getAll();

            $osIds = self::getAllOS(array_keys($libraryMapByIds), $dependences);

            $result = [];
            foreach ($osIds as $osId) {
                array_push($result, self::getOsAndLibraries($osId, $libraryMapByIds, $dependences));
            }

            return $result;
        }

        private static function getLibrariesFromId($libraryMapByIds, $libraryIds) {
            $libraries = [];
            foreach ($libraryIds as $libraryId) {
                array_push($libraries, $libraryMapByIds[$libraryId]);
            }

            return $libraries;
        }

        private static function getOsAndLibraries($osId, $libraryMapByIds, $dependences) {
            $libraryIdsOfOS = self::getAllLibrariesOfOS($osId, $dependences, $libraryMapByIds);

            $librariesOfOS = self::getLibrariesFromId($libraryMapByIds, $libraryIdsOfOS);

            return new OSAndLibraries($libraryMapByIds[$osId], $librariesOfOS);
        }

        private static function getAllOS($libraryIds, $dependences) {
            $arr = [];
            foreach ($dependences as $dependence) {
                array_push($arr, $dependence->getLibraryId());
            }

            $result = [];
            foreach ($libraryIds as $libraryId) {
                if (!in_array($libraryId, $arr)) {
                    array_push($result, $libraryId);
                }
            }

            return $result;
        }

        private static function getAllLibrariesOfOS($osId, $dependences, $libraryMapByIds) {
            // queue
            $queue = [$osId];
            $top=0;
            $sizeOfQueue=count($queue); 

            $result = Array();

            $isGPU = $libraryMapByIds[$osId]->getIsGPU();

            while ($top < $sizeOfQueue + 1) {
                // pop que
                $libId=$queue[$top];
                $top++;

                if (in_array($libId, $result) || (!$isGPU && $libraryMapByIds[$libId]->getIsGPU())) {
                    continue;
                }

                array_push($result, $libId);
               
                foreach ($dependences as $de) {
                    if ($de->getParentLibraryId() != $libId) {
                        continue;
                    }

                    //push to queue
                    array_push($queue, $de->getLibraryId());
                    $sizeOfQueue++;
                }

            }

            return $result;
        }   

        
    }
?>