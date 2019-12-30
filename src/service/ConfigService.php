<?php
    include_once (__DIR__.'/../model/Config.php');
    include_once (__DIR__.'/../utils/Utils.php');

    class ConfigService {
        private const CONFIG_FILE_PATH = __DIR__.'/../../config.json';
        
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