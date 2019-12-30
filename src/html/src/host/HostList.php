<?php
    include_once (__DIR__."/../../../service/HostService.php");
    $hostService = new HostService();
    $hosts = $hostService->getAll();
?>

<div class="col-md-5 ml-auto mr-auto">
    <div class="card">
    <div class="card-header">
        <h4 class="card-title">Servers</h4>
        <p class="card-category">
            More information here
        </p>
    </div>
    <div class="card-body">
        <div id="here">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Ip Address</th>
                        <th>Port</th>
                        <th class="text-right">Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($hosts as $host) {
                                echo "<tr name='".$host->getId()."'>\n";
                                echo "<td name='host-id'>".$host->getId(). "</td>\n";

                                echo "<td name='name'>".$host->getName()."</td>\n";
                                echo "<td name='ip'>".$host->getIp()."</td>\n";
                                echo "<td name='port'>".$host->getPort()."</td>\n";

                                echo "<td class=\"text-right td-actions\" style='display: table-cell'>";
                                echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-info\" data-original-title title onclick=editHost('". $host->getId(). "') data-original-title=\"\" title=\"\"><i class=\"material-icons\">create</i></button>";
                                echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger\" data-original-title title onclick=deleteHost('". $host->getId(). "') data-original-title=\"\" title=\"\"><i class=\"material-icons\">close</i></button>";
                                echo "</td>\n";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-rose btn-round" data-toggle="modal" data-target="#new-host">Add
                <span class="btn-label btn-label-right">
                    <i class="material-icons">add</i>
                  </span>
            </button>
        </div>

    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h5>Are you sure you want to delete?</h5>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-link" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary btn-link" id="delete-host">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="new-host" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create new host</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="create-host-form">
                            <div class="row">
                                <label class="col-sm-3 col-form-label modal-label">Name</label>
                                <div class="col-sm-8">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" name="name" required="true" aria-required="true" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label modal-label">Ip address</label>
                                <div class="col-sm-8">
                                    <div class="form-group bmd-form-group">
                                        <input class="form-control" name="ip" required="true" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label modal-label">Port</label>
                                <div class="col-sm-8">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" number="true" required="true" name="port" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <input type="text" name="host-id" value="0" style="display: none">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" form="create-host-form" id="create-host">Create</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .modal-label {
        padding: 17px 5px 0 0;
        text-align: right;
    }
</style>
<script>
    $('#create-host').click(function (e) {
        var form = '#' + $(this).attr("form");
        if ($(form).valid()){
            e.preventDefault();

            var type = $(form + " input[name=host-id]").first().val() == 0 ? "POST" : "PUT";

            $.ajax({
                type: type,
                url: '../../rest/HostRest.php',
                data: $(form).serialize(),
                success: function (data) {
                    $("#new-host").modal("hide");
                    $(form).trigger( "reset" );
                    $('#create-host').text("Create");
                    $( "#here" ).load(window.location.href + " #here" );
                }
            });
        }
    });

    function editHost(hostId) {
        var tdId = 'tr[name=' + hostId + ']';

        $(tdId).children().each(function () {
            var name = $(this).attr('name');
            var value = $(this).text();
            if (name === null) return;

            $('#create-host-form  input[name='+ name +']').each(function () {
                $(this).val(value);
            })
        });

        $("#create-host").text("Update");
        $("#new-host").modal("show");
    }

    function deleteHost(hostId) {
        $("#delete-host").val(hostId);
        $('#confirm-delete').modal('show');
    }

    $('#delete-host').click(function () {
        sendDelete($(this).val());
        $('#confirm-delete').modal('hide');
        $(this).val(0)
    });

    function setFormValidation(id) {
        $(id).validate({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
            },
            success: function (element) {
                $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').append(error);
            },
        });
    }

    function sendDelete(hostId) {
        $.ajax({
            url: "../../rest/HostRest.php",
            type: 'DELETE',
            data: {'host-id': hostId},
            success: function (data) {
                $( "#here" ).load(window.location.href + " #here" );
            }
        });
    }

    $(document).ready(function() {
        setFormValidation('#create-host-form');
    });

</script>