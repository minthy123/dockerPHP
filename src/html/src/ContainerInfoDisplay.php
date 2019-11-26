<table class="table table-striped table-hover">
    <tr>
        <td>ID</td><td><?php echo $GLOBALS['container']->getId();  ?></td>
    </tr>
    <tr>
        <td>Name</td><td><?php echo $GLOBALS['container']->getName();  ?></td>
    </tr>
    <tr>
        <td>Command</td><td><?php echo $GLOBALS['container']->getCommand();  ?></td>
    </tr>
    <tr>
        <td>Status</td><td><?php echo $GLOBALS['container']->getStatus();  ?></td>
    </tr>
    <tr>
        <td>Started at</td><td><?php echo $GLOBALS['container']->getStartedAt();  ?></td>
    </tr>
    <tr>
        <td>Finished at</td><td><?php echo $GLOBALS['container']->getFinishedAt();  ?></td>
    </tr>
    <tr>
        <td>Entrypoint</td><td><?php echo $GLOBALS['container']->getEntryPoint();  ?></td>
    </tr>
    <tr>
        <td>Working dir</td><td><?php echo $GLOBALS['container']->getWorkingDir();  ?></td>
    </tr>
    <tr>
        <td>Env</td>
        <td>
            <?php
                foreach ($GLOBALS['container']->getEnv() as $env) {
                    echo $env."<br>";
                }
            ?>
        </td>
    </tr>

    <tr>
        <td>Image</td><td><?php echo $GLOBALS['container']->getImage()->getName();  ?></td>
    </tr>

    <tr>
        <td>ImageId</td><td><?php echo $GLOBALS['container']->getImage()->getId();  ?></td>
    </tr>

    <tr>
        <td>Restart Count</td><td><?php echo $GLOBALS['container']->getRestartCount();  ?></td>
    </tr>

    <tr>
        <td>Hostname Path</td><td><?php echo $GLOBALS['container']->getHostnamePath();  ?></td>
    </tr>
    <tr>
        <td>Hosts Path</td><td><?php echo $GLOBALS['container']->getHostsPath();  ?></td>
    </tr>

    <tr>
        <td>Log Path</td><td><?php echo $GLOBALS['container']->getLogPath();  ?></td>
    </tr>
    <tr>
        <td>Driver</td><td><?php echo $GLOBALS['container']->getDriver();  ?></td>
    </tr>

    <tr>
        <td>Platform</td><td><?php echo $GLOBALS['container']->getPlatform();  ?></td>
    </tr>

</table>