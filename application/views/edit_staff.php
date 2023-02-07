<style type="text/css">
  .box-body {
     overflow-x: hidden; 
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Staff 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Staff</a></li>
        <li class="active">Edit Staff</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Customers/edit_staff'); ?>" enctype="multipart/form-data"  method="post" > 

                <input type="hidden" name="id" value="<?php echo $result['id']?>">  

                <div class="row">

                   <div class="col-sm-12">
                      <label>Code:</label>
                       <input type="text" class="form-control" value="<?php echo $result['uuid']?>" readonly="">
                        <br> 
                  </div>


                  <div class="col-sm-12">
                      <label>Name:</label>
                       <input type="text" class="form-control" name="name" value="<?php echo $result['name']?>" required="">
                        <br> 
                  </div>

                  <div class="col-sm-12">
                      <label>Email:</label>
                       <input type="email" class="form-control" name="email"  id="email" value="<?php echo $result['email']?>" required="">
                        <input type="hidden" id="old_email" value="<?php echo $result['email'];?>" >
                       <span id="email_err" style="color:red;"></span>
                        <br> 
                  </div>
          
                  <div class="col-sm-12">
                      <label>Mobile:</label>
                       <input type="text" class="form-control" name="mobile" required="" value="<?php echo $result['mobile']?>" id="mobile" maxlength="10">
                       <input type="hidden" id="old_mobile" value="<?php echo $result['mobile'];?>" >
                       <span id="mob_err" style="color:red;"></span>
                        <br> 
                  </div>

                  <div class="col-sm-12">
                      <label>Password:</label>
                       <input type="password" class="form-control" name="password"  value="<?php echo $result['password']?>" required="">
                        <br> 
                  </div>

                  <div class="col-sm-12">
                      <label>Status:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php if ($result['status'] == 1) {
                         echo "selected";
                        }?>>Activated</option>
                        <option value="2" <?php if ($result['status'] == 2) {
                         echo "selected";
                        }?>>Deactivated</option>
                      </select>
                  </div>


                </div>
                 <br> 

                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" id="submit" class="btn btn-info">Submit</button>
                       
                  </div>
                </div> <br> 

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
   window.onload=function(){
      $(".alert").fadeOut(5000);
  }

    $(function() {

$("#email").keyup(function() {

  var email  =  $("#email").val();
  var old_email =  $("#old_email").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('Customers/check_mail_new'); ?>",  
    data: 'email='+ email+'&old_email='+old_email,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#email_err").html('Email is already exist');
          //$("#mobile").val('');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var mob = $('#mob_err').html();
          if (mob == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#email_err").html('');         
      }
    } 
   
  }); 
});
});


$(function() {

$("#mobile").keyup(function() {

  var mobile  =  $("#mobile").val();
   var old_mobile =  $("#old_mobile").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('Customers/check_mobile_new'); ?>",  
    data: 'mobile='+ mobile+'&old_mobile='+old_mobile,

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
  <!-- /.content-wrapper-->