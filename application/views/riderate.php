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
         Vehicle Fare for (<?php echo ucfirst($customer['name']) ?>) 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Business Customers</a></li>
        <li class="active">Vehicle Fare</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>

         <form class="form-horizontal" action="<?php echo base_url('Customers/riderate/'.$user_id.'?page='.$page); ?>" enctype="multipart/form-data"  method="post" > 

        <?php foreach ($vehicles as $key => $value) {?>

        <input type="hidden" name="vehicle_id[]" value="<? echo $value['id']?>">  
        <input type="hidden" name="page" value="<? echo $page?>">  

        <div class="col-xs-6">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
               
                <h4>Fare Information for Vehicle [<?php echo ucfirst($value['name']) ?>]</h4>  
                <hr>
                <?php 
                if (!empty($vehicleData)) 
                {
                  $initial_charges = $vehicleData[$key]['initial_charges']; 
                }
                else
                {
                  $initial_charges = "";
                }

               if (!empty($vehicleData)) 
                {
                  $charges_per_km = $vehicleData[$key]['charges_per_km'];
                }
                else
                {
                  $charges_per_km = "";
                }

                 if (!empty($vehicleData)) 
                {
                  $free_loading_time = $vehicleData[$key]['free_loading_time']; 
                }
                else
                {
                  $free_loading_time = "";
                }

                 if (!empty($vehicleData)) 
                {
                  $waiting_charges_loading = $vehicleData[$key]['waiting_charges_loading']; 
                }
                else
                {
                  $waiting_charges_loading = "";
                }

                 if (!empty($vehicleData)) 
                {
                  $free_unloading_time = $vehicleData[$key]['free_unloading_time']; 
                }
                else
                {
                  $free_unloading_time = "";
                }

                 if (!empty($vehicleData)) 
                {
                  $waiting_charges_unloading = $vehicleData[$key]['waiting_charges_unloading']; 
                }
                else
                {
                  $waiting_charges_unloading = "";
                }

                  if (!empty($vehicleData)) 
                {
                  $apply = $vehicleData[$key]['apply']; 
                }
                else
                {
                  $apply = "";
                }

                ?>

                <div class="row">
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Base Fare (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="initial_charges[]" placeholder="Enter Initial Charges" value="<?php echo $initial_charges; ?>">
                  </div>
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Rate Per Km (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="charges_per_km[]" placeholder="Enter Charges Per Km" value="<?php echo $charges_per_km ?>">
                  </div>
                </div>
                <br> 

                 

                <div class="row">
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Free Loading Time (Minutes):</label>
                       <input type="number" class="form-control" name="free_loading_time[]" placeholder="Enter Free Loading Time" value="<?php echo $free_loading_time; ?>">
                  </div>
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Waiting fee per min loading (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="waiting_charges_loading[]" placeholder="Enter charges" value="<?php echo $waiting_charges_loading; ?>">
                  </div>
                </div>
                <br> 


                <div class="row">
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Free Unloading Time (Minutes):</label>
                       <input type="number" class="form-control" name="free_unloading_time[]" placeholder="Enter Free Unloading Time" value="<?php echo $free_unloading_time; ?>">
                  </div>
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Waiting fee per min unloading (<?php echo $currency['currency']?>):</label>
                       <input type="number" class="form-control" name="waiting_charges_unloading[]" placeholder="Enter charges" value="<?php echo $waiting_charges_unloading; ?>">
                  </div>
                </div>
                <br> 

                 <div class="row">
                   <div class="col-sm-6">
                      <label style="font-size: 13px;">Applied Status:</label>
                      <select class="form-control" name="apply[]">
                        <option value="2" <?php if ($apply == 2) {
                          echo "selected";
                        } ?>>Don't apply</option>
                        <option value="1"<?php if ($apply == 1) {
                          echo "selected";
                        } ?>>Apply</option>
                      </select>
                  </div>
                </div>
                <br>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>


      <?php }?>

       <div class="row">
        <div class="col-sm-12" style="margin-left: 16px;">
             <button type="submit" class="btn btn-info">Submit</button>
        </div>
       </div> <br> 

     
     </form>
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