<?php
    include_once (__DIR__.'/../service/ConfigService.php');
    include_once (__DIR__.'/../model/Config.php');

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        parse_str(file_get_contents('php://input'), $_PUT);
        $config = ConfigService::loadConfig();

        if ($_PUT['name'] != null) {
            $config->setProjectName($_PUT['name']);
        }

        if ($_PUT['version'] != null) {
            $config->setVersion($_PUT['version']);
        }

        if ($_PUT['docker-count'] != null) {
            $config->setDockerCount($_PUT['docker-count']);
        }

        if ($_PUT['dockerfile-folder'] != null) {
            $config->setDockerfileFolder($_PUT['dockerfile-folder']);
        }
        if ($_PUT['upload-folder'] != null) {
            $config->setUploadFolder($_PUT['upload-folder']);
        }

        if ($_PUT['upload-folder'] != null) {
            $config->setUploadFolder($_PUT['upload-folder']);
        }

        if ($_PUT['port-terminal'] != null) {
            $config->setPortTerminal($_PUT['port-terminal']);
        }

        ConfigService::modifyConfig($config);
    }
?>