<style type="text/css">
   span p{color:red}p#deleteFile{margin:0;color:#e0aeae}#myProgress{width:100%;background-color:#ddd}#myBar{width:1%;height:6px;background-color:#61bd65;margin-top:7px}#loaderShow{display:none}.loader{border:5px solid #f3f3f3;border-radius:50%;border-top:5px solid #3498db;width:25px;height:25px;top:5px;padding-left:5px;font-size:10px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0)}100%{-webkit-transform:rotate(360deg)}}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}span#videoSize{float:right}

   .box-body {
     overflow-x: hidden; 
}
</style>
<style type="text/css">
  .reg1{
    width: 50% !important;
    padding-left: 0px;
  }

    .reg2{
    width: 50% !important;
    padding-right: 0px;
  }
  .divP{padding-left: 0px; padding-right: 0px;}
  
  .pad_left{padding-left: 0px;}
  .pad_right{padding-right: 0px;}

  .set_div_img00{
            border: 2px solid #dedadad9;
            padding: 5px;
            margin-top: 15px;
    }
    .set_div_img00 img{    
        height: 150px;
        width: 100%;
    }

  /*  .input_w{width: 115px !important;}*/
    .set_img{
            margin: 0;
    width: 96%;
    text-align: center;
    position: absolute;
    top: 5px;
    background: rgba(0, 0, 0, 0.6);
    font-size: 16px;
    color: #fff !important;
    display: none;
    height: 150px;
    padding-top: 60px;
    }
    .set_div_img00:hover .set_img{display: block;}
    .set_img a{color: red !important;}
    .del_img{
        margin: 0;
        width: 44px;
        text-align: center;
        top: 6px;
        background: transparent;
        font-size: 16px;
        color: red !important;
        right: 6px;
        border: 1px solid #ddd;
        margin-top: 5px;
    }
    .showFile img{height: 75px;}
    .showFile img{height: 150px;}
    .show_img_data .showFile{width:228px;}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Vehicle 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Vehicles</a></li>
        <li class="active">Update Vehicle</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('owner/updateVehiclePost'); ?>" enctype="multipart/form-data"  method="post" > 

                <input type="hidden" name="id" value="<?php echo $vehicleData['id'] ?>">  
                <div class="row">
                   <div class="col-sm-6">
                      <label>Vehicle Number:</label>
                       <input type="text" class="form-control" name="vehicle_number" placeholder="Enter Vehicle Number" value="<?php echo $vehicleData['vehicle_number']?>" disabled="">
                  </div>

                  <div class="col-sm-6">
                      <label>Vehicle Type:</label>
                      <select name="vehicle_type" class="form-control" required="" onchange="get_vehicles(this.value);" disabled>
                        <option value="">Select</option>
                        <option value="1"<?php if ($vehicleData['vehicle_type'] == 1) {
                         echo "selected";
                        } ?>> Truck</option>
                        <option value="2"<?php if ($vehicleData['vehicle_type'] == 2) {
                         echo "selected";
                        } ?>> Dyna</option>
                        <option value="3"<?php if ($vehicleData['vehicle_type'] == 3) {
                         echo "selected";
                        } ?>> Dabbab</option>
                      </select>
                  </div>
                </div> 
                <br> 

                <div class="row">
                     <div class="col-sm-6">
                      <label>Vehicle:</label>
                      <select name="vehicle_master_id" class="form-control" id="vehicle" disabled="">
                        <option value="">-Select Vehicle-</option>
                      </select>
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-sm-6">
                      <label>Vehicle Registration Front Image:</label>
                      <input type="file" name="vehicle_reg_front" class="form-control" id="thumbnail" class="form-control" accept="image/*" disabled/>
                      <div id="displayImagesShow"></div>
                      <div class=" col-sm-12 pad_left"> 
                    <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_reg_front'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['vehicle_reg_front']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                    </div> 
                  </div>

                  <div class="col-sm-6">
                      <label>Vehicle Registration Back Image:</label>
                      <input type="file" name="vehicle_reg_back" class="form-control" id="thumbnail1" class="form-control" accept="image/*" disabled/>
                      <div id="displayImagesShow1"></div>
                      <div class=" col-sm-12 pad_left"> 
                    <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_reg_back'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['vehicle_reg_back']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                    </div> 
                  </div>
                </div> 
                <br> 

                <div class="row">
                  <div class="col-sm-6">
                      <label>Route Permit Front Image:</label>
                      <input type="file" name="route_permit_front" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                    <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['route_permit_front'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['route_permit_front']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                      <label>Route Permit Back Image:</label>
                      <input type="file" name="route_permit_back" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                    <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['route_permit_back'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['route_permit_back']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                    </div> 
                  </div>
                </div> 
                <br> 

                 <div class="row">
                  <div class="col-sm-6">
                      <label>Containment Front Image:</label>
                      <input type="file" name="containment_front" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['containment_front'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['containment_front']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <label>Containment Back Image:</label>
                      <input type="file" name="containment_back" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['containment_back'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['containment_back']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                      </div>
                  </div>
                </div> 
                <br> 

                 <div class="row">
                  <div class="col-sm-6">
                      <label>Vehicle Left Image:</label>
                      <input type="file" name="vehicle_left" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_left'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['vehicle_left']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                      </div>
                  </div>

                  <div class="col-sm-6">
                      <label>Vehicle Right  Image:</label>
                      <input type="file" name="vehicle_right" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_right'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['vehicle_right']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                      </div>
                  </div>

                

                </div> 
                <br> 

                <div class="row">
                    <div class="col-sm-6">
                      <label>Vehicle Front  Image:</label>
                      <input type="file" name="vehicle_front" class="form-control" class="form-control" accept="image/*" disabled/>
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_front'];
                      ?>

                     <?php if (!empty($vehicleData['vehicle_reg_front'])) {?>
                        <div class="set_div_img00 form-group col-xs-12 reg1" id="hide_div_1" style="float: right;display: <?php if($img_name != '') { echo "block"; } else { echo "none"; } ?>">
                            <img src="<?php echo $img_name; ?>" class="img-responsive" alt="img">
                            <p class="set_img">
                                <a href="<?php echo base_url(); ?>mediaFile/vehicles/<?= $vehicleData['vehicle_front']; ?>" download>
                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                </a>
                            </p>
                        </div>
                        <?php } ?>
                      </div>
                  </div>

                  <!-- <div class="col-sm-6">
                      <label>Activated/Deactivated:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($vehicleData['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($vehicleData['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 

                  </div> -->

                </div>
                <br>





               <!--  <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" class="btn btn-info">Submit</button>
                  </div>
                </div> <br>  -->

 
                </form>
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
  <script type="text/javascript">


$(document).ready(function(){
    
   var type = "<?php echo $vehicleData['vehicle_type']?>"; 
   get_vehicles_new(type); 
});

  function ImageChange(input){
    $('#loaderShow').css('display','block');
    if (input.files && input.files[0]) {
           // if value is images
            var  file = input.files[0].name;
            var  ext = file.split(".");  
            ext = ext[ext.length-1].toLowerCase();      
            var arrayExtensions = ["jpg" , "jpeg", "png", "bmp", "gif"];
            var exactSize = getFileSize(input.files[0].size);
            var lastextType = exactSize.substr(exactSize.length - 2);
            var res = exactSize.split(".");
            var kbcheck = '';
            if(jQuery.isEmptyObject(res[1]) != true){
                  kbcheck = res[1].split("&");
            }
              if(lastextType == 'KB'){
                var res = res[0];
              }else if(lastextType == 'MB'){
                var res = res[0]*1024;
                var res = +(res)+ + +(kbcheck[0]);
              }else {
                var res = (res[0]*1024)*1024;
              }
              if(res > 5120){
                   alert('!Oops file size to larger. can\'t be upload more than 5 MB');
                   deletefile();
                }
              if($.inArray(ext, arrayExtensions) == -1) {
                console.log(res);
              }else{ 
                var reader = new FileReader();
                var image = '';
                reader.onload = function (e) {
                   $('#blah').attr('src', e.target.result);
                         var exactSize = getFileSize(input.files[0].size);
                         $('#displayImagesShow').html('<div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;margin-top: 10px;"><img id="blah" src="'+e.target.result+'" alt="your image" width="100%" height="100" /><div id="myProgress"><div id="myBar"></div></div><p id="deleteFile"><span id="message" style="color:green;"></span><span class="fa fa-check" style="float:right;margin-top: 5px;color: green"></span></p></div>');
                        $('input[name="sessionFileSize"]').val(exactSize);
                        move();
                        $('#displayImagesShow').css('display','block');
                        $('#showFile').css('display','block');
                        $('#displayError3').css('display','none');
                        // console.log(e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
   }

    function move() {
        var elem = document.getElementById("myBar");   
        var width = 1;
        var id = setInterval(frame, 10);
        function frame() {
          if (width >= 100) {
            clearInterval(id);
            $('#message').text('Success');
          } else {
            width++; 
            elem.style.width = width + '%'; 
          }
        }
    }

  function getFileSize(videoSize){
    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
      i=0;
      while(videoSize > 900){
        videoSize /=1024;i++;
      }
    return exactSize = (Math.round(videoSize*100)/100)+'&nbsp;'+fSExt[i];
  }
   function deletefile(){
      $("#thumbnail_file").val(null);
      $("#thumbnail").val(null);
      $("#showFile").hide();
    }






  function get_vehicles(type)
  {
    
      $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/get_vehicles'); ?>",  
    data: 'type='+ type,

    success: function(mess)
    {
       $('#vehicle').html(mess);
    } 
   
  }); 
  }  


   function get_vehicles_new(type)
  { 
    var vehicle = "<?php echo $vehicleData['vehicle_master_id']?>";
      $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/get_vehicles_new'); ?>",  
    data: 'type='+ type+'&vehicle='+vehicle,

    success: function(mess)
    {
       $('#vehicle').html(mess);
    } 
   
  }); 
  }  
</script>
  <!-- /.content-wrapper-->