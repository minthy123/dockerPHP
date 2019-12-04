<?php
    include_once ('LibraryService.php');
    include_once ('ConfigService.php');
    include_once ('/var/www/html/src/enum/Instruction.php');
    include_once ('/var/www/html/src/model/Dockerfile.php');

    class DockerfileService {
        private $libraryService;

        function __construct(){
            $this->config = ConfigService::loadConfig();
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
            return $dockerfile;
        }

        function saveDockerfile(Dockerfile $dockerfile) {
            $filename = $this->config->getDockerfileFolder() . 'dockerfile';
            $dockerfile->setDockerfilePath($filename);

            self::saveFile($dockerfile->toString(false), $filename);
        }

        function createDockerfile($osId, $libraryIds) {
            $isGPU = false;
            $libraries = $this->libraryService->getLibrariesFromOS($osId, $libraryIds, $isGPU);

            $dockerfile = $this->createCommand($libraries);
            $dockerfile->setIsGPU($isGPU);
            $this->saveDockerfile($dockerfile);

            return $dockerfile;
        }

        function uploadFileToDockerfile(Dockerfile $dockerfile, array $fileUpload) {
            $filename = $this->config->getUploadFolder(). $fileUpload['name'];
            $this->saveFile($fileUpload['tmp_name'], $filename);

            $dockerfile->setUploadFilePath($filename);
        }

        private function saveFile(string $content, string $filename) {
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