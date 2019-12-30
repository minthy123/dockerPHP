

<div class="col-md-8 ml-auto mr-auto">
    <div class="page-categories">
        <br>
    </div>
    <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#link7" role="tablist">
                <i class="material-icons">info</i> Description
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#link8" role="tablist">
                <i class="material-icons">location_on</i> Library
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                <i class="material-icons">gavel</i> Host
            </a>
        </li>
<!--        <li class="nav-item">-->
<!--            <a class="nav-link" data-toggle="tab" href="#link10" role="tablist">-->
<!--                <i class="material-icons">help_outline</i> Help Center-->
<!--            </a>-->
<!--        </li>-->
    </ul>


</div>

<div class="tab-content tab-space tab-subcategories">
    <div class="tab-pane" id="link7">

        <div class="col-md-4 ml-auto mr-auto">
            <div class="card">
    <!--            <div class="card-header">-->
    <!--                <h4 class="card-title">Description about product</h4>-->
    <!--                <p class="card-category">-->
    <!--                    More information here-->
    <!--                </p>-->
    <!--            </div>-->
                <div class="card-body">
                    <?php include_once("ConfigurationInfoDisplay.php"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane active" id="link8">
        <div class="col-md-12">
            <?php include_once(__DIR__."/../library/LibraryPage.php");?>
        </div>
    </div>
    <div class="tab-pane" id="link9">
        <?php
            include_once (__DIR__."/../host/HostList.php");
        ?>
    </div>

</div>

