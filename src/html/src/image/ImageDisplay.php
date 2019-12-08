<?php
    require_once("/var/www/html/src/model/Image.php");
    require_once("/var/www/html/src/restclient/ImageClient.php");

    if (isset($_GET['image-id']))  {
        $imageClient = new ImageClient();
        $GLOBALS['image'] = $imageClient->getImageInfo($_GET['image-id']);

        if (!isset($GLOBALS['image'])) die();
    }  else die();
?>

<div class="card">
    <div class="card-header card-header-tabs card-header-primary">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if (!isset($_POST['submit'])) echo "active show"; ?>" href="#info" data-toggle="tab">
                            <i class="material-icons">info</i> Info
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#history" data-toggle="tab">
                            <i class="material-icons">notes</i> History
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (isset($_POST['submit'])) echo "active show"; ?>" href="#create" data-toggle="tab">
                            <i class="material-icons">create</i> Create container
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane <?php if (!isset($_POST['submit'])) echo "active show"; ?>" id="info">
                <?php
                    include_once("ImageInfoDisplay.php");
                ?>
            </div>
            <div class="tab-pane" id="history">
                <?php
                    include_once ("ImageHistoryDisplay.php");
                ?>
            </div>
            <div class="tab-pane <?php if (isset($_POST['submit'])) echo "active show"; ?>" id="create">
                <?php
                    include_once ('ContainerCreatingFromImageForm.php');
                ?>
            </div>
        </div>
    </div>
</div>

