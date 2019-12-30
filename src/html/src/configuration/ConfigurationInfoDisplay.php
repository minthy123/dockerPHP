
    <table class="table table-striped table-hover table-editable">
        <div id="config">
            <tbody>
                <tr>
                    <td>Name</td><td><div class="row-data" name="name"><?php echo $GLOBALS['config']->getProjectName();  ?></div></td>
                </tr>
                <tr>
                    <td>Version</td><td><div class="row-data" name="version"><?php echo $GLOBALS['config']->getVersion(); ?></td>
                </tr>
                <tr>
                    <td>Upload folder</td><td><div class="row-data" name="upload-folder"><?php echo $GLOBALS['config']->getUploadFolder(); ?></td>
                </tr>
                <tr>
                    <td>Dockerfile folder</td><td><div class="row-data" name="docker-socket-path"><?php echo $GLOBALS['config']->getDockerSocketPath(); ?></td>
                </tr>
                <tr>
                    <td>Docker unix socket</td><td ><div class="row-data" name="dockerfile-folder"><?php echo $GLOBALS['config']->getDockerfileFolder(); ?></td>
                </tr>
                <tr>
                    <td>Docker count</td><td ><div class="row-data" name="docker-count"><?php echo $GLOBALS['config']->getDockerCount(); ?></td>
                </tr>

                <tr>
                    <td>Port terminal</td><td ><div class="row-data" name="port-terminal"><?php echo $GLOBALS['config']->getPortTerminal(); ?></td>
                </tr>

                <tr>
                    <td>Port exec container</td><td><div class="row-data" name="port-exec"><?php echo $GLOBALS['config']->getPortExecContainer(); ?></td>
                </tr>
            </tbody>
        </div>
    </table>

<script src="editConfig.js"></script>