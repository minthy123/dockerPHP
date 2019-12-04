<?php
    require_once("/var/www/html/src/service/LibraryService.php");
    require_once("/var/www/html/src/model/OsAndLibraries.php");

    $libraryService = new LibraryService();
    $GLOBALS['osAndLibraries'] = $libraryService->getLibrariesSeperateByOS();
?>

<div id="choosing-os"><label>1) Please choose OS:</label><br>
    <form action="" method="get" id="choosing-os-1">
        <?php
            function chooseOSDefault(array $osLibraries, $osId) : int {
                if (empty($GLOBALS['osAndLibraries']))
                    die();

                if ($osId != null) {
                    foreach ($osLibraries as $osLibrary) {
                        if ($osLibrary->getOS()->getId() == $osId)
                            return $osId;
                    }
                }

                return $osLibraries[0]->getOS()->getId();
            }

            $_GET['os-id'] = chooseOSDefault($GLOBALS['osAndLibraries'], $_GET['os-id']);

            foreach ($GLOBALS['osAndLibraries'] as $osLibrary) {
                $checked = $osLibrary->getOS()->getId() == $_GET['os-id'] ? "checked=\"checked\"" : "";

                echo "<div class=\"form-check form-check-radio\">\n";
                echo "<label class=\"form-check-label\">";

                echo "<input class=\"form-check-input\" type=\"radio\" name=\"os-id\" value=\"". $osLibrary->getOS()->getId()."\" onclick=\"this.form.submit()\"". $checked ." >".$osLibrary->getOS()->getName();
                echo "<span class=\"circle\"><span class=\"check\"></span></span>";
                echo "</label>";
                echo "</div>";
            }
        ?>
    </form>
</div>

<div id="choosing-libraries">
    <label>2) Choosing libraries: </label><br>
    <form action="dockerfile_creation.php" method="post" enctype="multipart/form-data">
<!--        <select name="library-ids[]" multiple size = 6>-->
            <?php
                if (isset($_GET['os-id'])) {
                    foreach ($GLOBALS['osAndLibraries'] as $osLibrary) {
                        if ($osLibrary->getOs()->getId() == $_GET['os-id']) {
                            $osAndLibrary = $osLibrary;
                            break;
                        }
                    }

                    $numberOfLibraries = count($osLibrary->getLibraries());

                    for ($i=0; $i<$numberOfLibraries; $i++) {
                        $library = $osLibrary->getLibraries()[$i];
                        //echo $library->getName();
                        echo "<div class=\"form-check form-check-inline\">
                                  <label class=\"form-check-label\">";
                        echo "<input type=\"checkbox\" class=\"form-check-input\" name=\"library-ids[]\" value='".$library->getId()."'>".$library->getName();
                        echo "<span class=\"form-check-sign\">
                                        <span class=\"check\"></span>
                                    </span>
                                </label>
                            </div>";

                        if ($i != $numberOfLibraries && ($i+1) % 3 === 0) {
                            echo "<br>";
                        }
                    }
                }
            ?>


        <div id="accordion" role="tablist">
            <div class="card card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Advance building
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image-name" class="bmd-label-floating">3) Input the image name:</label>
                            <input type="text" class="form-control" id="image-name" name="image-name">
                        </div>
<!--                        <label>3) Input the image name:<br></label>-->
<!--                        <input type="text" name="image-name" placeholder="Image name"><br>-->

                        <div class="form-group form-file-upload form-file-multiple">
                            <label for="input" class="bmd-label-floating">4) Upload your file:</label>
                            <input type="file" multiple="" name="fileToUpload" id="input" class="inputFileHidden">
                            <div class="input-group">
                                <input type="text" class="form-control inputFileVisible">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-fab btn-round btn-primary">
                                        <i class="material-icons">attach_file</i>
                                    </button>
                                </span>
                            </div>
                        </div>

<!--                        <label>4) Upload your file:<br></label>-->
<!--                        <input type="file" name="fileToUpload" id="fileToUpload"><br>-->
                        <div class="form-group">
                            <label for="command-input" class="bmd-label-floating">5) Input command to run the file:</label>
                            <input type="text" class="form-control" id="command-input" name="command-input">
                        </div>
<!--                        <br>5) Input command to run the file:</br>-->
<!--                        <input type="text" name="command-input" placeholder="Command"><br>-->
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="os-id" value="<?php echo $_GET['os-id'];?>">
        <button name="submit" type="submit" value="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

