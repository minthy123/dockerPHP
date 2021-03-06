<table class="table table-striped table-hover">
    <tr>
        <td>Bridge</td><td><?php echo $container->getNetwork()->getBridge();  ?></td>
    </tr>
    <tr>
        <td>Sandbox Id</td><td><?php echo $container->getNetwork()->getSandboxId();  ?></td>
    </tr>
    <tr>
        <td>Sandbox key</td><td><?php echo $container->getNetwork()->getSandboxKey();  ?></td>
    </tr>
    <tr>
        <td>Endpoint Id</td><td><?php echo $container->getNetwork()->getEndpointId();  ?></td>
    </tr>
    <tr>
        <td>Gateway</td><td><?php echo $container->getNetwork()->getGateway();  ?></td>
    </tr>
    <tr>
        <td>IP Address</td><td><?php echo $container->getNetwork()->getIpAddress();  ?></td>
    </tr>
    <tr>
        <td>MacAddress</td><td><?php echo $container->getNetwork()->getMacAddress();  ?></td>
    </tr>
    <tr>
        <td>Ports</td>
        <td>
            <?php

                foreach ($container->getNetwork()->getPorts() as $port) {
                    echo $port->getPrivatePort(). " => ". $_SERVER['SERVER_NAME'].":".$port->getPublicPort();
                    echo "<br>";
                }
            ?>

        </td>
    </tr>

</table>