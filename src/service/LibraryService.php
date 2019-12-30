<?php
    include_once(__DIR__.'/../dao/LibraryDao.php');
    include_once(__DIR__.'/../dao/CommandDao.php');
    include_once(__DIR__.'/../dao/DependenceDao.php');
    include_once(__DIR__.'/../model/OsAndLibraries.php');
    include_once(__DIR__.'/../model/LibraryModel.php');
    
    class LibraryService {
        
        private $libraryDao;
        private $commandDao;
        private $dependenceDao;

        function __construct(){
            $this->libraryDao = new LibraryDao();
            $this->commandDao = new CommandDao();
            $this->dependenceDao = new DependenceDao();
        }

        private static function mapCommandAndLibrary($libraries, $commands) :void {
            foreach ($libraries as $library) {
                $library->setCommands(Array());

                foreach ($commands as $command) {
                    if ($command->getLibraryId() == $library->getId()) {
                        $library->addCommand($command);
                    }
                }
            }
        }

        public function getLibrariesFromOS($osId, $inputLibraryIds, &$isGPU) : array {
            $dependences = $this->dependenceDao->getAll();
            $libraryMapByIds = $this->getLibrariesMapById();
            
            $osAndLibraries = self::getOsAndLibraries($osId, $libraryMapByIds, $dependences);

            $allowanceLibraryIds = [];
            foreach ($osAndLibraries->getLibraries() as $lib) {
                array_push($allowanceLibraryIds, $lib->getId());
            }

            $libraryIds = $this->loadAllDependentLibraryId($allowanceLibraryIds, $inputLibraryIds, $dependences);

            array_push($libraryIds, $osId);
            
            $libraryIds = array_reverse($libraryIds);
            $libraries = self::getLibrariesFromId($libraryMapByIds, $libraryIds);
            
            $commands = $this->commandDao->getAll();
            $this->mapCommandAndLibrary($libraries, $commands);

            $isGPU =  $libraryMapByIds[$osId]->getIsGPU();

            return $libraries;
        }

        public function getLibrariesFromOS1($osId, $inputLibraryIds, &$isGPU) : array {
            $libraryModelsMapById = self::getAllImageModelsMapById();

            $osModel = $libraryModelsMapById[$osId];
            $bool = true;
            $result = self::getAllNodes($osModel, $inputLibraryIds, $bool);

            array_push($result, $osModel);

            return array_reverse($result);
        }

        private  static  function merge(array  $array1, array $array2) {
            $result = [];
            foreach (array_merge($array1, $array2) as $item) {
                if (in_array($item, $result)) continue;

                array_push($result, $item);
            }

            return $result;
        }

        private function getAllNodes(LibraryModel $libraryModel, array $inputLibraryIds, bool &$isIncluded) : array {
            $isIncluded = in_array($libraryModel->getId(), $inputLibraryIds);

            $result = [];
            $includedNodes = [];

            foreach ($libraryModel->getChildLibraries() as $childLibrary) {


                $isIncludedNode = false;
                $ret = $this->getAllNodes($childLibrary, $inputLibraryIds, $isIncludedNode);
                $isIncluded |= $isIncludedNode;

                if ($isIncludedNode) {
                    $result = self::merge($result, $ret);
                    array_push($includedNodes, $childLibrary);
                }
            }

            $result = array_merge($result, $includedNodes);

            return $result;
        }

        private static function removeDependences($allowanceLibraryIds, $dependences) : array {
            $result = [];
            foreach ($dependences as $dependence) {
                if (!in_array($dependence->getLibraryId(), $allowanceLibraryIds) && !in_array($dependence->getParentLibraryId(), $allowanceLibraryIds)) 
                    array_push($result, $dependence);
            }

            return $result;
        }

        private static function loadAllDependentLibrary($inputLibraryIds, $dependences) {
            $stack = $inputLibraryIds;

            $checked = [];

        
            while (!empty($stack)) {
                $libId = array_pop($stack);

                foreach ($dependences as $dependence) {
                    if ($dependence->getLibraryId() != $libId || $checked[$dependence->getParentLibraryId()]) continue;

                    $checked[$dependence->getParentLibraryId()] = true;
                    array_push($stack, $dependence->getParentLibraryId());
                }
            }
        }

        private static function loadAllDependentLibraryId($allowenceLibraryIds, $libraryIds, $dependences) {

            // queue
            $queue = $libraryIds;
            $top=0;
            $sizeOfQueue=count($libraryIds); 

            $result = Array();

            while ($top < $sizeOfQueue) {
                // pop que
                $libId=$queue[$top];
                $top++;

                if (in_array($libId, $result) || !in_array($libId, $allowenceLibraryIds)) {
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

        public function getLibrariesMapById() :array {
            $librariesInDB = $this->libraryDao->getAll();

            $libraryMapByIds = [];
            foreach ($librariesInDB as $library) {
                $libraryMapByIds[$library->getId()] = $library;
            }

            return $libraryMapByIds;
        }

        public function getLibrariesSeparatedByOS() : array {
            $libraryMapByIds = $this->getLibrariesMapById();
            $dependences = $this->dependenceDao->getAll();

            $osIds = self::getAllOSIds(array_keys($libraryMapByIds), $dependences);

            $result = [];
            foreach ($osIds as $osId) {
                array_push($result, self::getOsAndLibraries($osId, $libraryMapByIds, $dependences));
            }

            return $result;
        }

        private static function getLibrariesFromId(array $libraryMapByIds, array $libraryIds) {
            $libraries = [];
            foreach ($libraryIds as $libraryId) {
                array_push($libraries, $libraryMapByIds[$libraryId]);
            }

            return $libraries;
        }

        private static function getOsAndLibraries(int $osId, array $libraryMapByIds, array $dependences) {
            $libraryIdsOfOS = self::getAllLibrariesOfOS($osId, $dependences, $libraryMapByIds);
            $librariesOfOS = self::getLibrariesFromId($libraryMapByIds, $libraryIdsOfOS);

            return new OSAndLibraries($libraryMapByIds[$osId], $librariesOfOS);
        }

        private static function getAllOSIds(array $libraryIds, array $dependences) :array {
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

            while ($top < $sizeOfQueue) {
                // pop que
                $libId=$queue[$top];
                $top++;


                if (in_array($libId, $result) || (!$isGPU && $libraryMapByIds[$libId]->getIsGPU())) {
                    continue;
                }

                array_push($result, $libId);
               
                foreach ($dependences as $de) {
                    if ($de->getParentLibraryId() != $libId || in_array($de->getLibraryId(), $queue)) {
                        continue;
                    }

                    //push to queue
                    array_push($queue, $de->getLibraryId());
                    $sizeOfQueue++;
                }

            }

            $key = array_search($osId, $result);
            unset($result[$key]);

            return $result;
        }

        public function addLibrary(LibraryEntity $library) : int  {
            $libraryId = $this->libraryDao->addLibrary($library);
            foreach ($library->getCommands() as $command) {
                $command->setLibraryId($libraryId);
            }

            $this->commandDao->addCommands($library->getCommands());

            return $libraryId;
        }

        public function addDependence(int $libraryId, ?array $parentLibraryIds) {
            if ($parentLibraryIds == null || empty($parentLibraryIds)) {
                return;
            }

            $dependences = [];
            foreach ($parentLibraryIds as $parentLibraryId) {
                array_push($dependences, new DependenceEntity($libraryId, $parentLibraryId));
            }

            $this->dependenceDao->addDependences($dependences);
        }

        public static function parseCommand(?string $string) : array {
            if ($string == null || empty($string)) {
                return [];
            }

            $commamds = [];
            foreach (explode("\n", trim($string)) as $commandString) {
                $commandString1 = preg_replace("/ +/", " " , $commandString);

                $posFirstSpace = strpos($commandString1, " ");

                $dockerInstructor = trim(substr($commandString1, 0, $posFirstSpace));
                $cmd = trim(substr($commandString1, $posFirstSpace));

                $commamd = new CommandEntity(0, $dockerInstructor, $cmd, -1);

                array_push($commamds, $commamd);
            }

            return $commamds;
        }

        public function getAllImageModelsMapById() {
            $libraryEntities = $this->libraryDao->getAll();
            $commandEntities = $this->commandDao->getAll();
            self::mapCommandAndLibrary($libraryEntities, $commandEntities);

            $libraryModelMapById = array();
            foreach ($libraryEntities as $libraryEntity) {
                $libraryModelMapById[$libraryEntity->getId()] = LibraryModel::fromEntity($libraryEntity);
            }

            $dependences = $this->dependenceDao->getAll();

            foreach ($dependences as $dependence) {
                $libraryModelMapById[$dependence->getLibraryId()]->addParentLibrary($libraryModelMapById[$dependence->getParentLibraryId()]);
                $libraryModelMapById[$dependence->getParentLibraryId()]->addChildLibrary($libraryModelMapById[$dependence->getLibraryId()]);
            }

            return $libraryModelMapById;
        }

        public function removeLibrary(int $libraryId) {
            if ($this->dependenceDao->countDependenceOfLibrary($libraryId) > 0) {
                die();
            }

            $this->dependenceDao->removeDependenceRelatedLibraryId($libraryId);
            $this->commandDao->removeCommandsOfLibrary($libraryId);
            $this->libraryDao->removeLibrary($libraryId);
        }

        public function countLibrary() : int {
            return $this->libraryDao->countLibraries();
        }

        public function countOS() : int {
            return $this->libraryDao->countOS();
        }

        public function editLibrary(LibraryModel $libraryModel) {
            $libraryEntity = new LibraryEntity($libraryModel->getId(), $libraryModel->getName(), $libraryModel->getIsGPU());

            $this->libraryDao->editLibrary($libraryEntity);
            $this->commandDao->removeCommandsOfLibrary($libraryModel->getId());

            foreach ($libraryModel->getCommands() as $command) {
                $command->setLibraryId($libraryModel->getId());
            }

            $this->commandDao->addCommands($libraryModel->getCommands());

            $dependences = [];
            foreach ($libraryModel->getParentLibraries() as $parentLibraryId) {
                array_push($dependences, new DependenceEntity($libraryModel->getId(), $parentLibraryId));
            }

            $this->dependenceDao->removeParentOfLibraryId($libraryModel->getId());
            $this->dependenceDao->addDependences($dependences);

//            $this->dependenceDao->removeDependenceRelatedLibraryId();
//            foreach ($libraryModel->getCommands() )
        }

        public function getOperatingSystem(string $imageName) : ?LibraryEntity {
            return $this->libraryDao->getOperatingSystemByBaseImageName($imageName);
        }
    }
?>