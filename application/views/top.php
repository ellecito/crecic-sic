<?php if(isset($home) and $home){ ?>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header"> 
            <span class="navbar-brand" style="height: unset;">
                <img src="<?php echo base_url(); ?>assets/img/favicon.png" />
            </span> 
        </div>
    </nav>
<?php }else{ ?>
  <div id="wrapper">
  <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img width="80%" src="<?php echo base_url(); ?>assets/img/favicon.png" />
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url(); ?>perfil/"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Informes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>estudio-factibilidad/"><i class="fa fa-edit fa-fw"></i> Estudio de Factibilidad</a>
                        </li>
                        <?php if($this->session->userdata("usuario")->perfil->codigo  == 1){ ?>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Mantenedores<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url(); ?>usuarios/">Usuarios</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>perfiles/">Perfiles</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>cursos/">Cursos</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>tipo-curso/">Tipo Curso</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>empresas/">Empresas</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>giros/">Giros</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>regiones/">Región</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>comunas/">Comunas</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>sucursales/">Sucursales</a>
                                </li>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>tipo-manual/">Tipo Manual</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>rubros/">Rubros</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <li>
                            <a href="http://35.189.5.192/capacitacion/"><i class="fa fa-edit fa-fw"></i> SIC Antiguo</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<?php } ?>