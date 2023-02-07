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
      background-color: #116d3c;
    }
    .skin-blue .main-header .logo {
      background-color: #116d3c;
      color: #000;
      border-bottom: 0 solid transparent;
    }
    .skin-blue .main-header .logo:hover {
      background-color: #09c6c6;
    }
    .skin-blue .main-header li.user-header {
      background-color: #116d3c;
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
      <span class="logo-mini"><b>T</b>A</span>
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
        
          <?php 
          $OwnerData = $this->session->userdata('OwnerData');
          $notification_count = $this->db->get_where('owner_notification',array('owner_id'=>$OwnerData['id'],'read_status'=>2))->num_rows();

                                $this->db->order_by('id','desc');
                                $this->db->limit(4);
          $notifications = $this->db->get_where('owner_notification',array('owner_id'=>$OwnerData['id'],'read_status'=>2))->result_array();
           ?>

             <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $notification_count;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo $notification_count;?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" style="overflow-x: auto;">
                  <?php foreach ($notifications as $key => $value) {  
                   $driver_data = $this->db->get_where('driver_master',array('id'=>$value['driver_id']))->row_array();
                   if (!empty($driver_data['image'])) 
                   {
                       $img = base_url('mediaFile/drivers/'.$driver_data['image']);
                   } 
                   else
                   {
                       $img = base_url('mediaFile/drivers/profile.jpg');
                   }
                   ?>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo $img;?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        <?php echo ucfirst($driver_data['name']) ?>
                        
                      </h4>
                      <p><?php echo $value['message']?></p>
                      <small><i class="fa fa-clock-o"></i> <?php echo date('dS M Y h:i A',$value['add_date']) ?></small>
                    </a>
                  </li>
                <?php }?>
                 
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php $owner_details = $this->db->get_where('owner_master',array('id'=>$OwnerData['id']))->row_array(); ?>   
              <?php if($owner_details['profile_pic'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/'); ?><?php echo $owner_details['profile_pic']; ?>" class="user-image" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            <?php } ?>
              <span class="hidden-xs"><?php echo ucfirst($OwnerData['name']); ?></span>
         
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

          

             <?php if($owner_details['profile_pic'] != ""){ ?>
              <img src="<?php echo base_url('mediaFile/'); ?><?php echo $owner_details['profile_pic']; ?>" class="img-circle" style="width: 150px;height:120px;" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" style="width: 150px;height:120px;" class="img-circle" alt="User Image">

            <?php } ?>
                
                <p>
                  <?php echo ucfirst($OwnerData['name']); ?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('owner/ownerprofile'); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('owner/logoutAccount'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
