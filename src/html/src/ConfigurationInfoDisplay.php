<table class="table table-striped table-hover table-editable">
    <tbody>
        <tr>
            <td>Name</td><td><div class="row-data"><?php echo $GLOBALS['config']->getProjectName();  ?></div></td>
        </tr>
        <tr>
            <td>Version</td><td  contenteditable="true"><?php echo $GLOBALS['config']->getVersion(); ?></td>
        </tr> 
        <tr>
            <td>Upload folder</td><td  contenteditable="true"><?php echo $GLOBALS['config']->getUploadFolder(); ?></td>
        </tr>
        <tr>
            <td>Dockerfile folder</td><td contenteditable="true"><?php echo $GLOBALS['config']->getDockerSocketPath(); ?></td>
        </tr>
        <tr>
            <td>Docker unix socket</td><td contenteditable="true"><?php echo $GLOBALS['config']->getDockerfileFolder(); ?></td>
        </tr>
        <tr>
            <td>Docker count</td><td contenteditable="true"><?php echo $GLOBALS['config']->getDockerCount(); ?></td>
        </tr>
    </tbody>
</table>

<script src="editConfig.js"></script>