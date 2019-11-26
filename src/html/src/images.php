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
    Images
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
  <?php $GLOBALS['toogle'] = 'images';
      include_once('sidebar.php'); ?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Images</a>
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
          <!-- Main content -->
          <div class="col-md-12">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><a href="">ID</a></th>
                  <th><a href="">NAME</a></th>
                  <th><a href="">RETROTAGS</a></th>
                  <th><a href="">CREATED</a></th>
                  <th><a href="">VITURAL SIZE</a>
                  </th>
                  <th>OPERATION</th>
                </tr>
              </thead>

              <?php
                include_once('/var/www/html/src/restclient/ImageClient.php');

                $imageClient = new ImageClient();
                $images = $imageClient->getAllImages();

                foreach ($images as $image) {
                  echo "<tr>\n";
                  echo "<td><a data-toggle=\"tooltip\" data-placement=\"top\" title='". $image->getId() ."' href=\"./image.php?image-id=".$image->getId()."\">". substr($image->getId(), 0, 12)."</a></td>\n";

                  echo "<td data-toggle=\"tooltip\" data-placement=\"top\" title=\"". $image->getName() ."\">".substr($image->getName(), 0, 20)."</td>\n";
                  echo "<td>".$image->getTag()."</td>\n";
                  echo "<td>".$image->getCreated()."</td>\n";
                  echo "<td>".$image->getSize()."</td>\n";
                  echo "<td><button class=\"btn btn-danger\" onclick=\"deleteImage('". str_replace("sha256:", "", $image->getId()) ."')\">Delete</button>";
                  echo "\n</tr>\n";
                }
              ?>
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
  <script>
      $(function () {
          $('[data-toggle="tooltip"]').tooltip()
      })
  </script>
  <script type="text/javascript"> 
    function deleteImage(imageId) {
        $.get('/src/restclient/ImageClient.php', {'image-id' : imageId, 'operation': 'delete'})
          .done(function(data) {
            console.log(data);
            location.reload(true);
          });
          console.log('Request Sent'); 
      }
  </script>
</body>

</html>