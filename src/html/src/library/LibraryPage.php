<?php
    include_once ("/var/www/html/src/service/LibraryService.php");

    $libraryService = new LibraryService();
    $GLOBALS['libraries'] = $libraryService->getAllImageModelsMapById();
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Operating system</h4>
                </div>
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
                                echo "<th><a href='./LibraryDisplay.php?library-id=". $library->getId()."'>".$library->getName()."</a></th>";
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
                                <form method="POST" id="create-library-form" action="<?php echo "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].'/src/service/LibraryService.php'?>">
                                    <div class="form-group">
<!--                                        <label for="command-input" class="bmd-label-floating">OS Name</label>-->
                                        <input type="text" class="form-control" name="library-name" placeholder="OS name" required="true" aria-required="true">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">Hello
                                            <input type="checkbox" class="form-check-input" name="is-gpu"> Is GPU?
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label for="input-commands">Commands</label>
                                        <textarea class="form-control" name="input-commands" id="input-commands" rows="15"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="create-library">Create</button>
                            </div>

                            <script type="text/javascript">

                                $("#create-library").click(function (e) {
                                    //console.log(123);
                                    setFormValidation('#create-library-form');
                                    upload($("#create-library-form"));
                                });

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

                                function upload(form) {
                                    $.post("/src/service/LibraryService.php",
                                        form.serialize(),
                                        function(data) {
                                            location.reload();
                                        });
                                }
                            </script>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Library</h4>
                </div>
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
                                echo "<th><a href='./LibraryDisplay.php?library-id=". $library->getId()."'>".$library->getName()."</th>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <div class="text-right">
                    <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#new-os">
                        <i class="material-icons">add</i> Create new library
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Library detail</h4>
                </div>
            </div>

            <div class="card-body">
                <?php
                    include_once ("LibraryDetail.php");
                ?>
            </div>
        </div>
    </div>


</div>

