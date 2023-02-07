<style type="text/css">
   span p{color:red}p#deleteFile{margin:0;color:#e0aeae}#myProgress{width:100%;background-color:#ddd}#myBar{width:1%;height:6px;background-color:#61bd65;margin-top:7px}#loaderShow{display:none}.loader{border:5px solid #f3f3f3;border-radius:50%;border-top:5px solid #3498db;width:25px;height:25px;top:5px;padding-left:5px;font-size:10px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0)}100%{-webkit-transform:rotate(360deg)}}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}span#videoSize{float:right}

   .box-body
   {
     overflow-x: hidden;
   }
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
        <div class="col-xs-6">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/updateVehiclePost'); ?>" enctype="multipart/form-data"  method="post" > 

                 <h4>Vehicle Information</h4>  
                <hr>  

              <input type="hidden" name="id" value="<?php echo $vehicleData['id']; ?>">
                <div class="row">
                  <div class="col-sm-12">
                      <label>Vehicle Type:</label>
                      <select name="type" class="form-control" required="">
                        <option value="1" <?php echo ($vehicleData['type'] == 1) ? 'selected' : '' ?>>Truck</option>
                        <option value="2" <?php echo ($vehicleData['type'] == 2) ? 'selected' : '' ?>>Dyna</option>
                        <option value="3" <?php echo ($vehicleData['type'] == 3) ? 'selected' : '' ?>>Dabbab</option>
                      </select>
                  </div>
                 </div>
                 <br> 

                  <div class="row">
                  <div class="col-sm-12">
                      <label>Vehicle Name:</label>
                       <input type="text" class="form-control" name="name" value="<?php echo $vehicleData['name']; ?>" required="">
                  </div>
                </div> <br> 


                <div class="row">
                  <div class="col-sm-12">
                    <label>Capacity:</label>
                    <div class="row">
                        <div class="col-sm-9" style="padding-right: 0px;">
                           <input type="number" class="form-control" name="capacity" value="<?php echo $vehicleData['capacity']; ?>" placeholder="Enter Capacity" required="">
                        </div>
                        <div class="col-sm-3" style="padding-left: 0px;">
                            <select class="form-control" name="unitId" required="">
                          <?php foreach ($capacity as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $vehicleData['unitId']) ? "selected" : ""; ?>><?php echo $value['name']; ?></option>
                           <?php } ?>
                          </select>
                        </div>  
                    </div>
                </div>
              </div>
              <br>

             <!--  <div class="row">
                  <div class="col-sm-12">
                      <label>Loading Time(Minutes):</label>
                    <div class="row">
                        <div class="col-sm-9" style="padding-right: 0px;">
                           <input type="number" class="form-control" value="<?php echo $vehicleData['loadingTime']; ?>" maxlength="10" name="loadingTime" placeholder="Enter Timing" required="">
                        </div>
                        <div class="col-sm-3" style="padding-left: 0px;">
                            <select class="form-control" name="durationId" required="">
                          <?php foreach ($duration as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $vehicleData['durationId']) ? "selected" : ""; ?>><?php echo $value['name']; ?></option>
                           <?php } ?>
                          </select>
                        </div>  
                    </div>
                       
                  </div>
                </div> <br>  -->

                <div class="row">
                  <div class="col-sm-12">
                      <label>Image:</label>
                      <input type="file" name="image" class="form-control" id="thumbnail" onchange="ImageChange(this)" class="form-control" accept="image/*" />
                      <div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;">
                        <img id="blah" src="<?php echo base_url('mediaFile/vehicles/'); ?><?php echo $vehicleData['image']; ?>" alt="your image" width="100%" height="100" />
                        <div id="myProgress"><div id="myBar" style="width: 100%;"></div></div>
                        <span id="message" style="color:green;">Success</span>
                        <span class="fa fa-check" style="float:right;margin-top: 5px;color: green"></span>
                  </div>
                </div> 
               </div>
                <br> 

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Status:</label>
                      <select name="status" class="form-control">
                        <option value="1"<?php if ($vehicleData['status'] == 1) {
                          echo "selected";
                        } ?>>Activated</option>
                         <option value="2"<?php if ($vehicleData['status'] == 2) {
                          echo "selected";
                        } ?>>Deactivated</option>
                      </select>
                  </div>
                </div> 
               
                <br> 

                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" class="btn btn-info">Submit</button>
                  </div>
                </div> <br> 

 
          
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>

         <div class="col-xs-6">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              
                <h4>Fare Information</h4>  
                <hr>

               

                <div class="row">
                   <div class="col-sm-12">
                      <label>Base Fare (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="initial_charges" placeholder="Enter Initial Charges" value="<?php echo $vehicleData['initial_charges']; ?>" required="">
                  </div>
                </div>
                <br> 

                 <div class="row">
                   <div class="col-sm-12">
                      <label>Rate Per Km (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="charges_per_km" placeholder="Enter Charges Per Km" value="<?php echo $vehicleData['charges_per_km']; ?>" required="">
                  </div>
                </div>
                <br> 

                <div class="row">
                   <div class="col-sm-12">
                      <label>Free Loading Time (Minutes):</label>
                       <input type="number" class="form-control" name="free_loading_time" placeholder="Enter Free Loading Time" value="<?php echo $vehicleData['free_loading_time']; ?>" required="">
                  </div>
                </div>
                <br> 

                 <div class="row">
                   <div class="col-sm-12">
                      <label>Waiting fee per min loading (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="waiting_charges_loading" placeholder="Enter charges" value="<?php echo $vehicleData['waiting_charges_loading']; ?>" required="">
                  </div>
                </div>
                <br> 

                  <div class="row">
                   <div class="col-sm-12">
                      <label>Free Unloading Time (Minutes):</label>
                       <input type="number" class="form-control" name="free_unloading_time" placeholder="Enter Free Unloading Time" value="<?php echo $vehicleData['free_unloading_time']; ?>" required="">
                  </div>
                </div>
                <br> 

                 <div class="row">
                   <div class="col-sm-12">
                      <label>Waiting fee per min unloading (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="waiting_charges_unloading" placeholder="Enter charges" value="<?php echo $vehicleData['waiting_charges_unloading']; ?>" required="">
                  </div>
                </div>
                <br> 


               

               

             

               

 
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
                         $('#displayImagesShow').html('<div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;"><img id="blah" src="'+e.target.result+'" alt="your image" width="100%" height="100" /><div id="myProgress"><div id="myBar"></div></div><p id="deleteFile"><span id="message" style="color:green;"></span><span class="fa fa-check" style="float:right;margin-top: 5px;color: green"></span></p></div>');
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
</script>
  <!-- /.content-wrapper-->