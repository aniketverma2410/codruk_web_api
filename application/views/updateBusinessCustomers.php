<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Business Customer
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Business Customer</a></li>
        <li class="active">Update</li>
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

/****** CODE ******/
</style>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Customers/updateBusinessCustomerPost'); ?>" enctype="multipart/form-data" method="post" > 
                  <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                        <input type="text" class="form-control" name="name"  value="<?php echo $result['name']; ?>" required>
                  </div>

                  <div class="col-sm-6">
                      <label>Email:</label>
                      <input type="text" class="form-control" value="<?php echo $result['email']; ?>" readonly>
                  </div>
                </div> <br> 


                <div class="row">
                  <div class="col-sm-6">
                      <label>Mobile:</label>
                          <input type="text" class="form-control" value="<?php echo $result['mobile']; ?>" readonly>
                  </div>

                  <div class="col-sm-6">
                      <label>Company Name:</label>
                      <input type="text" class="form-control" name="companyName"  value="<?php echo $result['companyName']; ?>" required>
                  </div>
                </div> <br> 


                  <div class="row">
                  <div class="col-sm-6">
                      <label>Company Reg Number:</label>
                          <input type="text" class="form-control" name="companyRegNumber"  value="<?php echo $result['companyRegNumber']; ?>" required>
                  </div>

                  <div class="col-sm-6">
                      <label>Company VAT Number:</label>
                       <input type="text" class="form-control" name="companyVatNumber"  value="<?php echo $result['companyVatNumber']; ?>" required>
                  </div>
                </div> <br> 

                <div class="row">

                   <div class="col-sm-6">
                      <label>Company VAT Copy:</label>
                      <input type="file" name="vatCopy" class="form-control">
                        <?php if(!empty($result['vatCopy'])) { ?>
                           <img src="<?php echo base_url('mediaFile/customers/document/'); ?><?php echo $result['vatCopy']; ?>" width="180" height="205">
                        <?php  } else { ?>
                           <embed src="<?php echo base_url(); ?>mediaFile/attachment.png" width="180" height="205"></embed>
                        <?php } ?>
                  </div>
                  
                  <div class="col-sm-6">
                      <label>Company Reg Copy:</label>
                      <input type="file" name="regCopy" class="form-control">
                      <?php if(!empty($result['regCopy'])) { ?>
                         <img src="<?php echo base_url('mediaFile/customers/document/'); ?><?php echo $result['regCopy']; ?>" width="180" height="205">
                      <?php  } else { ?>
                        <embed src="<?php echo base_url(); ?>mediaFile/attachment.png" width="180" height="205"></embed>
                      <?php } ?>
                  </div>

                 
                </div> <br> 


                <div class="row">
                  <div class="col-sm-6">
                      <label>Activated/Deactivated:</label>
                       <select class="form-control" name="status">
                        <option value="1" <?php echo ($result['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($result['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 
                  </div>

                </div> <br> 

                <div class="row">
                  <div class="col-sm-12 tex-right">
                      <button type="submit" class="btn btn-success">Update</button>
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
  $(document).ready(function(){
    $('#datepicker').datepicker({
      autoclose: true
    });
    });
</script>
  <!-- /.content-wrapper-->