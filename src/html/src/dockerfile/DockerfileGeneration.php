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

		if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
            $dockerfileService->uploadFileToDockerfile($GLOBALS['dockerfile'], $_FILES['fileToUpload']);
        }

        $GLOBALS['dockerfile']->addCommand("echo \"\\n\";tail -f /dev/null");

		$GLOBALS['dockerfileString'] = $GLOBALS['dockerfile']->toString(false);

		$dockerfileService->saveDockerfile($GLOBALS['dockerfile']);

        require_once('/var/www/html/src/service/DockerBuildService.php');
        $dockerBuildService = new DockerBuildService();
        $GLOBALS['dockerbuildString'] = $dockerBuildService->generateDockerBuildCommand($GLOBALS['dockerfile']);
    } else {
        die();
    }
?>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header card-header-text card-header-primary">
                    <div class="card-text">
                        <h4 class="card-title">Dockerfile</h4>
                    </div>
                </div>
                <div class="card-body">
                    <pre>
                        <?php echo "<code>". $GLOBALS['dockerfile']->toString(false) . "</code>"; ?>
                    </pre>
                </div>
            </div>
        </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Build image</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="dockerbuild col-md-10">
                        <pre>
                            <?php echo "<code id=\"build-command\" class=\"bash\">".$GLOBALS['dockerbuildString']."</code>"; ?>
                        </pre>
                    </div>
                    <div class="col-md-2">
                        <button id='button-build-image' class="btn btn-primary btn-regular">Build</button>
                    </div>
                    
                </div>
                <div id='build-docker-log'></div>
            </div>
        </div>
    </div>

<script type="module" src="dockerfile/build.js">
</script>

<!--<div class="dockerrun">-->
<!--	--><?php
//		if ($GLOBALS['dockerfile']) {
//			require_once('/var/www/html/src/service/DockerRunService.php');
//			$dockerRunService = new DockerRunService();
//
//			echo "Run container: ";
//			echo '<code id="run-command">'.$dockerRunService->createDockerRunFromCommands($GLOBALS['dockerfile']).'</code>';
//			echo '<button id=\'button-run\'>Run</button>';
//		}
//	?>
<!--</div>-->
<!--<div id="run-docker-log"> </div>-->
<!---->
<!--<script type="text/javascript">-->
<!--	$('#button-run').click(function(e) {-->
<!--		$.post('/src/restclient/CommandExecution.php', {cmd : $('#run-command').text()})-->
<!--			.done(function(data) {-->
<!--				containerId = data;-->
<!---->
<!--				$('#run-docker-log').append("<br>Finished<br>");-->
<!--				$('#run-docker-log').append("Here is container id: " + containerId);-->
<!--				$('#run-docker-log').append("You can log in to here to check :" + containerId);-->
<!--			});-->
<!--	});-->
<!--</script>-->