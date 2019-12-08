<?php 
    include_once('Database.php');
    include_once('/var/www/html/src/entity/LibraryEntity.php');

    class LibraryDao{
       
        function getAll() :array {
            $db = new Database();
            $sqlQuery = "SELECT * FROM library";  
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
               array_push($result, new LibraryEntity($row['id'], $row['name'], $row['isGPU']));
            }
            
            $db->close();

            return $result;
        }

        function countOS() :int {
            $db = new Database();
            $sqlQuery = "SELECT count(*) FROM library WHERE id NOT IN (SELECT library_id FROM dependence)";
            $result = $db->querySingle($sqlQuery);

            $db->close();

            return $result;
        }

        function countLibraries() :int {
            $db = new Database();
            $sqlQuery = "SELECT count(*) FROM library WHERE id IN (SELECT library_id FROM dependence)";
            $result = $db->querySingle($sqlQuery);

            $db->close();

            return $result;
        }

        function getLibraryById(int $libraryId) : LibraryEntity {
            $db = new Database();
            $sqlQuery = "SELECT * FROM library WHERE id=:library_id";
            $stmt = $db->prepare($sqlQuery);

            $stmt->bindValue(":library_id", $libraryId);
            $ret = $stmt->execute();

            $result = null;
            while ($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                $result = new LibraryEntity($row['id'], $row['name'], $row['isGPU']);
            }

            $db->close();
            return $result;
        }

        function addLibrary(LibraryEntity $library) : int {
            $db = new Database();
            $sqlQuery = "INSERT INTO library (name, isGPU) VALUES (:name, :isGPU)";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":name", $library->getName());
            $stmt->bindParam(":isGPU", $library->getIsGPU());

            $stmt->execute();

            $lastInsertId = $db->lastInsertRowID();

            $db->close();
            return $lastInsertId;
        }

        function removeLibrary(int $libraryId)  {
            $db = new Database();
            $sqlQuery = "DELETE FROM library WHERE id=:libraryId";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":libraryId", $libraryId);

            $stmt->execute();
            $db->close();
        }

        // function getByLibraryIds($libraryIds) {
        //     $db = new Database();
        //     $sqlQuery = "SELECT * FROM library WHERE id in :libraryIds";  
        //     $stmt = $db->prepare($sqlQuery);
        //     $stmt->bindValue(":libraryIds", $libraryIds, SQLITE3);

        //     $result = [];
        //     while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
        //        array_push($result, new LibraryEntity($row['id'], $row['name']));
        //     }
            
        //     $db->close();
            

        //     return $result;
        // }
    }
?>