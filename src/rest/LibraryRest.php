<?php
    include_once (__DIR__.'/../service/LibraryService.php');
    include_once (__DIR__.'/../entity/LibraryEntity.php');

    if (isset($_GET['method'])) {
        $libraryService = new LibraryService();

        switch ($_GET['method']) {
            case 'count_library':
                echo $libraryService->countLibrary();
                break;

            case 'count_os':
                echo $libraryService->countOS();
                break;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (!empty($_POST['library-name']) && !empty($_POST['input-commands'])) {
            $isGPU = isset($_POST['isGPU']) && $_POST['isGPU'] == "1" ? true : false;
            $library = new LibraryEntity(-1, $_POST['library-name'], $isGPU);

            $libraryService = new LibraryService();

            $commands = LibraryService::parseCommand($_POST['input-commands']);
            if (empty($commands)) {
                die ("error");
            }

            $library->setCommands($commands);
            $libraryId = $libraryService->addLibrary($library);

            $isOS = isset($_POST['is-os']) && $_POST['is-os'] ? true : false;
            $libraryService->addDependence($libraryId, $_POST['parent-library-ids']);
        } else {
            die ("error");
        }
    }

//    var_dump($_POST);


    if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        $libraryService = new LibraryService();
        $libraryService->removeLibrary($_GET['library-id']);
    }

    if ($_SERVER['REQUEST_METHOD'] == "PUT") {
        parse_str(file_get_contents('php://input'), $_PUT);

        var_dump($_PUT);
        $libraryService = new LibraryService();

        $library = new LibraryModel();
        //        $hostEntity->setDockerSocketPath($_PUT['docker_socket_path']);
        $library->setId($_PUT['library-id']);
        $isGPU = isset($_PUT['isGPU']) && $_PUT['isGPU']  == "1" ? true : false;

        $library->setIsGPU($isGPU);
        $library->setName($_PUT['library-name']);
        $library->setCommands(LibraryService::parseCommand($_PUT['input-commands']));
        $library->setParentLibraries($_PUT['parent-library-ids']);

        $libraryService->editLibrary($library);
    }
?>