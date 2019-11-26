<?php
    require_once("/var/www/html/src/model/Image.php");
    require_once("/var/www/html/src/restclient/ImageClient.php");

    if (isset($_GET['image-id']))  {
        $imageClient = new ImageClient();
        $GLOBALS['image'] = $imageClient->getImageInfo($_GET['image-id']);

        if (!isset($GLOBALS['image'])) die();
    }  else die();
?>

<script src="log.js"></script>

<div class="card">
    <div class="card-header card-header-tabs card-header-primary">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#info" data-toggle="tab">
                            <i class="material-icons">info</i> Info
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#log" data-toggle="tab">
                            <i class="material-icons">notes</i> Log
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#exec" data-toggle="tab">
                            <i class="material-icons">cloud</i> Exec
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="info">
                <?php
                    include_once("ImageInfoDisplay.php");
                ?>
            </div>
            <div class="tab-pane" id="log">

            </div>
            <div class="tab-pane" id="exec">

            </div>
        </div>
    </div>
</div>

