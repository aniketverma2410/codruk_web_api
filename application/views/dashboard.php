  <?php $adminData = $this->session->userdata('adminData'); ?>

<style type="text/css">
  .content{min-height: auto !important;}
  .pad{padding-left: 0px;padding-right: 0px; }
  .box{width: 82%;}
  .right {float: right;
    margin-right: 70px;}
    .padtop{padding-top: 0px;}
    .content-header>.breadcrumb{margin-top: -18px;}
    .width{width: 82%}
    #chartdiv 
    {
      width: 100%;
      height: 333px;
    }
</style>

<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
        <?php $email = $this->db->get_where('notification_setting_master',array('status'=>1,'type'=>1))->num_rows();
        $sms = $this->db->get_where('notification_setting_master',array('status'=>1,'type'=>2))->num_rows();
        $vehicles = $this->db->get_where('vehicle_master')->num_rows();
        $loaders = $this->db->get_where('loader_master')->num_rows();
        $Insurance = $this->db->get_where('insurance_master')->num_rows();
        $shipment = $this->db->get_where('post_shipment')->num_rows();

        $totalpilots   = $this->db->get_where('driver_master',array('status'=>1))->num_rows();
        $totalowner   = $this->db->get_where('owner_master',array('status'=>1))->num_rows();
        $totalrides   = $this->db->get_where('ride_master')->num_rows();
        $totalaccepted   = $this->db->get_where('ride_master',array('status'=>4))->num_rows();
        $totalcancel   = $this->db->get_where('ride_master',array('status'=>2))->num_rows();
        $totalcompleted   = $this->db->get_where('ride_master',array('status'=>3))->num_rows();

        ?>

       <?php if($adminData['type'] == 1) {?> 

         <div class="col-lg-3 col-xs-6">
 
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalCustomer; ?><sup style="font-size: 20px"></sup></h3>

              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Customers/customerList'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalpilots; ?></h3>
              <p>Total Pilots</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Customers/pilot_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalowner; ?></h3>
              <p>Total Owners</p>
            </div>
            <div class="icon">
              <i class="fa fa-users" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Customers/ownerlist'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $vehicles; ?></h3>
              <p>Total Vehicles
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Admin/manageownervehicle'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $totalrides; ?></h3>
              <p>Total Rides
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalaccepted; ?></h3>
              <p>Total Accepted Rides
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Rides/running_rides'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $totalcancel; ?></h3>
              <p>Total Cancelled Rides
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Rides/cancel_rides'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalcompleted; ?></h3>
              <p>Total Completed Rides
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Rides/completed_rides'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
       <!--  <div class="col-lg-3 col-xs-6">
      
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $sms; ?></h3>
              <p>Total SMS</p>
            </div>
            <div class="icon">
              <i class="fa fa-envelope" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Welcome/viewNotificationSetting'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo $email; ?></h3>
              <p>Total Email
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-envelope" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Welcome/viewNotificationSetting'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $vehicles; ?></h3>
              <p>Total Vehicles
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-car" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Admin/manageVehicle'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?php echo $loaders ?></h3>
              <p>Total Loaders
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-spinner" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Admin/manageLoader'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
    
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $Insurance; ?></h3>
              <p>Total Items
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-circle-o" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Admin/manageInsurance'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->

        

       <?php }?> 

          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary ">
            <div class="inner">
              <h3><?php echo $shipment; ?></h3>
              <p>Total Shipments
            </p>
            </div>
            <div class="icon">
              <i class="fa fa-truck" aria-hidden="true"></i> 
            </div>
            <a href="<?php echo base_url('Shipment/index'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


         <div class="col-xs-12">
          <div class="col-xs-6" style="margin-top: -25px;">
              <div class="col-xs-12 " style="width: 100%; padding: 15px 0;">
                <div class="col-xs-12" style="margin-top: -25px; padding: 0;">
                    <div class="box box-primary col-xs-12" style="width: 100%;margin-top: 40px;">
                        <div class="box-header with-border">
                          <i class="ion ion-clipboard"></i>
                           <h3 class="box-title">Rides Report</h3>  
                        </div>
                        <div class="box-body">
                         <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="" href="#" style="font-size:15px;color:#f390bd;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Created (<?php echo $created ?>).</span></li> 
                                  </ul>
                                  <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-blue" href="#" style="font-size:15px;"><i class="fa fa-square"></i></a>&nbsp;<span style="font-size:15px;">Completed (<?php echo $completed ?>).</span></li> 
                                  </ul>
                         </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>


          <div class="col-xs-6" style="margin-top: -25px;">
              <div class="col-xs-12 " style="width: 100%; padding: 15px 0;">
                <div class="col-xs-12" style="margin-top: -25px; padding: 0;">
                    <div class="box box-primary col-xs-12" style="width: 100%;margin-top: 40px;">
                        <div class="box-header with-border">
                          <i class="ion ion-clipboard"></i>
                           <h3 class="box-title">Revenue Report</h3>  
                        </div>
                        <div class="box-body">
                         <div class="chart">
                          <div id="container" style="height:250px"></div>
                        </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>



      </div>



<canvas id="areaChart" style="height:250px;display:none;"></canvas>
        <!-- ./col -->

      </div>
      <!-- /.row -->
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php 
   $month_json = "";
   $first1_json = "";
   $second1_json = "";
   $Amount = "";
   foreach($request_month_details as $rows1)
   {    
      $a1 = trim("01-".$rows1['month']);
      $b1 = date('M y',strtotime($a1));
      $month_json .= '"'.$b1.'",';
      $first1_json .= ''.$rows1["first1"].',';
      $second1_json .= ''.$rows1["second1"].',';
   }


   foreach($Line_details as $rows2)
   {    
      $Amount .= ''.$rows2["Amount"].',';
   }

    ?>
  <script type="text/javascript">
   $(function () {
      var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas);
    var areaChartData = {
      labels: [<?php echo $month_json;?>],
    
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo $first1_json;?>]
        },
        {
          label: "Digital Goods",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php echo $second1_json;?>]
        }
      ]
    };

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#0073b7";
    barChartData.datasets[1].strokeColor = "#0073b7";
    barChartData.datasets[1].pointColor = "#0073b7";
    barChartData.datasets[0].fillColor = "#f390bd";
    barChartData.datasets[0].strokeColor = "#f390bd";
    barChartData.datasets[0].pointColor = "#f390bd";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });
</script>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script>
$(function () {
 
Highcharts.chart('container', {
  chart: {
    type: 'line'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [<?php echo $month_json;?>]
  },
  yAxis: {
    title: {
      text: 'Revenue in SAR'
    }
  },
  plotOptions: {
    line: {
      dataLabels: {
        enabled: true
      },
      enableMouseTracking: false
    }
  },
  series: [{
    name: 'Last Six Months Data',
    data: [<?php echo $Amount;?>]
  }]
});
 
});
</script>