<?php 
    include_once('Database.php');
    include_once('/var/www/html/src/entity/DependenceEntity.php');

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
    }
?>