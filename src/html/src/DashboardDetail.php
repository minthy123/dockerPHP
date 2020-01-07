<?php
    include_once (__DIR__."/../../service/LibraryService.php");
    include_once (__DIR__."/../../service/HostService.php");
    include_once (__DIR__."/../../restclient/ImageClient.php");
    include_once (__DIR__."/../../restclient/ContainerClient.php");
    $libraryService = new LibraryService();

    $hostService = new HostService();
    $hosts = $hostService->getAll();
    $chosenHost = $hosts[0];
    $imageClient = new ImageClient($chosenHost);
    $containerClient = new ContainerClient($chosenHost);
?>


<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="images.php">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>

                <p class="card-category">Image</p>
                <h3 class="card-title">
                    <?php
                        echo $imageClient->countImages();
                    ?>
                </h3>
                <div class="card-footer">
                    <div class="stats">
                        &nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="containers.php">
        <div class="card card-stats">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>

                <p class="card-category">Containers</p>
                <h3 class="card-title">
                    <?php
                    $count = $containerClient->countContainers();
                    echo $count[0]."/".$count[1];
                    ?>
                </h3>
                <div class="card-footer">
                    <div class="stats">
                        &nbsp;&nbsp;

                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>


    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="Configuration.php">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">library_books</i>
                    </div>

                    <p class="card-category">Libraries</p>
                    <h3 class="card-title">
                        <?php echo $libraryService->countOS().'/'.$libraryService->countLibrary();?>
                    </h3>
                    <div class="card-footer">
                        <div class="stats">
                            &nbsp;&nbsp;

                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="Configuration.php">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">cloud</i>
                    </div>

                    <p class="card-category">Servers</p>
                    <h3 class="card-title">
                        <?php echo $hostService->countHost();?>
                    </h3>
                    <div class="card-footer">
                        <div class="stats">
                            &nbsp;&nbsp;

                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>


<div class="row">
    <div class="col-md-4">
        <a href="dockerfile.php">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="material-icons dash-icon">create</i>
                        </div>
                        <div class="col-md-9">
                            <h4 class="create-new">Create Dockerfile</h4>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="Configuration.php">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                                <i class="material-icons dash-icon">settings</i>
                        </div>
                        <div class="col-md-9">
                            <h3>Configuration</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="Terminal.php">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                                <i class="fa fa-terminal dash-icon" aria-hidden="true"></i>
                           </div>
                        <div class="col-md-9">
                            <h3>Terminal</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?php
        include_once (__DIR__.'/host/HostListMini.php');
        ?>
    </div>
    <div class="col-md-6">
        <?php
            include_once (__DIR__.'/container/ContainerListMini.php');
        ?>
    </div>
</div>

<style>
    .dash-icon {
        text-align: center;
        margin: 10px;
        font-size: 50px
    }

    .create-new {
        font-size: 1.3625rem;
        margin-top: 20px;
    }
</style>
