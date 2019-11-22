<?php
    require_once("/var/www/html/src/service/LibraryService.php");
    require_once("/var/www/html/src/model/OsAndLibraries.php");

    $libraryService = new LibraryService();
    $GLOBALS['osAndLibraries'] = $libraryService->getLibrariesSeperateByOS();
?>

<div id="choosing-os">1) Please choose OS:<br>
    <form action="" method="get" id="choosing-os-1">
        <?php
            foreach ($GLOBALS['osAndLibraries'] as $osLibrary) {
                $checked = isset($_GET['os-id']) && ($osLibrary->getOS()->getId() == $_GET['os-id']) ? "checked=\"checked\"" : ""; 
                echo "<input type=\"radio\" name=\"os-id\" value=\"". $osLibrary->getOS()->getId()."\" onclick=\"this.form.submit()\"". $checked ." >".$osLibrary->getOS()->getName();
                echo "<br>";
            }
        ?>
    </form>
</div>

<div id="choosing-libraries">2) Choosing libraries: <br>
    <form action="dockerfile_creation.php" method="post" enctype="multipart/form-data">
        <select name="library-ids[]" multiple size = 6>
            <?php
                if (isset($_GET['os-id'])) {
                    foreach ($GLOBALS['osAndLibraries'] as $osLibrary) {
                        if ($osLibrary->getOs()->getId() == $_GET['os-id']) {
                            $osAndLibrary = $osLibrary;
                            break;
                        }
                    }

                    foreach ($osLibrary->getLibraries() as $library) {
                        echo $library->getName();
                        echo "<option value='".$library->getId()."'>".$library->getName()."</option>";
                    }
                }
            ?>
        </select>
        <input type="hidden" name="os-id" value="<?php echo $_GET['os-id'];?>"><br>
        <br>3) Input the image name:<br>
        <input type="text" name="image-name" placeholder="Image name"><br>
        
        <br>4) Upload your file:<br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <br>5) Input command to run the file:</br>
        <input type="text" name="command-input" placeholder="Command"><br>
        <br>
        
        <input name="submit" type="submit" value="submit">
    </form>
</div>