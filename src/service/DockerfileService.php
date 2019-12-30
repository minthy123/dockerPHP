<?php
    include_once ('LibraryService.php');
    include_once ('ConfigService.php');
    include_once (__DIR__.'/../enum/Instruction.php');
    include_once (__DIR__.'/../utils/Utils.php');
    include_once (__DIR__.'/../model/Dockerfile.php');

    class DockerfileService {
        private const DOCKERFILE = "dockerfile";
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

            return $dockerfile;
        }

        function saveDockerfile(Dockerfile $dockerfile) {
            $this->config->increaseDockerCount();
            ConfigService::modifyConfig($this->config);
            $filename = $this->config->getDockerfileFolder() . self::DOCKERFILE . $this->config->getDockerCount();

            $dockerfile->setDockerfilePath($filename);

            Utils::saveFile($dockerfile->toString(false), $filename);
        }

        function createDockerfile($osId, $libraryIds) {
            $isGPU = false;
            $libraries = $this->libraryService->getLibrariesFromOS1($osId, $libraryIds, $isGPU);

            $dockerfile = $this->createCommand($libraries);
            $dockerfile->setIsGPU($isGPU);
            //$this->saveDockerfile($dockerfile);

            return $dockerfile;
        }

        function uploadFileToDockerfile(Dockerfile $dockerfile, array $fileUpload) {
            $filename = $this->config->getUploadFolder(). $fileUpload['name'];
            move_uploaded_file($fileUpload['tmp_name'], $filename);

            $dockerfile->setUploadFilePath($fileUpload['name']);
        }
    }
?>