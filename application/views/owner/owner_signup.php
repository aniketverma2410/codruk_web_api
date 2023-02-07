<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ProjectName; ?> | Owner Sign Up</title>
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
    .login-box-body, .register-box-body{margin-top: 48px;}
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
          <span>Codruk Owner Registration Panel</span>
          <form action="<?php echo base_url('owner/post_signup');?>" method="post" >
            <img class="truck_img" src="<?php echo base_url('mediaFile/logo.png'); ?>" style="width: 100%;height: 130px;">

            <div class="form-group has-feedback" style="margin-top: 5px;">
              <input type="text" class="form-control" name="name" placeholder="Name" required="">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback" style="margin-top: 5px;text-align: left;">
              <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" required="" maxlength="10">
               <span id="mob_err" style="color:red;"></span>
              <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>

             <div class="form-group has-feedback" style="margin-top: 5px;text-align: left;">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email">
              <span id="email_err" style="color:red;"></span>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
             <span class="eye glyphicon glyphicon-eye-open form-control-feedback" id="eye" onclick="show_password();"></span>
              <input type="hidden" id="checkval">
            </div>

            <div class="form-group has-feedback">
              <input type="checkbox" required="">
              By Registering you accept our <a target="blank" href="<?php echo base_url('owner/terms_condition')?>">Terms & Conditions</a>
            </div>

            <div class="row">
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit"  id="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
              </div>
             
              <!-- /.col -->
            </div>
             <br>
            <a href="<?php echo base_url('owner')?>" style="float: left;">I already have a membership</a>
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

   /* $(function() {

$("#email").keyup(function() {

  var email  =  $("#email").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/check_mail'); ?>",  
    data: 'email='+ email,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#email_err").html('Email is already exist');
          //$("#mobile").val('');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var mob = $('#mob_err').html();
          if (mob == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#email_err").html('');         
      }
    } 
   
  }); 
});
});*/


        $(function() {

$("#mobile").keyup(function() {

  var mobile  =  $("#mobile").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/check_mobile'); ?>",  
    data: 'mobile='+ mobile,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#mob_err").html('Mobile number is already exist');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var ema = $('#email_err').html();
          if (ema == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#mob_err").html('');
      }
    } 
   
  }); 
});
});

</script>
