<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">

            <div class="navbar-header">
                <a :href="siteUrl + '/'" class="navbar-brand">Главная</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">

                    <template v-for="(row, page) in routes" >
                        <li v-if="page == routeName" :key="page"  class="active" >
                            <a :href="siteUrl + '/index.php?page=' + page" v-html="row.label" ></a>
                        </li>
                        <li v-else :key="page"  >
                            <a :href="siteUrl + '/index.php?page=' + page" v-html="row.label" ></a>
                        </li>
                    </template>

                    <!--
                    <li class="active"><a href="<?php echo SITE_URL; ?>/extensions">
                            Внутренние номера<span class="sr-only">(current)</span>
                    </a></li>
                    -->


<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Настройки <span class="caret"></span></a>-->
<!--                        <ul class="dropdown-menu" role="menu">-->
<!--                            <li><a href="#"  >Action</a></li>-->
<!--                            <li><a href="#"  >Another action</a></li>-->
<!--                            <li><a href="#"  >Something else here</a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="#">Separated link</a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="#">One more separated link</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->

                </ul>

            </div>
            <!-- /.navbar-collapse -->


            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!--
                    <li><form class="navbar-form navbar-left" role="search" style="border:0px red solid" >
                            <div class="form-group">
                                <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                            </div>
                        </form>
                    </li>
                    -->

                    <li class="dropdown messages-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">

                                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                            </div>

                                            <h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>

                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <h3>Design some buttons<small class="pull-right">20%</small></h3>

                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>


                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Admin</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>

                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center"><a href="#">Followers</a></div>
                                    <div class="col-xs-4 text-center"><a href="#">Sales</a></div>
                                </div>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-custom-menu -->


</div></nav></header>  <!-- container -->