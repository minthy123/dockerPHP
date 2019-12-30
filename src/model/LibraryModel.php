<?php
    class LibraryModel {
        private $id;
        private $name;
        private $commands;
        private $isGPU;

        private $parentLibraries;
        private $childLibraries;

        public function __construct() {
            $this->setParentLibraries(array());
            $this->setChildLibraries(array());
        }

        public static function fromEntity(LibraryEntity $libraryEntity) : self {
            $instance = new self();

            $instance->setCommands($libraryEntity->getCommands());
            $instance->setId($libraryEntity->getId());
            $instance->setName($libraryEntity->getName());
            $instance->setIsGPU($libraryEntity->getIsGPU());

            return $instance;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id): void
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name): void
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getCommands()
        {
            return $this->commands;
        }

        /**
         * @param mixed $commands
         */
        public function setCommands($commands): void
        {
            $this->commands = $commands;
        }

        /**
         * @return mixed
         */
        public function getIsGPU()
        {
            return $this->isGPU;
        }

        /**
         * @param mixed $isGPU
         */
        public function setIsGPU($isGPU): void
        {
            $this->isGPU = $isGPU;
        }

        /**
         * @return mixed
         */
        public function getParentLibraries()
        {
            return $this->parentLibraries;
        }

        /**
         * @param mixed $parentLibraries
         */
        public function setParentLibraries($parentLibraries): void
        {
            $this->parentLibraries = $parentLibraries;
        }

        public function addParentLibrary(self $parentLibrary) {
            array_push($this->parentLibraries, $parentLibrary);
        }

        public function addChildLibrary(self $childLibrary) {
            array_push($this->childLibraries, $childLibrary);
        }

        /**
         * @return mixed
         */
        public function getChildLibraries()
        {
            return $this->childLibraries;
        }

        /**
         * @param mixed $childLibraries
         */
        public function setChildLibraries($childLibraries): void
        {
            $this->childLibraries = $childLibraries;
        }



        public function isOS() : bool
        {
            return is_null($this->parentLibraries) || empty($this->parentLibraries);
        }
    }
?>