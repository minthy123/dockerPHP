<html>
<head> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
</script>

</head>
<title> Name </title>
<body>

<!-- <?php
	// require_once('DockerRunService.php');
 //    require_once('DockerBuildService.php');
 //    require_once('DockerfileService.php');
 //    require_once('DockerOtherCommandsService.php');
 //    require_once('../restclient/CommandExecution.php');
?> -->

<div class="dockerfile">
<?php
	if ($_GET['library_id']) {
		require_once('../service/DockerfileService.php');
		echo 'Dockerfile ... <br>';
		echo '<code>';
		$dockerfileService = new DockerfileService();
		$GLOBALS['dockerfile'] = $dockerfileService->createDockerfile($_GET['library_id']);

		echo $GLOBALS['dockerfile']->toString(true);
		echo '</code>';
		echo '-----------';
	}
?>
</div>

<div class="dockerbuild">
<?php
	if ($GLOBALS['dockerfile']) {
		require_once('../service/DockerBuildService.php');
		$dockerBuildService = new DockerBuildService();
		$GLOBALS['dockerbuild'] = $dockerBuildService;

		echo "Build a image: ";
		echo '<code id="build-command">'.$dockerBuildService->generateDockerBuildCommand().'</code>';
		echo '<button id=\'button-build\'>Build</button>';
	}
?>
</div>
<div id='build-docker-log'> 
</div>

<script type="text/javascript">
	$('#button-build').click(function(e) {
		$.post('/src/restclient/CommandExecution.php', {cmd : $('#build-command').text()})
			.done(function(data) {
				$('#build-docker-log').append(data);
			});
	});
</script>


<div class="dockerrun">
	<?php
		if ($GLOBALS['dockerfile']) {
			require_once('../service/DockerRunService.php');
			$dockerRunService = new DockerRunService();

			echo "Run container: ";
			echo '<code id="run-command">'.$dockerRunService->createDockerRunFromCommands($GLOBALS['dockerfile']).'</code>';
			echo '<button id=\'button-run\'>Run</button>';
		}
	?>
</div>
<div id="run-docker-log"> </div>

<script type="text/javascript">
	$('#button-run').click(function(e) {
		$.post('/src/restclient/CommandExecution.php', {cmd : $('#run-command').text()})
			.done(function(data) {
				$('#run-docker-log').append(data);
			});
	});
</script>

<div class="list-images">
	All docker images:
	<button id="button-list-images">List</button>
</div>

<script type="text/javascript">
	$('#button-list-images').click(function(e) {
		$.get('/src/restclient/ImageClient.php?list-all=true')
			.done(function(data) {
				$('.list-images').append(data);
			});
	});
</script>

<div class="list-containers">
	All docker Containers:
	<button id="button-list-containers">List</button>
</div>

<script type="text/javascript">
	$('#button-list-containers').click(function(e) {
		$.get('/src/restclient/ContainerClient.php?list-all=true')
			.done(function(data) {
				$('.list-containers').append(data);
			});
	});
</script>

</body>
</html>