function runCommand($cmd) {
	$.post("/src/restclient/CommandExecution.php", $cmd);
}