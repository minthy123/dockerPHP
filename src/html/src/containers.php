<!--
=========================================================
 Material Dashboard - v2.1.1
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Container list
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />

  <?php include_once('script.html'); ?>
</head>

<body class="">
  <div class="wrapper ">
    <?php $GLOBALS['toogle'] = 'containers';
      include_once('sidebar.php'); ?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Container</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Containers</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th><a hred="#">ID</a></th>
                        <th><a hred="#">NAME</a></th>
                        <th><a hred="#">IMAGE</a></th>
                        <!-- <th><a hred="#">COMMAND</a></th> -->
                        <!-- <th><a hred="#">PORT</a></th> -->
                        <th><a hred="#">STATE</a></th>
                        <th><a hred="#">STATUS</a></th>
                        <th><a hred="#">Operation</a></th>
                      </tr>
                    </thead>

                      <tbody>
                    <?php
                      include_once('/var/www/html/src/restclient/ContainerClient.php');

                      $comtainerClient = new ContainerClient();
                      $containers = $comtainerClient->getAllContainers();

                      foreach ($containers as $container) {
                        echo "<tr>";
                        echo "<td class='wrap-td' num='12'><a href=\"./container.html?imageid\">". $container->getId()."</a></td>";
                        echo "<td class='wrap-td'>".$container->getName()."</td>";
                        echo "<td class='wrap-td'>".$container->getImage()->getName()."</td>";
                        echo "<td class='wrap-td'>".$container->getState()."</td>";
                        echo "<td class='wrap-td'>".$container->getStatus()."</td>";
                        
                        echo "<td class=\"td-actions\">";
                        if ($container->getState() == "exited") {
                          echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-success\" onclick=startContainer('". str_replace("sha256:", "", $container->getId()) ."')><i class=\"material-icons\">play_arrow</i></button>";
                        } else if ($container->getState() == "running") {
                          echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger\" onclick=stopContainer('". str_replace("sha256:", "", $container->getId()) ."')><i class=\"material-icons\">pause</i></button>";
                        }

                        echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-info\" onclick=restartContainer('". $container->getId(). "><i class=\"material-icons\">loop</i></button>";
                        echo "<button type=\"button\" rel=\"tooltip\" class=\"btn btn-danger\" onclick=deleteContainer('". $container->getId(). "><i class=\"material-icons\">close</i></button>";

                        echo "</td>";

                        echo "</tr>";
                      }
                    ?>
                    </tbody> -->
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script type="text/javascript"> 
    function stopContainer(containerId) {
        $.get('/src/restclient/ContainerClient.php', {'container-id' : containerId, 'operation': 'STOP'})
          .done(function(data) {
            console.log(data);
            location.reload(true);
          });
          console.log('Request Sent'); 
      }

      function startContainer(containerId) {
        $.get('/src/restclient/ContainerClient.php', {'container-id' : containerId, 'operation': 'START'})
          .done(function(data) {
            console.log(data);
            location.reload(true);
          });
          console.log('Request Sent'); 
      }

    function deleteContainer(containerId) {
        $.get('/src/restclient/ContainerClient.php', {'container-id' : containerId, 'operation': 'DELETE'})
            .done(function(data) {
                console.log(data);
                location.reload(true);
            });
        console.log('Request Sent');
    }

    function restartContainer(containerId) {
        $.get('/src/restclient/ContainerClient.php', {'container-id' : containerId, 'operation': 'RESTART'})
            .done(function(data) {
                console.log(data);
                location.reload(true);
            });
        console.log('Request Sent');
    }
  </script>

    <script>
        $('.wrap-td').each(function () {
            var text = $(this).text();

            const LENGTH_TRIM = 20;
            var length = $(this).attr('num') ? $(this).attr('num') : LENGTH_TRIM;

            if (text.length >= length) {
                $(this).attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', text)
                    .text($.trim(text).substring(0, length) + "...");
            }
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
  
</body>

</html>