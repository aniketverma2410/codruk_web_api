<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $pageTitle; ?></title>
  <link rel="icon" href="<?php echo base_url('mediaFile/logo.png'); ?>" type="image/x-icon">

  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Ionicons -->

  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url('theme/'); ?>dist/css/skins/_all-skins.min.css">
  <script src="<?php echo base_url('theme/'); ?>bower_components/jquery/dist/jquery.min.js"></script>


 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .skin-blue .main-header .navbar {
      background-color: #FFCC01;
    }
    .skin-blue .main-header .logo {
      background-color: #FFCC01;
      color: #000;
      border-bottom: 0 solid transparent;
    }
    .skin-blue .main-header .logo:hover {
      background-color: #09c6c6;
    }
    .skin-blue .main-header li.user-header {
      background-color: #FFCC01;
    }
    .skin-blue .main-header .navbar .sidebar-toggle:hover {
      background-color: #09c6c6;
    }
    .skin-blue .sidebar-menu>li.active>a {
      border-left-color: #000;
    }
    /*hedder navigation color*/
    .loader {
      border: 6px solid #f3f3f3;
      border-radius: 50%;
      border-top: 6px solid  #08c7c7;
      width: 52px;
      height: 53px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
    .showLoder {
      position: fixed;
      z-index: 9999999;
      right: 50%;
      top: 35%;
    /*display: none;*/
    }
    div#loaderDisplay {
      position: fixed;
      width: 100%;
      height: 100%;
      background: #c8cccb54;
      z-index: 9999999999;
      /*display: none;*/
    }
    
     table tr td, th {white-space: nowrap !important;}
     .box-body{width:100%;overflow-x:auto;}
</style>
<script>
  $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "bProcessing": true,
      "dom": 'Bfrtip',
      "buttons": [
          'pageLength',
          {
              extend: 'print',
              autoPrint: false,
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'pdf',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'excel',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'csv',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'copy',
              exportOptions: {
                  columns: ':visible'
              }
          },
          'colvis'
      ],
    })


     $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "bProcessing": true,
      "dom": 'Bfrtip',
      "buttons": [
          'pageLength',
          {
              extend: 'print',
              autoPrint: false,
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'pdf',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'excel',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'csv',
              title: 'Data List',
              exportOptions: {
                  columns: ':visible'
              }
          },{
              extend: 'copy',
              exportOptions: {
                  columns: ':visible'
              }
          },
          'colvis'
      ],
    })


  })

    
</script>

  <script type="text/javascript">
     document.onreadystatechange=function(){
      var state=document.readyState;if(state=='interactive'){
      }else if(state=='complete'){
          setTimeout(function(){document.getElementById('interactive');
            document.getElementById('loaderDisplay').style.visibility='hidden';
           document.getElementById('showLoder').style.visibility='hidden' 
         },1000)}
    }
  </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="showLoder" id="showLoder" >
  <div class="loader"></div></div>
<div class="wrapper">
<div   id="loaderDisplay"></div>
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('admin-dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>A</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Codruk </b>App</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
        
          <?php $adminData = $this->session->userdata('adminData');
          $admin = $this->db->get_where('admin_master',array('id'=>$adminData['id']))->row_array();
           ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if ($adminData['type'] == 1) {?>
              
              <?php if($adminData['image'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/'); ?><?php echo $adminData['image']; ?>" class="user-image" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            <?php } ?>

          <?php }else{?>

            <?php  $staff = $this->db->get_where('staff_master',array('id'=>$adminData['id']))->row_array();?>

            <?php if($staff['profile_pic'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/staff/'); ?><?php echo $staff['profile_pic']; ?>" class="user-image" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            <?php } ?>

          <?php }?>  

              <span class="hidden-xs"><?php echo ucfirst($admin['name']); ?></span>
         
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

            <?php if ($adminData['type'] == 1) {?>

             <?php if($adminData['image'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/'); ?><?php echo $adminData['image']; ?>" class="img-circle" style="width: 150px;height:120px;" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" style="width: 150px;height:120px;" class="img-circle" alt="User Image">
            <?php } ?>

             <?php }else{?>

               <?php  $staff = $this->db->get_where('staff_master',array('id'=>$adminData['id']))->row_array();?>

            <?php if($staff['profile_pic'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/staff/'); ?><?php echo $staff['profile_pic']; ?>" class="img-circle" style="width: 150px;height:120px;" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" style="width: 150px;height:120px;" class="img-circle" alt="User Image">
            <?php } ?>

              <?php }?>  
                
                <p>
                  <?php echo ucfirst($admin['name']); ?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if($adminData['type'] == 1){ ?>
                  <a href="<?php echo base_url('Admin/adminProfile'); ?>" class="btn btn-default btn-flat">Profile</a>
                <?php }else{?>
                 <a href="<?php echo base_url('Admin/staff_profile'); ?>" class="btn btn-default btn-flat">Profile</a> 
                 <?php }?> 
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('logout-account'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>