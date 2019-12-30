<?php
    $GLOBALS['library-detail'] = $GLOBALS['libraries'][$_GET['library-id']];
?>

<div class="col-md-12 ml-auto mr-auto">
    <div class="row">
        <div class="col-md-3">Library name:</div>
        <div class="col-md-9">
            <div class="library" name="library-name">
                <?php echo $GLOBALS['library-detail']->getName(); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3" style="margin: auto">Is GPU:</div>
        <div class="col-md-9">
            <div class="togglebutton" style="margin-top: 12px">
                <label>
                    <input type="checkbox" <?php if ($GLOBALS['library-detail']->getIsGPU()) echo "checked"; ?> name="is-gpu"><span class="toggle disabled"></span>
                </label>
            </div>

            <div class="library" name="isGPU" style="display: none">
                <?php echo $GLOBALS['library-detail']->getIsGPU();?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        To install this library, we need to install

        <?php
            foreach ($GLOBALS['library-detail']->getParentLibraries() as $library) {
                echo $library->getName().", ";
            }
        ?>
            <div class="library" style="display: none" name="parent-libraries">
                <?php
                foreach ($GLOBALS['library-detail']->getParentLibraries() as $library) {
                    echo $library->getId().", ";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        Commands:
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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

            <div class="library" name="input-commands" style="display: none">
                <?php
                    foreach ($GLOBALS['library-detail']->getCommands() as $command) {
                    echo $command->toString();
                    echo "\n";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="library" name="library-id" style="display: none"><?php echo $_GET['library-id']; ?></div>

    <div class="text-right">
        <button type="button" class="btn btn-secondary btn-round" onclick="editLibrary('<?php echo $GLOBALS['library-detail']->getId();?>')">
            <i class="material-icons">edit</i>Modify
        </button>
        <button type="button" class="btn btn-primary btn-round" onclick="removeLibrary('<?php echo $GLOBALS['library-detail']->getId();?>')">
            <i class="material-icons">close</i>Delete
        </button>
    </div>
</div>

<script type="text/javascript">
    function removeLibrary(libraryId) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Yes, delete it!',
            buttonsStyling: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '../../rest/LibraryRest.php?' + $.param({"library-id": libraryId}),
                    type: 'DELETE',
                    success: function(response) {
                        swal({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            type: 'success',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false,
                            onAfterClose: function () {
                                location.reload();
                            }
                        });
                    }
                    ,error: function (data) {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! ' + data,
                            onAfterClose: function () {
                                location.reload();
                            }
                        })
                    }
                });
            }
        })
    }

    function editLibrary(libraryId) {
        var arr = {};
        $(".library").each(function() {
            arr[$(this).attr("name")] = $(this).text().trim();
        });

        $('#new-library input').each(function () {
            $(this).val(arr[$(this).attr("name")]);
        });

        $('#new-library select').each(function () {
            var a = arr["parent-libraries"].split(",").map((x) =>x.trim());

            $("#new-library select option").filter(function(){
                return a.includes($(this).attr('value'))
            }).prop('selected', true);

            $(this).selectpicker('refresh');
        });

        $('#new-library input[name=isGPU]').each(function () {
            if (arr["isGPU"] == "1") {
                $(this).prop('checked', true);
                $(this).prop('value', "on");
            }
        });

        $('#new-library textarea').each(function () {
            $(this).val(arr[$(this).attr("name")]);
        });


        $("#new-library .modal-title").text("Update library");
        $("#create-library").attr("ajaxtype", "put").text("Update");
        $('#new-library').modal('show');
    }
</script>