<?php

    function isEmptyOrNull($string) {
        return is_null($string) || empty($string);
    }

    function makeEmptyToNull($string) {
        return isEmptyOrNull($string) ? null : $string;
    }
?>

<div class="col-md-12">
<div class="card card-collapse">
    <div class="card-header" role="tab" id="headingOne">
        <h5 class="mb-0">
            <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Advance running container
                <i class="material-icons">keyboard_arrow_down</i>
            </a>
        </h5>
    </div>

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
            <form action="" method="POST" id="form-2">
            <!--    --><?php
            //    echo "Original image already expose ports ". join(', ', $GLOBALS['image']->getExposePorts())." .Do you want to add more ports? <br>";
            //    ?>
            <!--    How many containers that you want to create?-->
            <!--    <select name="numbers-of-containers">-->
            <!--        <option value="1">1</option>-->
            <!--        <option value="2">2</option>-->
            <!--        <option value="3">3</option>-->
            <!--    </select>-->
                <div class="form-group">
                    <label class="bmd-label-floating">Container name</label>
                    <input type="text" name="container-name" class="form-control" <?php if (!isEmptyOrNull($_POST['container-name'])) echo "value=".$_POST['container-name']; ?>>
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Working dir</label>
                    <input type="text" name="working-dir" class="form-control" <?php if (!isEmptyOrNull($_POST['working-dir'])) echo "value=".$_POST['working-dir']; ?>>
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Command</label>
                    <input type="text" name="command" class="form-control" <?php if (!isEmptyOrNull($_POST['command'])) echo "value=".$_POST['command']; ?>>
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Expose ports</label>
                    <input type="text" name="expose-ports" class="form-control" <?php if (!isEmptyOrNull($_POST['expose-ports'])) echo "value=".$_POST['expose-ports']; ?>>
                </div>

                <input type="checkbox" name="is-gpu" <?php if ($imageService->isOSNeededGPU($GLOBALS['image'])) echo "checked";?>> Is GPU? <br>
                <input type="hidden" name="image-name" value="<?php echo $GLOBALS['image']->getName();?>">
            </form>
        </div>
    </div>
</div>
<div class="card-footer">
<button type="submit" name="submit" form="form-2" class="btn btn-primary" value="Submit">Submit</button>
</div>
</div>

<?php
    if (!isset($_POST['submit'])) {
        die();
    }
?>

<div id="run-commnad-line">
    <br>Here is the command line:
    <pre>
        <?php
            include (__DIR__."/../../../model/DockerRunCommand.php");

            $dockerRunCommand = new DockerRunCommand();
            $dockerRunCommand->setContainerName(makeEmptyToNull($_POST['container-name']));
            $dockerRunCommand->setExposePorts(makeEmptyToNull($_POST['expose-ports']));
            $dockerRunCommand->setImageName(makeEmptyToNull($_POST['image-name']));
            $dockerRunCommand->setIsGPU(makeEmptyToNull($_POST['is-gpu']));
            $dockerRunCommand->setWorkingDir(makeEmptyToNull($_POST['working-dir']));
            $dockerRunCommand->setCommand(makeEmptyToNull($_POST['command']));
            $dockerRunCommand->setHost($chosenHost);

            echo "<code id=\"cmd-line\" class='bash'>";

            echo $dockerRunCommand->toString();
            echo "</code>"
        ?>
    </pre>
    <button type="button" class="btn btn-primary" id="execute">Execute</button>
</div>

<div id="result" style="display: none">
</div>

<script>
    $('#execute').click(function (e) {
        e.preventDefault();

        if ($(this).hasClass("clicked"))
            return;
        $(this).addClass("clicked");

        var hostId = $.urlParam("host-id");

        $.post("/src/restclient/CommandExecution.php",
            {'cmd': $("#cmd-line").text(), "host-id" : hostId},
            function(data) {
                // var resultDiv = $("#result");
                // resultDiv.show(function () {
                //     resultDiv.append("Success<br>");
                //     var href = "/src/html/src/container.php?container-id="+ data;
                //     if (hostId != null) {
                //         href = href + "&host-id=" + hostId;
                //     }
                //     resultDiv.append("Here is your container id: <a href='"+href+"'>" + data + "</a>");
                // });

                swal({
                    title: 'Done',
                    text: 'Your container was built successfully. Do you want to check out?',
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    reverseButtons: true,
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {
                        var lastSplash = window.location.href.lastIndexOf('/');
                        window.location.href = window.location.href.substr(0, lastSplash + 1) + "container.php?host-id=" + hostId + "&container-id=" + data;
                    }
                });
            });
    });
</script>

