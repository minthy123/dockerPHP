<?php
    class CommandEntity {
        private $id;
        private $cmd;
        private $dockerInstruction;
        private $libraryId;

        // function __construct($cmd, $dockerInstruction) {
        //     $this->cmd = $cmd;
        //     $this->dockerInstruction = $dockerInstruction;
        // }

        function __construct($id, $dockerInstruction, $cmd, $libraryId) {
            $this->id = $id;
            $this->cmd = $cmd;
            $this->libraryId = $libraryId;
            $this->dockerInstruction = $dockerInstruction;
        }

        function setId($id) {
            $this->id = $id;
        }

        function getId() {
            return $this->id;
        }

        function setCmd($cmd) {
            $this->cmd = $cmd;
        }

        function getCmd() {
            return $this->cmd;
        }

        function setLibraryId($libraryId) {
            $this->libraryId = $libraryId;
        }

        function getLibraryId() {
            return $this->libraryId;
        }

        function setDockerInstruction($dockerInstruction) {
            $this->dockerInstruction = $dockerInstruction;
        }

        function getDockerInstruction() {
            return $this->dockerInstruction;
        }

        function toString() {
            return $this->getDockerInstruction() . " " . $this->getCmd();
        }
    }
?>