<?php
    include_once ('/var/www/html/src/model/Config.php');

    class ConfigService {
        private const CONFIG_FILE_PATH = '/var/www/html/config.json';
        
        public static function loadConfig() {
            if (file_exists(self::CONFIG_FILE_PATH)) {
                $file = fopen(self::CONFIG_FILE_PATH, 'r');
                $content = fread($file,filesize(self::CONFIG_FILE_PATH));
                return Config::fromJSONObject(json_decode($content, true));                
            }

            return null;
        }

        public function modifyConfig($config) {
            
        }
    }
?>