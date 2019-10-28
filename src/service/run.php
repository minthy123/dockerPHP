<?php

    require_once('DockerRunService.php');
    require_once('DockerBuildService.php');
    require_once('DockerfileService.php');
    require_once('DockerOtherCommandsService.php');

    echo "Dockerfile ...\n";
    $ret = new DockerfileService();
    echo $ret->createDockerfile();

    echo "### Docker command ####\n";

    echo "Docker build: ";
    $ret = new DockerBuildService();
    echo $ret->generateDockerBuildCommand();
    echo "\n";

    echo "Docker run: ";
    $ret = new DockerRunService();
    echo $ret->generateDockerRunCommand();
    echo "\n";

    $ret = new DockerOtherCommandsService();
    echo "Docker remove image: ";
    echo $ret->generateRemoveImage("test_image");
    echo "\n";

    echo "Docker log: ";
    echo $ret->generateCheckLog("test_container");
    echo "\n";

    echo "Docker port: ";
    echo $ret->generateCheckPort("test_container");
    echo "\n";

    echo "Docker exec: ";
    echo $ret->generateExec("test_container");
    echo "\n";

    echo "#######################\n\n";
?>
