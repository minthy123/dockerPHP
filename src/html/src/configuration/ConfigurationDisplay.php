<!--<div class="card">-->
<!--    <div class="card-header card-header-tabs card-header-primary">-->
<!--        <div class="nav-tabs-navigation">-->
<!--            <div class="nav-tabs-wrapper">-->
<!--                <ul class="nav nav-tabs" data-tabs="tabs">-->
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link active" href="#info" data-toggle="tab">-->
<!--                            <i class="material-icons">info</i> Info-->
<!--                            <div class="ripple-container"></div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="#library" data-toggle="tab">-->
<!--                            <i class="material-icons">notes</i> Library-->
<!--                            <div class="ripple-container"></div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card-body">-->
<!--        <div class="tab-content">-->
<!--            <div class="tab-pane active" id="info">-->
<!--                --><?php
//                    include_once("ConfigurationInfoDisplay.php");
//                ?>
<!--            </div>-->
<!--            <div class="tab-pane" id="library">-->
<!--                --><?php
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<div class="col-md-8 ml-auto mr-auto">
    <div class="page-categories">
        <h3 class="title text-center">Configuration</h3>
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
    <div class="tab-pane active" id="link8">
<!--        <div class="col-md-12">-->
        <?php include_once("library/LibraryPage.php");?>
<!--        </div>-->
    </div>
    <div class="tab-pane" id="link9">
        <?php include_once("library/LibraryPage.php");?>
    </div>
    <div class="tab-pane" id="link10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Help center</h4>
                <p class="card-category">
                    More information here
                </p>
            </div>
            <div class="card-body">
                From the seamless transition of glass and metal to the streamlined profile, every detail was carefully considered to enhance your experience. So while its display is larger, the phone feels just right.
                <br>
                <br> Another Text. The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design.
            </div>
        </div>
    </div>
</div>

