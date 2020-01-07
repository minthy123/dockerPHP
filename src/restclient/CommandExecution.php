<?php
    include_once (__DIR__."/../service/HostService.php");

	class CommandExecution {
		function executeSteam($cmd, string $pathExecution = './') {

		    $cmd .= " 2>&1"; //print stdout to stdout

//            var_dump($cmd);

			$descriptorspec = array(
			   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
			   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
			   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
			);

			flush();
            ob_flush();
            $process = proc_open($cmd, $descriptorspec, $pipes, realpath($pathExecution), array());
			if (is_resource($process)) {
			    while ($s = fgets($pipes[1], 30)) {
                    print preg_replace("/\r+/", "\r", str_replace("\n", "\r\n", $s));

                    flush();
    				ob_flush();
			    }
			}
		}

		public function replaceHost(string $cmd, $hostId){
            $hostService = new HostService();
            $host = $hostService->getHostById((int) $hostId);

            return str_replace("docker ", "docker -H tcp://".$host->getIp().":".$host->getPort()." ", $cmd);
        }
	}

	if (isset($_POST['cmd'])) {
		$commandExecution = new CommandExecution();

		include_once (__DIR__."/../service/ConfigService.php");
		$uploadFolder = ConfigService::loadConfig()->getUploadFolder();

		$cmd = $_POST['cmd'];

		if (isset($_POST['host-id']) && !empty($_POST['host-id'])) {
		    include_once (__DIR__."/../service/HostService.php");
		    $hostService = new HostService();
		    $host = $hostService->getHostById((int) $_POST['host-id']);

            $cmd = str_replace("docker ", "docker -H tcp://".$host->getIp().":".$host->getPort()." ", $cmd);
        }

		$commandExecution->executeSteam($cmd, $uploadFolder);
	}

?>