<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-2">
        <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#link4" role="tablist">
                    Download
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#link5" role="tablist">
                    Upload
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="tab-content">
            <div class="tab-pane active" id="link4">
                <form method="get" action="/src/service/ContainerService.php" target="_blank">
                    <input type="text" name="path" placeholder="Input path">
                    <input type="hidden" name="container-id" value="<?php echo $GLOBALS['container']->getId()?>">
                    <input type="hidden" name="operation" value="DOWNLOAD">
                    <input type="submit" name="submit">
                </form>
            </div>
            <div class="tab-pane" id="link5">
                <form method="post" action="/src/service/ContainerService.php" target="_blank" enctype="multipart/form-data">
                    <input type="text" name="path" placeholder="Input path"><br>
                    <input type="file" name="uploadFile"><br>
                    <input type="hidden" name="container-id" value="<?php echo $GLOBALS['container']->getId()?>">
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>
</div>