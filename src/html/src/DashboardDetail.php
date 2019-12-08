<?php
    include_once ("/var/www/html/src/service/LibraryService.php");
    $libraryService = new LibraryService();
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
                        include_once ("/var/www/html/src/restclient/ImageClient.php");
                        $imageClient = new ImageClient();
                        echo $imageClient->countImages();
                        ?>
                </h3>
                <div class="card-footer">
                    <div class="stats">
                        Hello

                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="containers.php">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>

                <p class="card-category">Containers</p>
                <h3 class="card-title">
                    <?php
                    include_once ("/var/www/html/src/restclient/ContainerClient.php");
                    $containerClient = new ContainerClient();
                    $count = $containerClient->countContainers();

                    echo $count[0]."/".$count[1];
                    ?>
                </h3>
                <div class="card-footer">
                    <div class="stats">
                        Hello

                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>


    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="LibraryDisplay.php">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">content_copy</i>
                    </div>

                    <p class="card-category">Operating system</p>
                    <h3 class="card-title">
                        <?php echo $libraryService->countOS()?>
                    </h3>
                    <div class="card-footer">
                        <div class="stats">
                            Hello

                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="LibraryDisplay.php">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">content_copy</i>
                    </div>

                    <p class="card-category">Libraries</p>
                    <h3 class="card-title">
                        <?php echo $libraryService->countLibrary()?>
                    </h3>
                    <div class="card-footer">
                        <div class="stats">
                            Hello

                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>


<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="dockerfile.php">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                </div>

                <div class="card-body">
                    Create a new dockerfile
                </div>
            </div>
        </a>
    </div>
</div>
