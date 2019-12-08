<?php 
    include_once('Database.php');
    include_once('/var/www/html/src/entity/HostEntity.php');

    class HostDao {
        
        function getAll() : array {
            $db = new Database();
            $sqlQuery = "SELECT * FROM host";
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
               array_push($result, HostEntity::fromDao(
                   $row['id'], $row['name'], $row['ip'], $row['port']));
            }
            
            $db->close();

            return $result;
        }

        function getHostById(int $hostId) : ?HostEntity {
            $db = new Database();
            $sqlQuery = "SELECT * FROM host WHERE id=:host_id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":host_id", $hostId);

            $ret = $stmt->execute();

            $result = null;
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                $result = HostEntity::fromDao(
                    $row['id'], $row['name'], $row['ip'], $row['port']);
            }

            $db->close();

            return $result;
        }

        function addHost(HostEntity $hostEntity) : void {
            $db = new Database();
            $sqlQuery = "INSERT INTO host(name, docker_socket_path, ip, port) 
                    VALUES (:name, :ip, :port)";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":name", $hostEntity->getName());
            $stmt->bindParam(":ip", $hostEntity->getIp());
            $stmt->bindParam(":port", $hostEntity->getPort());

            $stmt->execute();

            $db->close();
        }

        function editHost(HostEntity $hostEntity) : void {
            $db = new Database();
            $sqlQuery = "UPDATE host
                        SET name=:name, ip=:ip, port=:port
                        WHERE id=:id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindParam(":name", $hostEntity->getName());
            $stmt->bindParam(":ip", $hostEntity->getIp());
            $stmt->bindParam(":port", $hostEntity->getPort());
            $stmt->bindParam(":id", $hostEntity->getId());

            $stmt->execute();

            $db->close();
        }

        function removeHost(int $hostId) : void {
            $db = new Database();
            $sqlQuery = "DELETE FROM host WHERE id=:id";

            $stmt = $db->prepare($sqlQuery);
            $stmt->bindValue(":id", $hostId);
            $stmt->execute();

            $db->close();
        }
    }
?>