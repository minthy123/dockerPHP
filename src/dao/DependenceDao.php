<?php 
    include_once('Database.php');
    include_once(__DIR__.'/../entity/DependenceEntity.php');

    class DependenceDao{
        
        function getAll() {
            $db = new Database();
            $sqlQuery = "SELECT * FROM dependence";  
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
               array_push($result, new DependenceEntity($row['library_id'], $row['parent_library_id']));
            }
            
            $db->close();
            return $result;
        }

        function addDependences(array $dependences) : void {
            $db = new Database();
            $sqlQuery = "INSERT INTO dependence (library_id, parent_library_id) VALUES (:library_id, :parent_library_id)";

            $stmt = $db->prepare($sqlQuery);
            foreach ($dependences as $dependence) {
                $stmt->bindValue(":library_id", $dependence->getLibraryId());
                $stmt->bindValue(":parent_library_id", $dependence->getParentLibraryId());
                $stmt->execute();
            }

            $db->close();
        }

        function removeDependenceRelatedLibraryId(int $libraryId) {
            $db = new Database();
            $sqlQuery = "DELETE FROM dependence WHERE library_id=:library_id OR parent_library_id=:library_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":library_id", $libraryId);
            $stmt->execute();

            $db->close();
        }

        function removeParentOfLibraryId(int $libraryId) {
            $db = new Database();
            $sqlQuery = "DELETE FROM dependence WHERE library_id=:library_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":library_id", $libraryId);
            $stmt->execute();

            $db->close();
        }

        function countDependenceOfLibrary(int $libraryId) {
            $db = new Database();
            $sqlQuery = "SELECT COUNT(*) FROM dependence WHERE parent_library_id=:library_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":library_id", $libraryId);
            $ret = $stmt->execute();

            $db->close();

            return ($ret->fetchArray(SQLITE3_ASSOC))[0];
        }
    }
?>