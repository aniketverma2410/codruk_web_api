<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$owner_id = $_GET['owner_id'];
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ProjectName; ?> | OTP Verification</title>
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
      .set_input_otp{
          width: 15.6% !important;
          height: 45px;
          text-align: center;
          background: #eee;
          border: 1px solid #eee;
          font-size: 22px;
      }
      #resend_otp{background: red;
        padding: 10px 15px;
        /*width: 100%;*/
        border: 2px solid #41528a;
        border-radius: 0px;
        /*font-size: 18px;*/
        color: #e5ffff;
        font-weight: bold;
      }
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
          <!-- <span>OTP Verification</span> -->
          <a href="<?php echo base_url('')?>"><i class="fa fa-arrow-left" style="float: left;"></i></a>
          <form action="<?php echo base_url('owner/check_otp');?>" method="post" >
            <img class="truck_img" src="<?php echo base_url('mediaFile/logo.png'); ?>" style="width: 100%;height: 130px;">
            <br>
            <?php $mobile = $this->db->get_where('owner_master',array('id'=>$owner_id))->row_array(); ?>
            <span>We have sent an OTP on your mobile number <br><i class="fa fa-mobile"></i> <?php echo $mobile['mobile']?></span>
            <div class="form-group has-feedback" style="margin-top: 5px;">

              <div class="col-xs-12 col-sm-12 divPadding" id="set_inputs">
                <input type="text" class="set_input_otp" name="otp_1" placeholder="" id="otp_1" data-id="1" maxlength="6">
                <?php for ($i=2; $i < 7; $i++) { ?>
                  <input type="text" class="set_input_otp" name="otp_<?= $i; ?>" placeholder="" id="otp_<?= $i; ?>" data-id="<?= $i; ?>" maxlength="1">
                <?php } ?>
              </div>

              <!-- <input type="number" class="form-control" name="otp" placeholder="Enter OTP"> -->
              <input type="hidden" name="owner_id" id="owner_id" value="<?php echo $owner_id;?>">  
            </div>
            
            <div class="row">
              <!-- /.col -->
              <div class="col-xs-4" style="margin-top: 16px;margin-left: 16px;" id="count_set_btn">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
              </div>

               <div class="col-xs-4" style="float:right;">
                <input type="text" class="form-control" value="<?php echo $ownerData['otp']?>">
              </div>
              <div class="form-group">
            <div class="col-xs-12 col-sm-12 log_text2">
              <span style="color:red;">0</span><span style="color:red;" id="countdown" class="timer"></span>
            </div>
            <!-- <div class="col-xs-12 col-sm-12 log_text3 divPadding">
              If you don't have an account please <a href="<?php //echo base_url('admin/welcome/register');?>" class="set_s_c">Sign Up</a>
            </div>
            <div class="col-xs-12 col-sm-12 log_text3 divPadding" style="padding-top:5px;">
              Trouble signing in
            </div>  
            <div class="col-xs-12 col-sm-12 log_text3 divPadding">
              Please contact Helpdesk - <span style="color: #41528a; font-weight: bold;">+91-9958 632707</span>
            </div> -->  
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
 <script type="text/javascript">
    window.onload=function(){
      $(".alert").fadeOut(5000);
      //var countdownTimer = setInterval('secondPassed()', 1000);
  }

    var seconds = 60;
    var form_url = '<?php echo site_url().'Admin/Welcome/checkMail'?>';
    function secondPassed() {
        var minutes = Math.round((seconds - 30)/60);
        var remainingSeconds = seconds % 60;
        var href = '<input type="button" name="Resend"  onclick="resendSms();" value="Resend OTP Code" id="resend_otp">';
        if (remainingSeconds < 10) {
           remainingSeconds = "0" + remainingSeconds;  
        }
        document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
        if (seconds == 0) {
            clearInterval(countdownTimer);
            document.getElementById('count_set_btn').innerHTML = href;
            
            document.getElementById("form_id").action = form_url;
            //document.getElementById('countdown').innerHTML = href;
        } else {
          seconds--;
        }
    }
    var countdownTimer = setInterval('secondPassed()', 1000);

    function resendSms() {
        var owner_id = $('#owner_id').val();
        var urls = '<?php echo base_url('owner/resend_otp') ?>';
         $.ajax({
              url: urls,
              type: 'post',
              dataType: 'JSON',
              data: {'owner_id': owner_id},
              success: function(res) {
               window.location.reload();
              }
            });

        //window.location.href = url;
    };

   $('.set_input_otp').keyup(function() {

      for (var i = 1; i < 7; i++) {
        var get_val = $('#otp_'+i).val();
        if (get_val == '') {
          $('#otp_'+i).focus();
          $(':input[type="submit"]').prop('disabled', true);
        } else {
          $(':input[type="submit"]').prop('disabled', false);
        }
        
      }
    });


    
  $('#otp_1, #otp_2, #otp_3, #otp_4, #otp_5, #otp_6').keyup(function(e){
    var value = $('#otp_1').val();
    //alert(value);
    var arry = [];
    var ids = $(this).data('id');
    if ($('#otp_'+ids).val() == '') {
      $('#otp_'+ids).focus();
      $(this).is(':focus');
      $(this).prev(':input').focus()
    } else {
      
      if($(this).val().length == 1) {
        $(this).next(':input').focus()
      } else {
        
        if($(this).val().length == 6) {
          var str = $(this).val();
            var urls = '<?php echo base_url('owner/setInputs') ?>';

            $.ajax({
              url: urls,
              type: 'post',
              dataType: 'JSON',
              data: {'in_values': str},
              success: function(res) {
                $('#set_inputs').html(res);
                $(':input[type="submit"]').prop('disabled', false);
              }
            });

        }
      }
    }
  });
</script> 
