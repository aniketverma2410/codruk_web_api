<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ProjectName; ?> || Log In</title>
  <link rel="icon" href="<?php echo base_url('mediaFile/logo.png'); ?>" type="image/x-icon">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('theme'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme'); ?>/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme'); ?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme'); ?>/plugins/iCheck/square/blue.css">
  <style type="text/css">
    span p{color: red;}
    .login-logo, .register-logo {
      font-size: 35px;
      text-align: center;
      margin-bottom: 0px;
      font-weight: 300;
    }
  </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
    <body class="hold-transition login-page" style="background-image:url(<?php echo base_url('mediaFile/bg-codruk.png'); ?>);background-size: 100%;">
      <center><br><br><br><br><br>
      <div class="login-box" >
        <div class="login-box-body">
       <!--    <p class="login-box-msg">
           <?php echo (!empty($this->session->flashdata('message')) ? $this->session->flashdata('message') :'Sign in to start your session'); ?></p> -->
          <?php echo (!empty($this->session->flashdata('message')) ? $this->session->flashdata('message') :'Admin Login Pannel'); ?>
          <form action="<?php echo base_url('admin-login');?>" method="post" >
            <img src="<?php echo base_url('mediaFile/logo.png'); ?>" style="width: 100%;height: 130px;">
            <div class="form-group has-feedback">
              <br>
              <input type="email" class="form-control" name="username" placeholder="Email">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              <span><?php echo form_error('username'); ?></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" name="password" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              <span><?php echo form_error('password'); ?></span>
            </div>
            <div class="row">
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.login-box-body -->
      </div>
      <!-- /.login-box -->
      </center>
      <script src="<?php echo base_url('theme'); ?>/bower_components/jquery/dist/jquery.min.js"></script>
      <script src="<?php echo base_url('theme'); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url('theme'); ?>/plugins/iCheck/icheck.min.js"></script>
    </body>
</html>
