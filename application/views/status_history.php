 <!-- bootstrap datepicker -->

<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Online/Offline Status History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilots</a></li>
        <li class="active">Online/Offline Status History</li> 
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
              <form class="form-inline" action="<?php echo base_url('Customers/status_history/'.$id);?>" method="post" style="    margin-top: 12px;margin-left: 11px;">
                  <div class="form-group col-xs-2" style="padding: 0">
                     <div class="input-group date" style="width: 100%;">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <select class="form-control pull-right" required="" name="Search">
                    <option value="" <?php if ($searchDate == '') {
                      echo "selected";
                    } ?>>-Select Year-</option>
                    <?php 
                    $curyear = date('Y');
                    for ($i=1; $i < 5; $i++) {?> 
                     
                     <option value="<?php echo $curyear;?>" <?php if ($searchDate == $curyear ) {
                      echo "selected";
                    } ?>><?php echo $curyear;?></option>
                     
                    <?php $curyear++; } ?>
                    
                
                  </select>
                </div>
                  </div>
                 
                  <div class="form-group col-xs-2" style="padding: 0 1px 0 2px;">
                     <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                           <select class="form-control pull-right" required="" name="Search1">
                            <option value="" <?php if ($searchDate1 == '') {
                              echo "selected";
                            } ?>>-Select Month-</option>
                           <option value="01" <?php if ($searchDate1 == '01') {
                              echo "selected";
                            } ?>>Jan</option>
                             <option value="02" <?php if ($searchDate1 == '02') {
                              echo "selected";
                            } ?>>Feb</option>
                             <option value="03" <?php if ($searchDate1 == '03') {
                              echo "selected";
                            } ?>>Mar</option>
                             <option value="04" <?php if ($searchDate1 == '04') {
                              echo "selected";
                            } ?>>Apr</option>
                             <option value="05" <?php if ($searchDate1 == '05') {
                              echo "selected";
                            } ?>>May</option>
                             <option value="06" <?php if ($searchDate1 == '06') {
                              echo "selected";
                            } ?>>June</option>
                             <option value="07" <?php if ($searchDate1 == '07') {
                              echo "selected";
                            } ?>>July</option>
                             <option value="08" <?php if ($searchDate1 == '08') {
                              echo "selected";
                            } ?>>Aug</option>
                             <option value="09" <?php if ($searchDate1 == '09') {
                              echo "selected";
                            } ?>>Sep</option>
                             <option value="10" <?php if ($searchDate1 == '10') {
                              echo "selected";
                            } ?>>Oct</option>
                             <option value="11" <?php if ($searchDate1 == '11') {
                              echo "selected";
                            } ?>>Nov</option>
                             <option value="12" <?php if ($searchDate1 == '12') {
                              echo "selected";
                            } ?>>Dec</option>
                          </select>
                    </div>
                  </div>

                   <!-- <div class="form-group">
                     <div class="input-group date">
                          <select class="form-control" name="status">
                            <option value="">All</option>
                            <option value="1"<?php if ($status == 1) {
                              echo "selected";
                            } ?>>Online</option>
                            <option value="2" <?php if ($status == 2) {
                              echo "selected";
                            } ?> >Offline</option>
                          </select>
                    </div>
                  </div> -->

                   

                  <button type="submit" class="btn btn-default">Search</button>
            </form>


              
            <div class="box-body">
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Online DateTime</th>
                  <th>Offline DateTime</th>
                  <th>Duration</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                    $count = 1;
                     foreach($result as $list):
                    ?>   
                     <?php

                      /***********************************New Time Duration Implementation********************/

                      if (!empty($list['offline_time'])) 
                      {
                          $logoutTime = $list['offline_time'];
                      }
                      else
                      {
                          $logoutTime = time();
                      }        

                      $tm = $logoutTime-$list['online_time'];
                      $time_data = secondsToTime($tm);
                      if ($time_data['d'] > 1) 
                      {
                          $D = 'days';
                      }
                      else
                      {
                          $D = 'day';
                      }

                      if ($time_data['h'] > 1) 
                      {
                          $H = 'hours';
                      }
                      else
                      {
                          $H = 'hour';
                      }

                      if ($time_data['m'] > 1) 
                      {
                          $M = 'minutes';
                      }
                      else
                      {
                          $M = 'minute';
                      }

                       if ($time_data['s'] > 1) 
                      {
                          $S = 'seconds';
                      }
                      else
                      {
                          $S = 'second';
                      }

                      if ($time_data['d'] > 0) 
                      {   
                          $t = $time_data['d'].' '.$D.' '.$time_data['h'].' '.$H.' '.$time_data['m'].' '.$M;
                      }
                      else
                      {
                          if ($time_data['h'] > 0) 
                          {   
                              $t = $time_data['h'].' '.$H.' '.$time_data['m'].' '.$M;
                          }
                          else
                          {
                              if ($time_data['m'] > 0) 
                              {   
                                  $t = $time_data['m'].' '.$M;
                              }
                              else
                              {
                                  $t = $time_data['m'].' '.$M;
                              }
                          }
                      }


            /*************************************End************************************************/
                         echo '<tr>
                             <td>'.$count.'</td>
                             <td>'.date('dS M Y h:i A',$list['online_time']).'</td>
                             <td>'.(!empty($list['offline_time'])?date('dS M Y h:i A',$list['offline_time']):"N/A").'</td>
                             <td>'.$t.'</td>
                              </tr>';
                              $count++;
                         endforeach;
                    ?>
                </tbody> 
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- bootstrap datepicker -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>    -->  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
  <script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script>
    //Date picker
   /* $('#datepicker').datepicker({
       autoclose: true,
       format: 'dd-mm-yyyy'
    });*/
</script>
<script type="text/javascript">
  $(function () {
      $('#datepicker').datetimepicker({
       format: 'DD-MM-YYYY h:m A'
     });
  });

   $(function () {
      $('#datepicker1').datetimepicker({
       format: 'DD-MM-YYYY h:m A'
     });
  });
</script>
