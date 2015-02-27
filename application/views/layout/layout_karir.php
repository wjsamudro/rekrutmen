<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rekrutmen | PT. Telekomunikasi Indonesia</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/bower_components/css/business-frontpage.css') ?>" rel="stylesheet">
    <?php if( isset($css) ){ 
    foreach ($css as $key => $style) {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $style ?>">
    <?php }} ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('karir') ?>" style="color:#fff;">
                	PT. Telekomunikasi Indoesia
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo site_url('karir') ?>">Home</a>
                    </li>
                    <li>
                        <a href="#">Cara Mendaftar</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Image Background Page Header -->
    <!-- Note: The background image is set within the business-casual.css file. -->
    <?php if( $this->uri->segment(1) == "karir" && ( $this->uri->segment(2) == "" || $this->uri->segment(2) == "index" ) ){ ?>
    <header class="business-header">
    </header>
    <?php }else{ ?>
    <div class="breadcrumb_gue">
    	<div class="container">
    		<h4 style="font-weight:bold;"><?php echo $sub_title; ?></h4>
    	</div>
    </div>
    <?php } ?>
    <!-- Page Content -->
    <div class="container">
        <hr>
        <div class="row">
        <?php echo $output; ?>
                    <div class="<?php echo ( $this->uri->segment(1) == "karir" && ( $this->uri->segment(2) == "" || $this->uri->segment(2) == "index" ) ) ? "col-sm-4" : "col-sm-2" ?>">

                <?php if( check_karir_login() == FALSE ){ ?>
                <?php if( $this->session->flashdata('error') != "" ){ ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>Warning!</strong> <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Login</h5>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo site_url('login/masuk'); ?>" method="post">
                            <div class="form-group">
                                <label for="email">E-mail :</label>
                                <input class="form-control" id="email" name="email" type="text" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" name="password" type="password" />
                            </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-action">
                                <input type="submit" class="btn btn-primary" value="login" />
                                <a href="<?php echo site_url('karir/daftar') ?>">&nbsp;&nbsp;Daftar Sekarang</a>
                            </form>
                        </div>

                    </div>
                </div>
                <?php }else { ?>
                        <div class="list-group">
                          <a href="<?php echo site_url('user/data_diri'); ?>" class="list-group-item <?php echo ( $this->uri->segment(2) == "data_diri" ? "active" : "" ) ?>">Data diri</a>
                          <a href="<?php echo site_url('user/data_pendidikan'); ?>" class="list-group-item <?php echo ( $this->uri->segment(2) == "data_pendidikan" ? "active" : "" ) ?>">Pendidikan</a>
                          <a href="<?php echo site_url("user/akun_anda") ?>" class="list-group-item <?php echo ( $this->uri->segment(2) == "akun_anda" ? "active" : "" ) ?>">Akun Anda</a>
                          <a href="<?php echo site_url('login/keluar'); ?>" class="list-group-item">Logout</a>
                        </div>
                <?php } ?>
            </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; PT. Telekomunikasi Indonesia</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.js'); ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <?php if( isset($js) ){ 
        foreach ($js as $key => $script) {
    ?>
    <script type="text/javascript" src="<?php echo $script ?>"></script>
    <?php
        }
    ?>
    <?php } ?>
    <?php if( isset($skript) ){ ?>
    <script type="text/javascript">
    <?php echo $skript; ?>
    </script>
    <?php } ?>
</body>

</html>