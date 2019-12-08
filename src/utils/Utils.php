<?php

    class Utils {

        public static function saveFile(string $content, string $filename) : void {
            try {
                if(!file_exists($filename)){
                    touch($filename);
                    chmod($filename, 0777);
                }

                $dockerfile = fopen($filename, "w") or die("Unable to open file!");

                fwrite($dockerfile, $content);
                fclose($dockerfile);

            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

        public static function readFile(string $path) : ?string {
            if (file_exists($path)) {
                $file = fopen($path, 'r');
                $content = fread($file,filesize($path));
                fclose($file);
                return $content;
            }

            return null;
        }

    }

?>