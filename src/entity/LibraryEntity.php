<?php
    class LibraryEntity {
        private $id;
        private $name;

        private $commands;

        function __construct($id, $name) {
            $this->setId($id);
            $this->setName($name);
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

        function setCommands($commands) {
            $this -> commands = $commands;
        }

        function getCommands() {
            return $this->commands;
        }

        function addCommand($command) {
            array_push($this->commands, $command);
        }

        function containCmdFROM() {
            foreach ($commands as $command) {
                if ($command->getCmmd() === "FROM") {
                    return true;
                }
            }

            return false;
        }
    }
?>