<?php
    include_once (__DIR__."/../../../service/LibraryService.php");

    $libraryService = new LibraryService();
    $GLOBALS['libraries'] = $libraryService->getAllImageModelsMapById();
?>

<div class="col-md-10 ml-auto mr-auto">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
<!--                    <div class="card-icon">-->
<!--                        <i class="material-icons">mail_outline</i>-->
<!--                    </div>-->
                    <h4 class="card-title">Operating system</h4>
                    <p class="card-category">List of os</p>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <?php
                                foreach ($GLOBALS['libraries'] as $library) {
                                    if (!$library->isOS()) {
                                        continue;
                                    }

                                    echo "<tr>";
                                    echo "<th><a href='./Configuration.php?library-id=". $library->getId()."'>".$library->getName()."</a></th>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                    <div class="text-right">
                        <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#new-os">
                            <i class="material-icons">add</i> Create new OS
                        </button>
                    </div>

                    <div class="modal fade" id="new-os" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Create a new operating system</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="create-os-form" action="../../rest/LibraryRest.php'?>">

                                        <div class="row">
                                            <label class="col-md-3 col-form-label">OS name:</label>
                                            <div class="col-md-9">
                                                <div class="form-group bmd-form-group">
                                                    <input type="text" class="form-control" name="library-name" placeholder="OS name" required="true" aria-required="true">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 col-form-label">Is GPU:</label>
                                            <div class="col-md-9">
                                            <div class="togglebutton" style="margin-top: 15px">
                                                <label id="isGPU" >
                                                    <input type="checkbox" name="isGPU"><span class="toggle"></span>
                                                </label>
                                            </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="is-os" value="1">
                                        <div class="row">
                                            <label for="input-commands" class="col-md-3 col-form-label">Commands:</label>
                                            <div class="col-md-9">
                                                <div class="form-group bmd-form-group" style="margin-top: 15px">
                                                    <textarea class="form-control" name="input-commands" required="true" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" axjaxtype="post" id="create-os">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
<!--                    <div class="card-icon">-->
<!--                        <i class="material-icons">mail_outline</i>-->
<!--                    </div>-->
                    <h4 class="card-title">Libraries</h4>
                    <p class="card-category">List of libraries </p>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <?php
                                foreach ($GLOBALS['libraries'] as $library) {
                                    if ($library->isOS()) {
                                        continue;
                                    }

                                    echo "<tr>";
                                    echo "<th><a href='./Configuration.php?library-id=". $library->getId()."'>".$library->getName()."</th>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#new-library">
                            <i class="material-icons">add</i> Create new library
                        </button>
                    </div>

                    <div class="modal fade" id="new-library" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Create a new library</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="create-library-form" action="../../rest/LibraryRest.php'?>">
                                        <div class="row">
                                            <label class="col-md-3 col-form-label">Library name:</label>
                                            <div class="col-md-9">
                                                <div class="form-group bmd-form-group">
                                                    <input type="text" class="form-control" name="library-name" placeholder="Library name" required="true">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 col-form-label">Is GPU:</label>
                                            <div class="col-md-9">
                                                <div class="togglebutton" style="margin-top: 12px">
                                                    <label onclick="changeTo()" for="isGPU1">
                                                        <input id="isGPU1" type="checkbox" name="isGPU">
                                                        <span  class="toggle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label class="col-md-3 col-form-label">Parent libraries:</label>
                                            <div class="col-md-9">
                                            <select name="parent-library-ids[]" class="selectpicker required" multiple data-style="select-with-transition"  title="Choose library" data-size="7">
                                                <?php
                                                foreach ($GLOBALS['libraries'] as $library) {
                                                    echo "<option value='".$library->getId()."'> ". $library->getName()."</option>";
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="is-os" value="0">
                                        <input type="hidden" name="library-id" value="0">
                                        <div class="row">
                                            <label for="input-commands" class="col-md-3 col-form-label">Commands:</label>
                                            <div class="col-md-9">
                                                <div class="form-group bmd-form-group" style="margin-top: 15px">
                                                    <textarea class="form-control" name="input-commands" required="true" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" ajaxtype="post" id="create-library">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Library detail</h4>
                    <p class="card-category">The detail of library</p>
                </div>

                <div class="card-body">
                    <?php
                        if (isset($_GET['library-id'])) {
                            include_once ("LibraryDetail.php");
                        }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    $("#create-os").click(function (e) {
        upload($("#create-os-form"), $(this).attr("ajaxtype"));
    });

    $("#create-library").click(function (e) {
        upload($("#create-library-form"), $(this).attr("ajaxtype"));
    });

    $("#new-library").on("hidden.bs.modal", function () {
        $("#create-library-form").trigger( "reset" );
        $("#new-library .modal-title").text("Create a new library");
        $('#new-library select').selectpicker('refresh');
        $("#create-library").attr("ajaxtype", "post").text("Create");
    });

    $(document).ready(function() {
        // setFormValidation('#create-os-form');
        // setFormValidation('#create-library-form-1');
    });

    function changeTo() {
        if ($('#isGPU1').prop("checked") == false) {
            $('#isGPU1').prop('checked', true);
        } else {
            $('#isGPU1').prop('checked', false);
        }

        console.log(12)
        }

    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            },
        });
    }

    function upload(form, type) {
        if (!form.valid()) {
            return;
        }

        changeToggle(form);

        $.ajax({
            url:"/src/rest/LibraryRest.php",
            type: type,
            data: form.serialize(),
            success: function(data) {
                //location.reload();
                swal({
                    title: 'Created!',
                    text: 'Library has been created.',
                    type: 'success',
                    confirmButtonClass: "btn btn-success",
                    buttonsStyling: false,
                    onAfterClose: function () {
                        location.reload();
                    }
                });
            },
            fail : function(data) {
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

        form.closest(".modal").modal("hide");

        // location.reload();


        // $.post("/src/service/LibraryRest.php",
        //     form.serialize(),
        //     function(data) {
        //         location.reload();
        //     });

        form.closest(".modal").modal("hide");


        console.log(type);

        console.log(form.serialize());
    }

    function changeToggle(form) {
        // form.attr("isGPU", form.attr("isGPU") == "on" ? 1: 0);
        $("[name='isGPU']", form).val(function () {
           return $('#isGPU1').prop("checked") ? 1 : 0
        });

        return true;
    }
</script>