<?php
    include_once (__DIR__.'/../../../service/HostService.php');

    $hostService = new HostService();
    $hosts = $hostService->getAll();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Servers</h4>
        <p class="card-category">
            More information here
        </p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Ip Address</th>
                    <th>Port</th>
                    <th class="text-center">Condition</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($hosts as $host) {
                            echo "<tr>\n";
                            echo "<td>".$host->getId(). "</td>\n";

                            echo "<td>".$host->getName()."</td>\n";
                            echo "<td>".$host->getIp()."</td>\n";
                            echo "<td>".$host->getPort()."</td>\n";

                            echo "<td class=\"text-center\">";
                            if ($hostService->ping($host->getId())) {
                                echo "online";
                            } else echo "offline";

                            echo "</td>\n";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
