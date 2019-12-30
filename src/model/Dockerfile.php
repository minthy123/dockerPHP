<?php
	class Dockerfile {
	    const EMPTY_STRING = "";

		private $from;
		private $runs;
		private $expose;
		private $cmd;

		private $isGPU;
		private $imageName;

		private $uploadFilePath;
		private $dockerfilePath;
		private $workingDir;

		function __construct() {
            $this->runs = [];
            $this->expose = [];
            $this->cmd = new CommandEntity(0, Instruction::CMD, self::EMPTY_STRING, 0);
            $this->uploadFilePath = null;
            $this->workingDir = "/home";
		}

        function setFrom($from){
			$this->from = $from;
		}

		function getFrom() {
			return $this->from;
		}

		function setRuns($runs) {
			$this->runs = $runs;
		}

		function getRuns() : array {
			return $this->runs;
		}

        function setUploadFilePath($uploadFilePath) {
            $this->uploadFilePath = $uploadFilePath;
        }

        function getUploadFilePath() {
            return $this->uploadFilePath;
        }

		function setExpose($expose){
			$this->expose = $expose;
		}


		function getExpose() : array {
			return $this->expose;
		}

		function setCmd($cmd){
			$this->cmd = $cmd;
		}

		function getCmd() {
			return $this->cmd;
		}

		function setIsGPU($isGPU) {
            $this -> isGPU = $isGPU;
        }

        function getIsGPU() {
            return $this->isGPU;
		}
		
		function setImageName($imageName) {
            $this -> imageName = $imageName == null || empty($imageName) ? "test_image".ConfigService::loadConfig()->getDockerCount() : $imageName;
        }

        function getImageName() {
            return $this->imageName;
        }

        function addCommand($command) {
		    $cmdString = $this->cmd->getCmd();

		    if ($cmdString != self::EMPTY_STRING) {
                $cmdString .= " ; ";
            }
		    $cmdString .= $command;

            $this->cmd->setCmd($cmdString);
        }

        function addRun($command) {
            array_push($this->runs, $command);
        }

        function addEnv($command) {
            array_push($this->expose, $command);
        }

        /**
         * @return mixed
         */
        public function getDockerfilePath()
        {
            return $this->dockerfilePath;
        }

        /**
         * @param mixed $dockerfilePath
         */
        public function setDockerfilePath($dockerfilePath): void
        {
            $this->dockerfilePath = $dockerfilePath;
        }

        /**
         * @return string
         */
        public function getWorkingDir(): string
        {
            return $this->workingDir;
        }

        /**
         * @param string $workingDir
         */
        public function setWorkingDir(string $workingDir): void
        {
            $this->workingDir = $workingDir;
        }

		function toString($forHTML) {
            $endline = $forHTML ? '<br>' : PHP_EOL;

            $result = $this->from->toString().$endline.$endline;

            foreach ($this->runs as $run) {
                $result .= $run->toString() . $endline;
            }

            $result .= $endline;

            if (!is_null($this->uploadFilePath)) {
                $result .= (new CommandEntity(-1, Instruction::WORKDIR, $this->getWorkingDir(), -1))->toString() . $endline;
                $result .= (new CommandEntity(-1, Instruction::COPY, $this->uploadFilePath.' '.$this->getWorkingDir(), -1))->toString() . $endline;
                $result .= $endline;
            }

			foreach ($this->expose as $expose) {
				$result .= $expose->toString() . $endline;
			}

            $result .= $endline;
        	
        	if (!is_null($this->cmd)) {
	            $result .= $this->cmd->toString().$endline;
	        }

            return $result;
        }
	}
?>