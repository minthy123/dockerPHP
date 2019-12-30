<?php
    include_once (__DIR__.'/../../../restclient/ContainerClient.php');
    $containerClient = new ContainerClient($chosenHost);
    $containers = $containerClient->getAllContainers();
?>

<script type="text/javascript">
    function wrapText(e) {
        $(e).each(function () {
            var text = $(this).text();

            const LENGTH_TRIM = 40;

            if (text.length >= LENGTH_TRIM) {
                $(this).attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', text)
                    .text($.trim(text).substring(0, LENGTH_TRIM) + "...");
            }
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div id="here">
    <div class="card">
        <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
                <i class="material-icons">mail_outline</i>
            </div>
            <div class="row">
                <h4 class="card-title">Containers</h4>
                <p class="card-category"></p>
                <div class="col-md-4 ml-auto" style="margin-top: 15px">
                    <div class="text-right">
                        <?php include_once(__DIR__."/../host/HostChoosingDisplay.php"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><a hred="#">ID</a></th>
                    <th><a hred="#">NAME</a></th>
                    <th><a hred="#">IMAGE</a></th>
                    <!-- <th><a hred="#">COMMAND</a></th> -->
                    <!-- <th><a hred="#">PORT</a></th> -->
                    <th><a hred="#">STATE</a></th>
                    <th><a hred="#">STATUS</a></th>
                    <th class="text-right"><a hred="#">Operation</a></th>
                </tr>
                </thead>

                <tbody>
                <?php
                    $href = "./container.php?";
                    $href .= is_null($chosenHost) ? "" : "host-id=".$chosenHost->getId()."&";

                    foreach ($containers as $container) {
                        $href1 = $href . "container-id=".$container->getId();

                        echo "<tr>";
                        echo "\n";
                        echo "<td><a href=\"".$href1."\">". substr($container->getId(), 0, 12)."</a></td>";
                        echo "\n";
                        echo "<td class='wrap-td'>".$container->getName()."</td>";
                        echo "\n";
                        echo "<td class='wrap-td'>".$container->getImage()->getName()."</td>";
                        echo "\n";
                        echo "<td class='wrap-td'>".$container->getState()."</td>";
                        echo "\n";
                        echo "<td class='wrap-td'>".$container->getStatus()."</td>";
                        echo "\n";

                        echo "<td class=\"td-actions text-right\">";
                        if ($container->getState() == "exited") {
                            echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-success\" onclick=startContainer('". str_replace("sha256:", "", $container->getId()) ."')><i class=\"material-icons\">play_arrow</i></button>";
                        } else if ($container->getState() == "running") {
                            echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger\" onclick=stopContainer('". str_replace("sha256:", "", $container->getId()) ."')><i class=\"material-icons\">pause</i></button>";

                        }
                        echo "\n";
                        echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-info\" onclick=restartContainer('". $container->getId(). "')><i class=\"material-icons\">loop</i></button>";
                        echo "\n";
                        echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger\" onclick=deleteContainer('". $container->getId(). "')><i class=\"material-icons\">close</i></button>";
                        echo "\n";
                        echo "</td>";
                        echo "\n";
                        echo "</tr>";
                    }
                ?>
                </tbody>

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
                                <button type="button" class="btn btn-primary btn-link" id="delete-container">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">wrapText('.wrap-td');</script>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function stopContainer(containerId) {
        executeContainer(containerId, 'STOP');
    }

    function startContainer(containerId) {
        executeContainer(containerId, 'START');
    }

    function deleteContainer(containerId) {
        // $('#delete-container').val(containerId);
        // $('#confirm-delete').modal('show');
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
                $.get('/src/service/ContainerService.php',
                    {'container-id' : containerId, 'operation': 'DELETE', 'host-id':$.urlParam('host-id')})
                    .done(function(data) {
                        swal({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            type: 'success',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        });
                    })
                    .fail(function (data) {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                    });
                $( "#here" ).load(window.location.href + " #here" ,
                    function () {
                        wrapText('.wrap-td');
                    });
            }
        })
    }

    // $('#delete-container').click(function () {
    //     $.get('/src/service/ContainerService.php', {'container-id' : $(this).val(), 'operation': 'DELETE'})
    //         .done(function(data) {
    //             $( "#here" ).load(window.location.href + " #here",
    //                 function () {
    //                     wrapText('.wrap-td');
    //                     $('#confirm-delete').modal('hide');
    //                     $('body').removeClass('modal-open');
    //                     $('.modal-backdrop').remove();
    //                 });
    //             $(this).val(0);
    //             // location.reload(true);
    //         });
    // });

    function restartContainer(containerId) {
        executeContainer(containerId, 'RESTART');
    }

    function executeContainer(containerId, operation) {
        $.get('/src/service/ContainerService.php', {'container-id' : containerId, 'operation': operation})
            .done(function(data) {
                $( "#here" ).load(window.location.href + " #here",
                    function () {

                        wrapText('.wrap-td');
                    });

                // location.reload(true);
            });
    }
</script>