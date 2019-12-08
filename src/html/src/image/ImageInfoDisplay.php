<table class="table table-striped table-hover">
    <tr>
        <td>ID</td><td><?php echo $GLOBALS['image']->getId();  ?></td>
    </tr>
    <tr>
        <td>Name</td><td><?php echo $GLOBALS['image']->getName();  ?></td>
    </tr>
    <tr>
        <td>Size</td><td><?php echo $GLOBALS['image']->getSize();  ?></td>
    </tr>
    <tr>
        <td>Virtual Size</td><td><?php echo $GLOBALS['image']->getVirtualSize();  ?></td>
    </tr>
    <tr>
        <td>Author</td><td><?php echo $GLOBALS['image']->getAuthor();  ?></td>
    </tr>
    <tr>
        <td>Expose ports</td>
        <td>
            <?php
                if ($GLOBALS['image']->getExposePorts() != null && !empty($GLOBALS['image']->getExposePorts())) {
                    echo join(", ", $GLOBALS['image']->getExposePorts());
                } ?>
        </td>
    </tr>
    <tr>
        <td>Entrypoint</td><td><?php echo $GLOBALS['image']->getEntryPoint();  ?></td>
    </tr>
    <tr>
        <td>Working dir</td><td><?php echo $GLOBALS['image']->getWorkingDir();  ?></td>
    </tr>

    <tr>
        <td>Parent</td><td><?php echo $GLOBALS['image']->getParentId();  ?></td>
    </tr>
    <tr>
        <td>Os</td><td><?php echo $GLOBALS['image']->getOs();  ?></td>
    </tr>
    <tr>
        <td>Architecture</td><td><?php echo $GLOBALS['image']->getArchitecture();  ?></td>
    </tr>
    <tr>
        <td>Created</td><td><?php echo $GLOBALS['image']->getCreated();  ?></td>
    </tr>
    <tr>
        <td>Env</td>
        <td>
            <?php
                echo join("<br>", $GLOBALS['image']->getEnv());
            ?>
        </td>
    </tr>
    <tr>
        <td>Docker version</td><td><?php echo $GLOBALS['image']->getDockerVersion();  ?></td>
    </tr>
</table>