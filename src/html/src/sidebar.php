<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
    <div class="logo">
      <a href="#" class="simple-text logo-normal">
        Docker UI
      </a>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'dashboard') echo "active"; ?>">
          <a class="nav-link" href="./dashboard.php">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'dockerfile') echo "active"; ?>">
            <a class="nav-link" href="./dockerfile.php">
              <i class="material-icons">create</i>
              <p>Create new dockerfile</p>
            </a>
          </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'containers') echo "active"; ?>">
          <a class="nav-link" href="./containers.php">
            <i class="material-icons">person</i>
            <p>Containers</p>
          </a>
        </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'images') echo "active"; ?>">
          <a class="nav-link" href="./images.php">
            <i class="material-icons">content_paste</i>
            <p>Images</p>
          </a>
        </li>

      <li class="nav-item <?php if ($GLOBALS['toogle'] == 'configuration') echo "active"; ?>">
          <a class="nav-link" href="./Configuration.php">
              <i class="material-icons">settings_applications</i>
              <p>Configurations</p>
          </a>
      </li>

        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'terminal') echo "active"; ?>">
          <a class="nav-link" href="./Terminal.php">
            <i class="material-icons">content_paste</i>
            <p>Terminal</p>
          </a>
        </li>

<!--          <li class="nav-item --><?php //if ($GLOBALS['toogle'] == 'library') echo "active"; ?><!--">-->
<!--              <a class="nav-link" href="./LibraryDisplay.php">-->
<!--                  <i class="material-icons">content_paste</i>-->
<!--                  <p>Library</p>-->
<!--              </a>-->
<!--          </li>-->
      </ul>
    </div>
</div>


<?php
  if (!isset($GLOBALS['config'])) {
    include_once ("/var/www/html/src/service/ConfigService.php");

    $GLOBALS['config'] = ConfigService::loadConfig();
  }
?>
