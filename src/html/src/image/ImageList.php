
<div class="col-md-8 ml-auto mr-auto">
    <div class="card card-plain">
        <div class="card-header-primary card-header card-header-icon">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <div class="row">
                <h4 class="card-title mt-0">Image</h4>

                <div class="col-md-3 ml-auto" style="margin-top: 10px">
                    <?php include_once(__DIR__."/../host/HostChoosingDisplay.php"); ?>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div id="here">
                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Vitrual size</th>
                        <th class="text-right">Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once(__DIR__ . '/../../../restclient/ImageClient.php');

                            $imageClient = new ImageClient($chosenHost);
                            $images = $imageClient->getAllImages();

                            $href = "./image.php?";
                            $href .= is_null($chosenHost)? "" : "host-id=".$chosenHost->getId()."&";

                            foreach ($images as $image) {
                                $href1 = $href . "image-id=".$image->getId();

                                echo "<tr>\n";
                                echo "<td><a data-toggle=\"tooltip\" data-placement=\"top\" title='". $image->getId() ."' href=\"".$href1."\">". substr($image->getId(), 0, 12)."</a></td>\n";

                                echo "<td data-toggle=\"tooltip\" data-placement=\"top\" title=\"". $image->getName() ."\">".substr($image->getName(), 0, 20)."</td>\n";
                                echo "<td>".date("Y-m-d H:i:s", $image->getCreated())."</td>\n";
                                echo "<td>".$image->getSize()."</td>\n";
                                echo "<td class=\"text-right\"><button class=\"btn btn-danger\" onclick=\"deleteImage('". str_replace("sha256:", "", $image->getId()) ."')\">Delete</button>";
                                echo "\n</tr>\n";
                            }
                        ?>
                    </tbody>
            </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    function deleteImage(imageId) {
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
                $.get('/src/rest/ImageRest.php',
                    {'image-id' : imageId, 'operation': 'delete', 'host-id':$.urlParam('host-id')})
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

                $( "#here" ).load(window.location.href + " #here",function () {
                    // wrapText('.wrap-td');
                });
            }
        })
    }


</script>