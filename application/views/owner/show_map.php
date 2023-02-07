<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Location on Map
      </h1>
      <span>Driver: <?php echo ucfirst($driver_data['name']);?></span>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Running Rides</a></li>
        <li class="active">Driver Location on Map</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           
           <div id="my_map_add" style="width:100%;height:500px;"></div>
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

<script type="text/javascript">
function my_map_add() {

var lat = '<?php echo $driver_data['location_latitude']?>';
var long = '<?php echo $driver_data['location_longitude']?>';

//var icon = new google.maps.MarkerImage('<?php echo base_url('mediaFile/truck.png')?>');
var myMapCenter = new google.maps.LatLng(lat,long);
var myMapProp = {center:myMapCenter, zoom:20, scrollwheel:true, draggable:true, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("my_map_add"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
//var marker = new google.maps.Marker({icon: icon,position:myMapCenter});
marker.setMap(map);
}
</script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdlb2k17PxjKjOcvWMhrY1GobweAGp4Xs&libraries=places&callback=my_map_add"
        async defer></script>  

