<div class="iframe-container d-none d-lg-block">
    <iframe src="<?php echo "http://".$_SERVER['SERVER_NAME'].":". ConfigService::loadConfig()->getPortExecContainer() . "?arg=".$GLOBALS['container']->getId() ."&arg=/bin/bash"; ?>">
        <p>Your browser does not support iframes.</p>
    </iframe>
</div>