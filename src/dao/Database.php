<?php
class Database extends SQLite3 {
    function __construct() {
        $this->open('/var/www/html/database/test.db', SQLITE3_OPEN_READWRITE);
    }
}
?>