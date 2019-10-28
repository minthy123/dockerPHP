<?php 
    include_once('Database.php');
    include_once('../entity/LibraryEntity.php');

    class LibraryDao{
       
        function getAll() {
            $db = new Database();
            $sqlQuery = "SELECT * FROM library";  
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
               array_push($result, new LibraryEntity($row['id'], $row['name']));
            }
            
            $db->close();
            

            return $result;
        }
    }
?>