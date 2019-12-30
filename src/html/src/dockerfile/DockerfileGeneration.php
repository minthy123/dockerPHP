<?php
    require_once(__DIR__."/../../../service/DockerfileService.php");

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

		if (isset($_POST['working-dir']) && !empty($_POST['working-dir'])) {
            $GLOBALS['dockerfile']->setWorkingDir($_POST['working-dir']);
        }

        $GLOBALS['dockerfile']->addCommand("tail -f /dev/null");

		$GLOBALS['dockerfileString'] = $GLOBALS['dockerfile']->toString(false);

		$dockerfileService->saveDockerfile($GLOBALS['dockerfile']);

        require_once(__DIR__.'/../../../service/DockerBuildService.php');
        $dockerBuildService = new DockerBuildService();
        $GLOBALS['dockerbuildString'] = $dockerBuildService->generateDockerBuildCommand($GLOBALS['dockerfile']);

        include_once (__DIR__."/../../../service/HostService.php");
        $hostService = new HostService();
        $hosts = $hostService->getAll();
        $chosenHost = $hosts[0];
    } else {
        die();
    }
?>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">receipt</i>
                    </div>
                    <h4 class="card-title">Dockerfile</h4>
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
            <div class="card-header card-header-rose card-header-icon">

                <div class="card-icon">
                    <i class="material-icons">build</i>
                </div>
                <div class="row">
                <h4 class="card-title">Build image</h4>

                <div class="col-md-4 ml-auto" style="margin-top: 12px;"">
                    <div class="text-center">
                        <select class="selectpicker" id="chosen-host" data-style="select-with-transition" title="Choose host" data-size="7" onchange="addHostParam(this.value)">
                            <?php
                                foreach ($hosts as $host) {
                                    $name = $host->getName().' ('.$host->getIp().':'.$host->getPort().')';
                                    $selected = $chosenHost == $host ? "selected" : "";

                                    echo "<option $selected value='".$host->getId()."'> ". $name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="dockerbuild col-md-10">
                        <pre>
                            <?php echo "<code id=\"build-command\" class=\"bash\">".$GLOBALS['dockerbuildString']."</code>"; ?>
                        </pre>
                    </div>
                    <div class="col-md-2">
                        <button id='button-build-image' class="btn btn-rose btn-regular" style="margin: 0">Build</button>
                    </div>
                    
                </div>
                <div id="image-name" style="display: none"><?php echo $GLOBALS['dockerfile']->getImageName(); ?></div>
                <div id='build-docker-log'></div>
            </div>
        </div>
    </div>

<script type="module" src="dockerfile/build.js"></script>

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