<?php
    include_once ('/var/www/html/src/model/Config.php');
    include_once ('/var/www/html/src/utils/Utils.php');

    class ConfigService {
        private const CONFIG_FILE_PATH = '/var/www/html/config.json';
        
        public static function loadConfig() : ? Config {
            $content = Utils::readFile(self::CONFIG_FILE_PATH);
            return is_null($content) ? null :
                Config::fromJSONObject(json_decode($content, true));
        }

        public static function modifyConfig(Config $config) : void {
            Utils::saveFile($config->toJson(), self::CONFIG_FILE_PATH);
        }
    }
?>