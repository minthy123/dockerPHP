<?php 
    include_once('Database.php');
    include_once('/var/www/html/src/entity/CommandEntity.php');

    class CommandDao{
        
        function getAll() {
            $db = new Database();
            $sqlQuery = "SELECT * FROM command";  
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
               array_push($result, new CommandEntity($row['id'], $row['docker_instructor'], $row['cmd'], $row['library_id']));
            }
            
            $db->close();

            return $result;
        }
    }
?>