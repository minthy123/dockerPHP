<?php
    include_once('LibraryService.php');
    include_once ('/var/www/html/src/enum/Instruction.php');
    include_once ('/var/www/html/src/model/Dockerfile.php');

    class DockerfileService {
        private $libraryService;

        function __construct(){
            $this->libraryService = new LibraryService();
        }

        function createCommand($libraries) {
            $commands = [];
            foreach ($libraries as $library) {
                foreach ($library->getCommands() as $command) {
                    array_push($commands, $command);
                }               
            }

            return self::mergeCommands($commands);
        }

        private function mergeCommands($commands) {
            $dockerfile = new Dockerfile();

            foreach ($commands as $command) {
                switch ($command->getDockerInstruction()) {
                    case Instruction::CMD:
                        $dockerfile->addCommand($command->getCmd());
                        break;

                    case Instruction::EXPOSE:
                        $dockerfile->addEnv($command);
                        break;

                    case Instruction::FROM:
                        $dockerfile->setFrom($command);
                        break;

                    default:
                        $dockerfile->addRun($command);
                        break;
                }
            }

            $dockerfile->addCommand("tail -f /dev/null");

            $this->saveDockerfile($dockerfile->toString(false), 'dockerfile');
            return $dockerfile;
        }

        function saveDockerfile($content, $filename) {
            $filename = "/tmp/" . $filename;
            self::saveFile($content, $filename);
        }
        
        function createDockerfile($osId, $libraryIds) {
            $isGPU = false;
            $libraries = $this->libraryService->getLibrariesFromOS($osId, $libraryIds, $isGPU);

            $dockerfile = $this->createCommand($libraries);
            $dockerfile->setIsGPU($isGPU);

            return $dockerfile;
        }

        function uploadFileToDockerfile($dockerfile, $fileUpload) {
            $filename = "/tmp/". $fileUpload['name'];
            $this->saveFile($fileUpload['tmp_name'], $filename);

            $dockerfile->setPathToFile($filename);
        }

        private function saveFile($content, $filename) {
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
    }
?>