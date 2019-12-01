<?php
    $siteUrl = '/land-page/adminLTE';
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
           <img src="<?php echo $siteUrl;?>/dist/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Petrov</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
	  
        <li class="header">Управление АТС</li>
		
		<!--
        <li class="active treeview" >
		
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
		  
        </li>
		
		
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
		-->
        <li>
              <a href="<?php echo $siteUrl;?>/index.php" >
                  <i class="fa fa-university"></i> <span>Главная</span>
                  <span class="pull-right-container">
                      <small class="label pull-right bg-green"></small>
                  </span>
              </a>
        </li>

        <li>
              <a href="<?php echo $siteUrl;?>/pages/tables/serverSettings.php" >
                  <i class="fa fa-cubes"></i> <span>Настройки</span>
                  <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
              </a>
        </li>

        <li>
          <a href="<?php echo $siteUrl;?>/pages/tables/pages.php?page=trunks" >
            <i class="fa fa-cubes"></i> <span>Внешние номера</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>

        <li>
              <a href="<?php echo $siteUrl;?>/pages/tables/extensions.php" >
                  <i class="fa fa-th"></i> <span>Внутренние номера</span>
                  <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
              </a>
        </li>
		
		<li>
          <a href="<?php echo $siteUrl;?>/pages/tables/in-routes.php">
            <i class="fa  fa-share"></i> <span>Входящие линии</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>
		
		<li>
          <a href="<?php echo $siteUrl;?>/pages/tables/out-routes.php" >
            <i class="fa fa-reply"></i> <span>Исходящие линии</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>

		<li>
          <a href="<?php echo $siteUrl;?>/pages/tables/groups.php" >
            <i class="fa fa-group"></i> <span>Группа вызовов</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>
		
		<li>
          <a href="<?php echo $siteUrl;?>/index.php" >
            <i class="fa fa-life-buoy"></i> <span>Очереди</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>


        <li class="header">Просмотр и статистика</li>

        <li>
          <a href="<?php echo $siteUrl;?>/index.php" >
              <i class="fa fa-life-buoy"></i> <span>Общая статистика</span>
              <span class="pull-right-container">
          <small class="label pull-right bg-green"></small>
        </span>
          </a>
        </li>

		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>