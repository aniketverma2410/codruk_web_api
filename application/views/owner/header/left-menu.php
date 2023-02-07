<?php $page = $this->uri->segment(2,0);
$page_crtl = $this->uri->segment(1,0);
$tr = ''; @$tr = $_GET['tr'];
$first = ''; @$first = $_GET['first'];

?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php echo ($pageIndex == 'dashboard' ? 'active' : '');  ?>">
          <a href="<?php echo base_url('owner/dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>


         <li class="<?php echo ($pageIndex == 'vehicle' ? 'active' : ''); ?>">
          <a href="<?php echo base_url('owner/manageVehicle'); ?>">
            <i class="fa fa-car" aria-hidden="true"></i>
            <span>Manage Vehicles</span>
          </a>
        </li> 

         <li class="<?php echo ($pageIndex == 'driver_request' ? 'active' : ''); ?>">
          <a href="<?php echo base_url('owner/manage_request'); ?>">
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
              <a href="<?php echo base_url('Owner/pending_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Pending Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'completed_rides' || ($tr == '' && $page == 'completed_ride_details')) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Owner/completed_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Completed Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'running_rides' || ($tr == '' && $page == 'running_ride_details') || $page == 'show_map') ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Owner/running_rides'); ?>">
                <i class="fa fa-circle-o" aria-hidden="true"></i>
                <span>Running Rides</span>
              </a>
            </li> 

            <li class="<?php echo ($page_crtl != 'admin-dashboard' && ($page == 'cancel_rides' || ( $tr == '' && $page == 'cancel_ride_details')) ? 'active' : ''); ?>">
              <a href="<?php echo base_url('Owner/cancel_rides'); ?>">
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
       

      </ul> 

    </section>
    <!-- /.sidebar -->
  </aside>