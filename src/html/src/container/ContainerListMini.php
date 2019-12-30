<?php
    include_once (__DIR__.'/../../../restclient/ContainerClient.php');
    $containerClient = new ContainerClient($chosenHost);
    $containers = $containerClient->getAllContainers();
?>

<div class="card " >

    <div class="card-header card-header-rose">
        Containers
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>STATUS</th>
            </tr>
            </thead>

            <tbody>
                <?php
                $href = "./container.php?";
                $href .= is_null($chosenHost) ? "" : "host-id=".$chosenHost->getId()."&";

                for ($i=0; $i<5; $i++) {
                    $container = $containers[$i];
                    $href1 = $href . "container-id=".$container->getId();

                    echo "<tr>";
                    echo "\n";
                    echo "<td><a href=\"".$href1."\">". substr($container->getId(), 0, 12)."</a></td>";
                    echo "\n";
                    echo "<td class='wrap-td'>".$container->getName()."</td>";
                    echo "\n";
                    echo "<td class='wrap-td'>".$container->getStatus()."</td>";
                    echo "\n";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



