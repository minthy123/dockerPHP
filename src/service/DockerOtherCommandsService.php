<?php
    class DockerOtherCommandsService {
        private static $REMOVE_IMAGE="docker images rm <image_name>";
        private static $LOGS="docker log -f <container_name>";
        private static $PORT="docker port <container_name>";
        private static $EXEC="docker exec -it <container_name> <command>";

        function __construct() {}

        function generateRemoveImage($imageName) {
            return str_replace("<image_name>", $imageName, self::REMOVE_IMAGE);
        }

        function generateCheckLog($containerName) {
            return str_replace("<container_name>", $containerName,self::LOGS);
        }

        function generateCheckPort($containerName) {
            return str_replace("<container_name>", $containerName,self::PORT);
        }

        function generateExec($containerName) {
            return str_replace("<container_name>", $containerName,self::EXEC);
        }
    }

?>