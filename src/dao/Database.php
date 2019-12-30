<?php
class Database extends SQLite3 {
    function __construct() {
        $this->open(__DIR__.'/../../database/test.db', SQLITE3_OPEN_READWRITE);
    }
}
?>