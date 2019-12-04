<?php
    class DockerRunCommand {
        private const COMMAND = "docker run -d {container_name} {gpu} {expose_ports} {publish_port} {working_dir} {-it} {image-id} {command}";

        private $containerName;
        private $exposePorts;
        private $workingDir;
        private $command;
        private $isGPU;

        private $imageId;
        private $imageName;
        private $containerId;

        private $runCommand;

        /**
         * @return mixed
         */
        public function getContainerName()
        {
            return $this->containerName;
        }

        /**
         * @param mixed $container_name
         */
        public function setContainerName($containerName): void
        {
            $this->containerName = $containerName;
        }

        /**
         * @return mixed
         */
        public function getExposePorts()
        {
            return $this->exposePorts;
        }

        /**
         * @param mixed $exposePorts
         */
        public function setExposePorts($exposePorts): void
        {
            $this->exposePorts = $exposePorts;
        }

        /**
         * @return mixed
         */
        public function getImageId()
        {
            return $this->imageId;
        }

        /**
         * @param mixed $imageId
         */
        public function setImageId($imageId): void
        {
            $this->imageId = $imageId;
        }

        /**
         * @return mixed
         */
        public function getContainerId()
        {
            return $this->containerId;
        }

        /**
         * @param mixed $containerId
         */
        public function setContainerId($containerId): void
        {
            $this->containerId = $containerId;
        }

        /**
         * @return mixed
         */
        public function getWorkingDir()
        {
            return $this->workingDir;
        }

        /**
         * @param mixed $workingDir
         */
        public function setWorkingDir($workingDir): void
        {
            $this->workingDir = $workingDir;
        }

        /**
         * @return mixed
         */
        public function getCommand()
        {
            return $this->command;
        }

        /**
         * @param mixed $command
         */
        public function setCommand($command): void
        {
            $this->command = $command;
        }

        /**
         * @return mixed
         */
        public function getIsGPU()
        {
            return $this->isGPU;
        }

        /**
         * @param mixed $isGPU
         */
        public function setIsGPU($isGPU): void
        {
            $this->isGPU = $isGPU;
        }

        /**
         * @return mixed
         */
        public function getImageName()
        {
            return $this->imageName;
        }

        /**
         * @param mixed $imageName
         */
        public function setImageName($imageName): void
        {
            $this->imageName = $imageName;
        }


        public function toString(){
            if (is_null($this->runCommand)) {
                self::createRunCommand();
            }

            self::handleContainerName();//str_replace("{container_id}", $containerName, $this->runCommand);

            return $this->runCommand;
        }

        private function createRunCommand(){
            $this->runCommand = self::COMMAND;

            self::handleImageName();
            self::handleCommand();
            self::handleExposePorts();
            self::handleWorkingDir();
            self::handleIsGPU();
            self::handlePublishPort();
        }

        private function handleImageName() {
            $image = self::getImageName() == null ? $this->imageId : $this->imageName;
            self::replaceArgsFromCommand("{image-id}", $image);
        }

        private function handleContainerName() {
            $containerName = self::getContainerName() == null ? "" : sprintf("--name %s", $this->containerName);
            self::replaceArgsFromCommand("{container_name}", $containerName);
        }

        private function handleIsGPU() {
            $gpu = self::getIsGPU() == false ? "" : "--gpus";
            self::replaceArgsFromCommand("{gpu}", $gpu);
        }

        private function handlePublishPort() {
            self::replaceArgsFromCommand("{publish_port}", "-P");
        }

        private function handleExposePorts() {
            $expose = "";

            if (self::getExposePorts() != null) {
                $expose = "";
                foreach ($this->exposePorts as $exposePort) {
                    $expose .= "--expose==".$exposePort." ";
                }
            }

            self::replaceArgsFromCommand("{expose_ports}", $expose);
        }

        private function handleCommand(){
            if (self::getCommand() != null) {
                self::replaceArgsFromCommand("{command}", $this->command);
                self::replaceArgsFromCommand("{-it}", "-it");
            } else {
                self::replaceArgsFromCommand("{command}", "");
                self::replaceArgsFromCommand("{-it}", "");
            }
        }

        private function replaceArgsFromCommand($replaceString, $replaceValue) {
            $this->runCommand = str_replace($replaceString, $replaceValue, $this->runCommand);
        }

        private function handleWorkingDir(){
            $workingDir = self::getWorkingDir() == null ? "" : sprintf("-w %s", $this->workingDir);

            self::replaceArgsFromCommand("{working_dir}", $workingDir);
        }
    }
?>