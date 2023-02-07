<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ProjectName; ?> | Owner Log In</title>
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

    }.bgImg{
      background-image:url(<?php echo base_url('mediaFile/bg-codruk.png'); ?>);
      background-repeat: no-repeat;
      background-size: 100% 100%;
      overflow-y: hidden;
    }
    .login-box-body, .register-box-body{margin-top: 141px;}
    .truck_img{ 
        height: 190px;
      }
          .eye{position: absolute;
    right: 0;
    cursor: pointer;
    z-index: 1000;
    pointer-events: painted;}
  </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
    <body class="bgImg">
      <center>

      <div class="login-box" >
        <div class="login-box-body">
       <!--    <p class="login-box-msg">
           <?php echo (!empty($this->session->flashdata('message')) ? $this->session->flashdata('message') :'Sign in to start your session'); ?></p> -->
          <?php echo (!empty($this->session->flashdata('message')) ? $this->session->flashdata('message') :''); ?>
          <span>Codruk Owner Login Panel</span>
          <form action="<?php echo base_url('owner/loginPost');?>" method="post" >
            <img class="truck_img" src="<?php echo base_url('mediaFile/logo.png'); ?>" style="width: 100%;height: 130px;">
            <div class="form-group has-feedback" style="margin-top: 5px;">
              <input type="text" class="form-control" name="username" placeholder="Mobile" maxlength="10">
              <span class="glyphicon glyphicon-phone form-control-feedback"></span>
              <span><?php echo form_error('username'); ?></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <span class="eye glyphicon glyphicon-eye-open form-control-feedback" id="eye" onclick="show_password();"></span>
              <input type="hidden" id="checkval">
              <span><?php echo form_error('password'); ?></span>
            </div>
            <div class="row">
              <!-- /.col -->
              <div class="col-xs-8">
              <div class="checkbox icheck">
                <label class="" style="float: left;">
                  <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Remember Me
                </label>
              </div>
            </div>

              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div>
              <!--  <div class="col-xs-4" style="float:right;">
                <a href="owner/owner_signup"><button type="button" class="btn btn-primary btn-block btn-flat">Sign Up</button></a>
              </div> -->
              <!-- /.col -->
            </div>
            <br>
            <a href="<?php echo base_url('owner/forgot_password')?>" style="float: left;">I forgot my password</a>
            <br>
            <a href="<?php echo base_url('owner/owner_signup')?>" style="float: left;">Register a new membership</a>
            &nbsp;
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
<script type="text/javascript">
   window.onload=function(){
      $(".alert").fadeOut(5000);
  }
   $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

     function show_password()
  {  
     var check_value = $('#checkval').val();
     if (check_value == '') 
     {
       $('#checkval').val('1'); 
       $('#password').attr('type','text');
     }
     else
     {
       $('#checkval').val(''); 
       $('#password').attr('type','password');
     }
     
     $('#eye').toggleClass('glyphicon-eye-open glyphicon-eye-close');

  }
</script>
