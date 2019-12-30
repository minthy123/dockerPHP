<?php
    include_once('Database.php');
    include_once(__DIR__.'/../entity/UserEntity.php');

    class UserDao {

        public function getAll() : array {
            $db = new Database();
            $sqlQuery = "SELECT * FROM user";
            $ret = $db->query($sqlQuery);

            $result = [];
            while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                array_push($result, new UserEntity($row['id'], $row['username'], $row['password']));
            }

            $db->close();

            return $result;
        }
    }
?>