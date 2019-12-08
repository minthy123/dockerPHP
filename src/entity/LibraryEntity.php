<?php
    class LibraryEntity {
        private $id;
        private $name;

        private $commands;
        private $isGPU;

        function __construct($id, $name, $isGPU) {
            $this->setId($id);
            $this->setName($name);
            $this->setIsGPU($isGPU);
        }

        function setId($id) {
            $this -> id = $id;
        }

        function getId() {
            return $this->id;
        }

        function setName($name) {
            $this -> name = $name;
        }

        function getName() {
            return $this->name;
        }

        function setIsGPU($isGPU) {
            $this -> isGPU = $isGPU;
        }

        function getIsGPU() {
            return $this->isGPU;
        }

        function setCommands($commands) {
            $this -> commands = $commands;
        }

        function getCommands() : array {
            return $this->commands;
        }

        function addCommand($command) {
            array_push($this->commands, $command);
        }
    }
?>