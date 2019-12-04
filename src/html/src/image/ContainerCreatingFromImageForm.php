<?php

    function isEmptyOrNull($string) {
        return is_null($string) || empty($string);
    }

    function makeEmptyToNull($string) {
        return isEmptyOrNull($string) ? null : $string;
    }
?>

<form action="" method="POST">
<!--    --><?php
//    echo "Original image already expose ports ". join(', ', $GLOBALS['image']->getExposePorts())." .Do you want to add more ports? <br>";
//    ?>
<!--    How many containers that you want to create?-->
<!--    <select name="numbers-of-containers">-->
<!--        <option value="1">1</option>-->
<!--        <option value="2">2</option>-->
<!--        <option value="3">3</option>-->
<!--    </select>-->
    <br>

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

    <input type="checkbox" name="is-gpu"> Is GPU? <br>
    <input type="hidden" name="image-name" value="<?php echo $GLOBALS['image']->getName();?>"><br>

    <button type="submit" name="submit" value="Submit">Submit</button>
</form>

<?php
    if (!isset($_POST['submit'])) {
        die();
    }
    ?>

<div id="run-commnad-line">
    <br>Here is the command line:
    <code id="cmd-line">
        <?php
            include ("/var/www/html/src/model/DockerRunCommand.php");

            $dockerRunCommand = new DockerRunCommand();
            $dockerRunCommand->setContainerName(makeEmptyToNull($_POST['container-name']));
            $dockerRunCommand->setExposePorts(makeEmptyToNull($_POST['expose-ports']));
            $dockerRunCommand->setImageName(makeEmptyToNull($_POST['image-name']));
            $dockerRunCommand->setIsGPU(makeEmptyToNull($_POST['is-gpu']));
            $dockerRunCommand->setWorkingDir(makeEmptyToNull($_POST['working-dir']));
            $dockerRunCommand->setCommand(makeEmptyToNull($_POST['command']));

            echo $dockerRunCommand->toString();
        ?>

    </code><br>
    <button type="button" id="execute">Execute</button>
</div>

<div id="result" style="display: none">
</div>

<script>
    $('#execute').click(function (e) {
        e.preventDefault();

        if ($(this).hasClass("clicked"))
            return;
        $(this).addClass("clicked");

        $.post("/src/restclient/CommandExecution.php",
                {'cmd': $("#cmd-line").text()},
                function(data) {
                    var resultDiv = $("#result");
                    resultDiv.show(function () {
                        resultDiv.append("Success<br>");
                        resultDiv.append("Here is your container id: <a href='/src/html/src/container.php?container-id="+ data + "'>" + data + "</a>");
                    });
                });
    });
</script>

