<?php 
    include_once('Database.php');
    include_once(__DIR__.'/../entity/CommandEntity.php');

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

        function getCommandsOfLibrary(int $libraryId) :array {
            $db = new Database();
            $sqlQuery = "SELECT * FROM command WHERE library_id=:library_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":library_id", $libraryId);

            $ret = $stmt->execute();

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

            $stmt = $db->prepare($sqlQuery);
            foreach ($commands as $command) {
                $stmt->bindValue(":docker_instructor", $command->getDockerInstruction());
                $stmt->bindValue(":cmd", $command->getCmd());
                $stmt->bindValue(":library_id", $command->getLibraryId());
                $stmt->execute();
            }

            $db->close();
        }

        function removeCommandsOfLibrary(int $libraryId) {
            $db = new Database();
            $sqlQuery = "DELETE FROM command WHERE library_id=:library_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":library_id", $libraryId);
            $stmt->execute();

            $db->close();
        }
    }
?>