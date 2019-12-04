<?php 
    include_once('Database.php');
    include_once('/var/www/html/src/entity/LibraryEntity.php');

    class LibraryDao{
       
        function getAll() {
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

        function addLibrary(LibraryEntity $library) {
            $db = new Database();
            $sqlQuery = "INSERT INTO library (name, isGPU) VALUES (:name, :isGPU)";

            $db->exec($sqlQuery);
            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":name", $library->getName());
            $stmt->bindValue(":isGPU", $library->getIsGPU());

            $stmt->execute();

            $lastInsertId = $db->lastInsertRowID();

            $db->close();
            return $lastInsertId;
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