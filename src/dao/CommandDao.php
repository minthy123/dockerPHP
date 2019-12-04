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

        function addCommands(array $commands) {
            $db = new Database();
            $sqlQuery = "INSERT INTO command (docker_instructor, cmd, library_id) VALUES (:docker_instructor, :cmd, :library_id)";

            $db->exec($sqlQuery);
            $stmt = $db->prepare($sqlQuery);
            foreach ($commands as $command) {
                $stmt->bindValue(":docker_instructor", $command->getDockerInstruction());
                $stmt->bindValue(":cmd", $command->getCmd());
                $stmt->bindValue(":library_id", $command->getLibraryId());
                $stmt->execute();
            }

            return $db->lastInsertRowID();
        }
    }
?>