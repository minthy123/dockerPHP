<?php
    require_once("/var/www/html/src/service/DockerfileService.php");

    if (isset($_POST['os-id']) && isset($_POST['library-ids'])) {
        $dockerfileService = new DockerfileService();
		$GLOBALS['dockerfile'] = $dockerfileService->createDockerfile($_POST['os-id'], $_POST['library-ids']);
		
		if (isset($_POST['image-name'])) {
			$GLOBALS['dockerfile']->setImageName($_POST['image-name']);
		}

		if (isset($_POST['command-input']) && !empty($_POST['command-input'])) {
		    $GLOBALS['dockerfile']->addCommand($_POST['command-input']);
        }

		if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] >0 ) {
            $dockerfileService->uploadFileToDockerfile($GLOBALS['dockerfile'], $_FILES['fileToUpload']);
        }
    } else {
        die();
    }
?>

<div id="dockerfile">Dockerfile:<br>
    <code>
        <?php
            if (isset($GLOBALS['dockerfile'])) {
                echo $GLOBALS['dockerfile']->toString(true);
            }
        ?>
    </code>
</div>


<div class="dockerbuild">
<?php
	if (isset($GLOBALS['dockerfile'])) {
		require_once('/var/www/html/src/service/DockerBuildService.php');
		$dockerBuildService = new DockerBuildService();
		$GLOBALS['dockerbuild'] = $dockerBuildService;

		echo "Build a image: ";
		echo '<code id="build-command">'.$dockerBuildService->generateDockerBuildCommand($GLOBALS['dockerfile']).'</code>';
		echo '<button id=\'button-build-image\'>Build</button>';
	}
?>

</div>
<div id='build-docker-log'>
</div>

<script type="module" src="build.js">
</script>

<div class="dockerrun">
	<?php
		if ($GLOBALS['dockerfile']) {
			require_once('/var/www/html/src/service/DockerRunService.php');
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