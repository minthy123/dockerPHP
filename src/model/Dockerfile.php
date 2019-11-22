<?php
	class Dockerfile {
	    const EMPTY_STRING = "";

		private $from;
		private $runs;
		private $expose;
		private $cmd;

		private $isGPU;
		private $imageName;

		private $pathToFile;

		function __construct() {
            $this->runs = [];
            $this->expose = [];
            $this->cmd = new CommandEntity(0, Instruction::CMD, self::EMPTY_STRING, 0);
            $this->pathToFile = null;
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

        function setPathToFile($pathToFile) {
            $this->pathToFile = $pathToFile;
        }

        function getPathToFile() {
            return $this->pathToFile;
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
            $this -> imageName = $imageName;
        }

        function getImageName() {
            return $this->imageName;
        }

        function addCommand($command) {
		    $cmdString = $this->cmd->getCmd();

		    if ($cmdString != self::EMPTY_STRING) {
                $cmdString .= " | ";
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

		function toString($forHTML) {
            $endline = $forHTML ? '<br>' : PHP_EOL;

            $result = $this->from->toString().$endline.$endline;

            foreach ($this->runs as $run) {
                $result .= $run->toString() . $endline;
            }

            $result .= $endline;

            if (!is_null($this->pathToFile)) {
                $result .= (new CommandEntity(0, Instruction::WORKDIR, '/home', 0))->toString() . $endline;
                $result .= (new CommandEntity(0, Instruction::ADD, $this->pathToFile.' /home/', 0))->toString() . $endline;
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