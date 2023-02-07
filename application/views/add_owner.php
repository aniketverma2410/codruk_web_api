
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Owner
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Owner</a></li>
        <li class="active">Add Owner</li>
      </ol>
    </section>
   <style type="text/css">span p{color: red;}
      #loaderShow{display: none;}
      p#deleteFile {
          margin: 0px;
          color: #e0aeae;
        }
        #myProgress {
        width: 100%;
        background-color: #ddd;
      }
      .box-body {
      overflow-x: hidden;
  }
      #myBar {
        width: 1%;
        height: 6px;
        background-color: #61bd65;
        margin-top: 7px;
      }
      .loader {
          border: 5px solid #f3f3f3;
          border-radius: 50%;
          border-top: 5px solid #3498db;
          width: 50px;
          height: 50px;
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

      .form-control{margin-bottom: 12px;}


/****** CODE ******/
</style>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-6">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Customers/add_owner'); ?>" enctype="multipart/form-data" method="post" > 


                <div class="row">
                  <div class="col-sm-12">
                      <label>Name:</label>
                        <input type="text" class="form-control" name="name"  required>
                  </div>
   
                  <div class="col-sm-12">
                      <label>Email:</label>
                      <input type="text" class="form-control" name="email" required>
                  </div>

                   <div class="col-sm-12">
                      <label>Mobile:</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10" required>
                        <span id="mob_err" style="color:red;"></span>
                        <span id="email_err" style="color:red;"></span>
                   </div>

                   <div class="col-sm-12">
                      <label>Password:</label>
                        <input type="password" class="form-control" name="password" required>
                  </div>
         
                </div> 
                  <div class="row"> 
                    <div class="col-md-12">
                      <button type="submit" id="submit" class="btn btn-success">Add</button>
                    </div>
                  </div>
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
$(function() {

$("#mobile").keyup(function() {

  var mobile  =  $("#mobile").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('Customers/check_mobile_number'); ?>",  
    data: 'mobile='+ mobile,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#mob_err").html('Mobile number is already exist');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var ema = $('#email_err').html();
          if (ema == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#mob_err").html('');
      }
    } 
   
  }); 
});
});
</script>