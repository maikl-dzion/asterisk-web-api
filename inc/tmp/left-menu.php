<?php
    $siteUrl = '/land-page/adminLTE';
?>


<aside class="main-sidebar" style="display:none; width:0px;" >

    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
           <img src="<?php echo $siteUrl;?>/dist/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Petrov</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>

      <ul class="sidebar-menu" data-widget="tree">
	  
        <li class="header">Управление АТС</li>
		

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

  </aside>

