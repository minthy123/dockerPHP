<?php
    class DependenceEntity {
        private $libraryId;
        private $parentLibraryId;
        
        function __construct($libraryId, $parentLibraryId) {
            $this->parentLibraryId = $parentLibraryId;
            $this->libraryId = $libraryId;
        }

        function setLibraryId($libraryId) {
            $this->libraryId = $libraryId;
        }

        function getLibraryId() {
            return $this->libraryId;
        }

        function septParentLibraryId($parentLibraryId) {
            $this->parentLibraryId = $parentLibraryId;
        }

        function getParentLibraryId() {
            return $this->parentLibraryId;
        }
    }
?>