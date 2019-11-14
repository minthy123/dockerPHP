<?php

    require_once('DockerRunService.php');
    require_once('DockerBuildService.php');
    require_once('DockerfileService.php');
    require_once('DockerOtherCommandsService.php');
    require_once('../restclient/CommandExecution.php');

    echo "Dockerfile ...<br>\n";
    echo "<code>\n";
    $ret = new DockerfileService();
    echo $ret->createDockerfile();
    echo "</code><br>\n";

    echo "### Docker command ####<br>\n";

    echo "Docker build: ";
    $ret = new DockerBuildService();


    $buildCommand =  $ret->generateDockerBuildCommand();
    echo $buildCommand ;
    echo "<button onclick=\"buildDocker(".$buildCommand.")\">Build</button><br>";


    echo "Docker run: ";
    $ret = new DockerRunService();
    echo $ret->generateDockerRunCommand();
    echo "<br>\n";

    $ret = new DockerOtherCommandsService();
    echo "Docker remove image: ";
    echo $ret->generateRemoveImage("test_image");
    echo "<br>\n";

    echo "Docker log: ";
    echo $ret->generateCheckLog("test_container");
    echo "<br>\n";

    echo "Docker port: ";
    echo $ret->generateCheckPort("test_container");
    echo "<br>\n";

    echo "Docker exec: ";
    echo $ret->generateExec("test_container");
    echo "<br>\n";

    echo "List all images: ";
    echo "<type=\"button\">Click Me!</button>";
    // echo $ret->generateExec("test_container");
    // echo "<br>\n";

    echo "#######################<br>\n<br>\n";
?>
