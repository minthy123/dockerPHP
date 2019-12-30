<?php
    require_once (__DIR__."/../../../model/Container.php");
    require_once (__DIR__."/../../../restclient/ContainerClient.php");
    require_once (__DIR__."/../host/HostChoosing.php");

    if (isset($_GET['container-id']))  {
        $containerClient = new ContainerClient($chosenHost);
        $container = $containerClient->getContainerInfo($_GET['container-id']);

        if (is_null($container)) die();
    }  else die();
?>

<div class="col-md-8 ml-auto mr-auto">

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
                        <a class="nav-link" href="#network" data-toggle="tab">
                            <i class="material-icons">cloud</i> Network
                            <div class="ripple-container"></div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#log" data-toggle="tab" id="log-1">
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

                    <li class="nav-item">
                        <a class="nav-link" href="#down" data-toggle="tab">
                            <i class="material-icons">cloud</i> Download and upload
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
                <?php include_once("ContainerInfoDisplay.php"); ?>
            </div>
            <div class="tab-pane" id="network">
                <?php include_once("ContainerNetworkInfoDisplay.php"); ?>
            </div>
            <div class="tab-pane" id="log">
                <div id="log-container"></div>
            </div>
            <div class="tab-pane" id="exec">
                <?php
                    if ($GLOBALS['container']->isRunning()) {
                        include_once ("ContainerExecDisplay.php");
                    } else {
                        echo "<h3>Container is not working</h3>";
                    }
                ?>
            </div>

            <div class="tab-pane" id="down">
                <?php
                    if ($GLOBALS['container']->isRunning()) {
                        include_once ("ContainerDownload.php");
                    } else {
                        echo "<h3>Container is not working</h3>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

</div>

<script src="./container/log.js"></script>
<?php echo "<script>$('#log-1').click(function (e) {e.preventDefault();if($(this).hasClass('processing')) return; $(this).addClass('processing') ;setTimeout(function(){checkLogContainer('". $GLOBALS['container']->getId()  ."');}, 1)});</script>" ?>




