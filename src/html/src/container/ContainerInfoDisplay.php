<table class="table table-striped table-hover" style="word-break: break-all">
    <tr>
        <td style="width: 15%">ID</td><td><?php echo $container->getId();  ?></td>
    </tr>
    <tr>
        <td>Name</td><td><?php echo $container->getName();  ?></td>
    </tr>
    <tr>
        <td>Command</td><td><?php echo $container->getCmd();  ?></td>
    </tr>
    <tr>
        <td>Status</td><td><?php echo $container->getState();  ?></td>
    </tr>
    <tr>
        <td>Started at</td><td><?php echo $container->getStartedAt();  ?></td>
    </tr>
    <tr>
        <td>Finished at</td><td><?php echo $container->getFinishedAt();  ?></td>
    </tr>
    <tr>
        <td>Entrypoint</td><td><?php echo $container->getEntryPoint();  ?></td>
    </tr>
    <tr>
        <td>Working dir</td><td><?php echo $container->getWorkingDir();  ?></td>
    </tr>
    <tr>
        <td>Env</td>
        <td>
            <?php
                foreach ($container->getEnv() as $env) {
                    echo $env."<br>";
                }
            ?>
        </td>
    </tr>

    <tr>
        <td>Image</td><td><?php echo $container->getImage()->getName();  ?></td>
    </tr>

    <tr>
        <td>ImageId</td><td><?php echo $container->getImage()->getId();  ?></td>
    </tr>

    <tr>
        <td>Restart Count</td><td><?php echo $container->getRestartCount();  ?></td>
    </tr>

    <tr>
        <td>Hostname Path</td><td><?php echo $container->getHostnamePath();  ?></td>
    </tr>
    <tr>
        <td>Hosts Path</td><td><?php echo $container->getHostsPath();  ?></td>
    </tr>

    <tr>
        <td>Log Path</td><td><?php echo $container->getLogPath();  ?></td>
    </tr>
    <tr>
        <td>Driver</td><td><?php echo $container->getDriver();  ?></td>
    </tr>

    <tr>
        <td>Platform</td><td><?php echo $container->getPlatform();  ?></td>
    </tr>

</table>