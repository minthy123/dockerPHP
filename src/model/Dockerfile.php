<?php
	class Dockerfile {
		private $from;

		private $runs;

		private $expose;
		private $cmd;

		function setFrom($from){
			$this->from = $from;
		}

		function getFrom() {
			return $this->from;
		}

		function setRuns($runs){
			$this->runs = $runs;
		}

		function getRuns() {
			return $this->runs;
		}

		function setExpose($expose){
			$this->expose = $expose;
		}

		function getExpose() {
			return $this->expose;
		}


		function setCmd($cmd){
			$this->cmd = $cmd;
		}

		function getCmd() {
			return $this->cmd;
		}

		function toString($forHTML) {
            $endline = $forHTML ? '<br>' : PHP_EOL;

            $result = $this->from->toString().$endline;

            foreach ($this->runs as $run) {
                $result .= $run->toString() . $endline;
            }

            if (!is_null($this->expose)) {
	            $result .= $this->expose->toString().$endline;
	        }
        	
        	if (!is_null($this->cmd)) {
	            $result .= $this->cmd->toString().$endline;
	        }

            return $result;
        }
	}
?>