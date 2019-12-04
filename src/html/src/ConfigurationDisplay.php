<?php

?>

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
                        <a class="nav-link" href="#library" data-toggle="tab">
                            <i class="material-icons">notes</i> Library
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
                    include_once ("ConfigurationInfoDisplay.php");
                ?>
            </div>
            <div class="tab-pane" id="library">
                <?php
                ?>
            </div>
        </div>
    </div>
</div>

