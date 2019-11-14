<?php
	echo "Dockerfile ...<br>\n";
    echo "<code>\n";
    $ret = new DockerfileService();
    echo $ret->createDockerfile();
    echo "</code><br>\n";
?>