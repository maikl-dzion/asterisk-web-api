<?php
   $siteUrl = '/land-page/adminLTE';
?>

<header class="main-header">
    <!-- Logo
    <a href="index2.html" class="logo">
      <span class="logo-mini"><b>A</b>LT</span>
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    -->

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="    margin-left: 0px;" >
      <!-- Sidebar toggle button
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      -->

      <div class="navbar-custom-menu1">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">

            <a href="<?php echo $siteUrl;?>/pages/tables/extensions.php" class="dropdown-toggle" data-toggle="dropdown">

              <!--<i class="fa fa-envelope-o"></i>-->
              <span class="label label-success"></span>
               Внешние номера
            </a>

          </li>

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">

            <a href="<?php echo $siteUrl;?>/pages/tables/extensions.php" class="dropdown-toggle1" data-toggle="dropdown1">
              <!--<i class="fa fa-bell-o"></i>-->
              <span class="label label-warning"></span>
              Внутренние номера
            </a>

          </li>

        </ul>
      </div>
    </nav>
</header>
