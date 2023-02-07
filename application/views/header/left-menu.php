<?php $page = $this->uri->segment(2,0);
$page_crtl = $this->uri->segment(1,0);
$tr = ''; @$tr = $_GET['tr'];
$first = ''; @$first = $_GET['first'];
//$pageIndex = '';

$adminData = $this->session->userdata['adminData'];
?>


    
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->

      <?php if ($adminData['type'] == 1) { ?>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php echo ($pageIndex == 'dashboard' ? 'active' : '');  ?>">
          <a href="<?php echo base_url('admin-dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>


        
        <li class="treeview <?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'customer' || $page == 'customer_cancel_rides'  || $page == 'customer_pending_rides' ||  ($page == 'pending_ride_details' && $first == 1 && $tr == 1) || ($page == 'cancel_ride_details' && $first == 1 && $tr == 1)  ||  ($page == 'pending_ride_details' && $first == 2 && $tr == 1) || ($page == 'cancel_ride_details' && $first == 2 && $tr == 1)|| ($page == 'completed_ride_details' && $first == 2 && $tr == 1) || ($page == 'running_ride_details' && $first == 2 && $tr == 1) )? 'active' : ''); ?>">
          <a href="#"><i class="fa fa-users"></i> <span>Manage Customers</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($pageIndex1 == 'customerWithoutLogin' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Customers/customerList'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Customers</span>
              </a>
            </li> 

            <li class="<?php echo ($pageIndex1 == 'businessList' || ($page == 'customer_cancel_rides' && $first == 1) || ($page == 'cancel_ride_details' && $first == 1 && $tr == 1) || ($page == 'customer_pending_rides' && $first == 1) || ($page == 'pending_ride_details' && $first == 1 && $tr == 1) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Customers/manageBusiness'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Business Profiles</span>
              </a>
            </li>

            <li class="<?php echo ($pageIndex1 == 'individualList' || ($page == 'customer_cancel_rides' && $first == 2) || ($page == 'customer_pending_rides' && $first == 2) || ($page == 'pending_ride_details' && $first == 2 && $tr == 1) || ($page == 'cancel_ride_details' && $first == 2 && $tr == 1) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Customers/manageIndividual'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Individual Profiles</span>
              </a>
            </li>
          </ul>       
        </li>


              <!--     <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'pilot_list')? 'active' : ''); ?>"> -->
        <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'pilot_list' || $page == 'pilot_cancel_rides'  || $page == 'pilot_pending_rides' || $page == 'pilot_completed_rides' || $page == 'pilot_running_rides' ||  ($page == 'pending_ride_details' && $first == 1 && $tr == 2) || ($page == 'cancel_ride_details' && $first == 1 && $tr == 2)  ||  ($page == 'pending_ride_details' && $first == 2 && $tr == 2) || ($page == 'cancel_ride_details' && $first == 2 && $tr == 2) || ($page == 'completed_ride_details' && $first == 2 && $tr == 2) || ($page == 'running_ride_details' && $first == 2 && $tr == 2) )? 'active' : ''); ?>">
            <a href="<?php echo base_url('Customers/pilot_list'); ?>">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span>Manage Pilots</span>
            </a>
        </li> 

            <!--            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'owner')? 'active' : ''); ?>"> -->
            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'owner' || $page == 'owner_cancel_rides'  || $page == 'owner_pending_rides' || $page == 'owner_completed_rides' || $page == 'owner_running_rides' ||  ($page == 'pending_ride_details' && $first == 1 && $tr == 3) || ($page == 'cancel_ride_details' && $first == 1 && $tr == 3)  ||  ($page == 'pending_ride_details' && $first == 2 && $tr == 3) || ($page == 'cancel_ride_details' && $first == 2 && $tr == 3) || ($page == 'completed_ride_details' && $first == 2 && $tr == 3) || ($page == 'running_ride_details' && $first == 2 && $tr == 3) )? 'active' : ''); ?>">
            <a href="<?php echo base_url('Customers/ownerlist'); ?>">
              <i class="fa fa-users" aria-hidden="true"></i>
              <span>Manage Owners</span>
            </a>
          </li> 

          
             <li class="<?php echo ($pageIndex == 'ownervehicle' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('Admin/manageownervehicle'); ?>">
              <i class="fa fa-car" aria-hidden="true"></i>
              <span>Manage Owner Vehicles</span>
            </a>
          </li> 

           <li class="<?php echo ($pageIndex == 'driver_request' ? 'active' : ''); ?>">
          <a href="<?php echo base_url('Admin/manage_request'); ?>">
            <i class="fa fa-inbox" aria-hidden="true"></i>
            <span>Manage Vehicle Request</span>
          </a>
        </li> 
        

        <li class="treeview <?php echo ($page_crtl != 'admin-dashboard' && ($page == 'pending_rides' || ($tr == '' && $page == 'pending_ride_details') || ( $tr == '' && $page == 'cancel_ride_details') || ( $tr == '' && $page == 'running_ride_details') || ( $tr == '' && $page == 'completed_ride_details') || $page == 'running_rides' || $page == 'show_map' || $page == 'cancel_rides' || $page == 'completed_rides' ) ? 'active' : '');  ?>">
          <a href="#"><i class="fa fa-road"></i> <span>Manage Rides</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'pending_rides' || ($tr == '' && $page == 'pending_ride_details')) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Rides/pending_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Pending Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'completed_rides' || ($tr == '' && $page == 'completed_ride_details')) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Rides/completed_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Completed Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'running_rides' || ($tr == '' && $page == 'running_ride_details') || $page == 'show_map') ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Rides/running_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Running Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'cancel_rides' || ( $tr == '' && $page == 'cancel_ride_details')) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Rides/cancel_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Cancelled Rides</span>
              </a>
            </li>

             <li class="">
              <a href="#">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Schedule Rides</span>
              </a>
            </li> 

            
          </ul>       
        </li>


       


        <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'template')? 'active' : ''); ?>">
          <a href="<?php echo base_url('Welcome/viewNotificationSetting'); ?>">
            <i class="fa fa-bell" aria-hidden="true"></i>
            <span>Manage Message Template</span>
          </a>
        </li> 


     <!--    <li class="treeview <?php echo ($pageIndex == 'template' ? 'active' : '');  ?>">
          <a href="#"><i class="fa fa-envelope-open-o"></i> <span>Manage Message Template</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($pageIndex1 == 'smsEmail' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Welcome/viewNotificationSetting'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Notification</span>
              </a>
            </li>

          </ul>       
        </li> -->

          <li class="<?php echo ($pageIndex == 'vehicle' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('Admin/manageVehicle'); ?>">
              <i class="fa fa-car" aria-hidden="true"></i>
              <span>Manage Vehicles</span>
            </a>
          </li> 

          <li class="<?php echo ($pageIndex == 'loader' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('Admin/manageLoader'); ?>">
              <i class="fa fa-spinner" aria-hidden="true"></i>
              <span>Manage Loaders</span>
            </a>
          </li> 

          <li class="<?php echo ($pageIndex == 'insurance' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('Admin/manageInsurance'); ?>">
              <i class="fa fa-circle-o" aria-hidden="true"></i>
              <span>Manage Items</span>
            </a>
          </li> 

     <!--    <li class="treeview <?php echo ($pageIndex == '4' ? 'active' : '');  ?>">
          <a href="#"><i class="fa fa-car"></i> <span>Manage Registered Vehicles</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($pageIndex1 == '5' ? 'active' : ''); ?>">
              <a href="#">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Active Vehicles</span>
              </a>
            </li> 

    
            <li class="<?php echo ($pageIndex1 == '6' ? 'active' : ''); ?>">
              <a href="#">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Inactivated Vehicles</span>
              </a>
            </li> 
          </ul>       
        </li> -->

        <li class="treeview <?php echo ($pageIndex == 'setting' ? 'active' : '');  ?>">
          <a href="#"><i class="fa fa-cog"></i> <span>General Settings</span>
            <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo ($pageIndex1 == 'general' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Admin/updateSetting'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Settings</span>
              </a>
            </li>

            <li class="<?php echo ($pageIndex1 == 'unit' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Admin/manageUnits'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Units</span>
              </a>
            </li>

            <li class="<?php echo ($pageIndex1 == 'reason' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Admin/manageCancelReason'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Cancel Reasons</span>
              </a>
            </li>

             <li class="<?php echo ($pageIndex1 == 'comment' ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Admin/managecomment'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Manage Comments</span>
              </a>
            </li>
            
          </ul>       
        </li>

          

          <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex1 == 'shipment')? 'active' : ''); ?>">
            <a href="<?php echo base_url('Shipment/index');?>">
              <i class="fa fa-truck" aria-hidden="true"></i>
              <span>Manage Shipment</span>
            </a>
          </li>  
          
           <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex == 'staff')? 'active' : ''); ?>">
          <a href="<?php echo base_url('Customers/staff_list'); ?>">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Manage Staff</span>
          </a>
        </li> 



        </ul>

       <?php }else{?>

         <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li class="<?php echo ($pageIndex == 'dashboard' ? 'active' : '');  ?>">
            <a href="<?php echo base_url('admin-dashboard'); ?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

           <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($pageIndex1 == 'shipment')? 'active' : ''); ?>">
            <a href="<?php echo base_url('Shipment/index');?>">
              <i class="fa fa-truck" aria-hidden="true"></i>
              <span>Manage Shipment</span>
            </a>
          </li>  
          
         </ul> 
       
       <?php }?>        
        <!-- </li>
      </ul>  -->

    </section>
    <!-- /.sidebar -->
  </aside>