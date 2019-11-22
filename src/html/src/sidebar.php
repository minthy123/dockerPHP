<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
    <div class="logo">
      <a href="#" class="simple-text logo-normal">
        Docker UI
      </a>
    </div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'dashboard') echo "active"; else ""; ?>">
          <a class="nav-link" href="./dashboard.php">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'dockerfile') echo "active"; else ""; ?>">
            <a class="nav-link" href="./dockerfile.php">
              <i class="material-icons">create</i>
              <p>Create new dockerfile</p>
            </a>
          </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'containers') echo "active"; else ""; ?>">
          <a class="nav-link" href="./containers.php">
            <i class="material-icons">person</i>
            <p>Containers</p>
          </a>
        </li>
        <li class="nav-item <?php if ($GLOBALS['toogle'] == 'images') echo "active"; else ""; ?>">
          <a class="nav-link" href="./images.php">
            <i class="material-icons">content_paste</i>
            <p>Images</p>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo "http://".$_SERVER['SERVER_NAME'].":32768" ?>">
            <i class="material-icons">content_paste</i>
            <p>Terminal</p>
          </a>
        </li>
      </ul>
    </div>
</div>