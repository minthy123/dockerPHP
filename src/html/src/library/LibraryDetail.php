<?php
    if (!isset($_GET['library-id'])) {
        die();
    }

    $GLOBALS['library-detail'] = $GLOBALS['libraries'][$_GET['library-id']];
?>
<div>
    Library name: <?php echo $GLOBALS['library-detail']->getName(); ?> <br>
    Is GPU: <?php echo $GLOBALS['library-detail']->getIsGPU(); ?> <br>
    Is OS: <?php echo $GLOBALS['library-detail']->isOS(); ?> <br>
    To install this library, we need to install
    <?php
        foreach ($GLOBALS['library-detail']->getParentLibraries() as $library) {
            echo $library->getName().", ";
        }
    ?>
</div>
<div>
    Command:
    <pre>
        <?php
            echo "<code class=\"docker\">";
            foreach ($GLOBALS['library-detail']->getCommands() as $command) {
                echo $command->toString();
                echo "\n";
            }
            echo "</code>";
        ?>
    </pre>
</div>

<div class="text-right">
    <button type="button" class="btn btn-secondary btn-round">
        <i class="material-icons">edit</i>Modify
    </button>
    <button type="button" class="btn btn-primary btn-round" onclick="removeLibrary('<?php echo $GLOBALS['library-detail']->getId();?>')">
        <i class="material-icons">close</i>Delete
    </button>
</div>

<script type="text/javascript">
    function removeLibrary(libraryId) {
        $.ajax({
            url: '/src/service/LibraryService.php?' + $.param({"library-id": libraryId}),
            type: 'DELETE',
            data: {"library-id": libraryId},
            success: function(response) {
                //console.log(response);
                location.reload();
            }
        });
    }
</script>