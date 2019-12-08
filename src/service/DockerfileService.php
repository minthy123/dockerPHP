<?php
    include_once ('LibraryService.php');
    include_once ('ConfigService.php');
    include_once ('/var/www/html/src/enum/Instruction.php');
    include_once ('/var/www/html/src/utils/Utils.php');
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

//            $dockerfile->addCommand("tail -f /dev/null");
            return $dockerfile;
        }

        function saveDockerfile(Dockerfile $dockerfile) {
            $this->config->increaseDockerCount();
            ConfigService::modifyConfig($this->config);
            $filename = $this->config->getDockerfileFolder() . 'dockerfile'. $this->config->getDockerCount();


            $dockerfile->setDockerfilePath($filename);

            Utils::saveFile($dockerfile->toString(false), $filename);
        }

        function createDockerfile($osId, $libraryIds) {
            $isGPU = false;
            $libraries = $this->libraryService->getLibrariesFromOS($osId, $libraryIds, $isGPU);

            $dockerfile = $this->createCommand($libraries);
            $dockerfile->setIsGPU($isGPU);
            //$this->saveDockerfile($dockerfile);

            return $dockerfile;
        }

        function uploadFileToDockerfile(Dockerfile $dockerfile, array $fileUpload) {
            $filename = $this->config->getUploadFolder(). $fileUpload['name'];
//            Utils::saveFile($fileUpload['tmp_name'], $filename);
            move_uploaded_file($fileUpload['tmp_name'], $filename);

            $dockerfile->setUploadFilePath($fileUpload['name']);
        }
    }
?>