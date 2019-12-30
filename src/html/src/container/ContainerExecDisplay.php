<?php
    $dockerExecCommand = sprintf("docker -H tcp://%s:%d exec -it %s /bin/bash", $chosenHost->getIp(), $chosenHost->getPort(), $container->getId() );
?>

<div class="iframe-container d-none d-lg-block">
    <iframe src="<?php echo "http://".$_SERVER['SERVER_NAME'].":". ConfigService::loadConfig()->getPortExecContainer() . "?arg=".$dockerExecCommand; ?>">
        <p>Your browser does not support iframes.</p>
    </iframe>
</div>