<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        update Driver 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Driver</a></li>
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
                <form class="form-horizontal" action="<?php echo base_url('Drivers/updateDriverPost'); ?>" enctype="multipart/form-data"  method="post" > 
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name"  value="<?php echo $result['name']; ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Email:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" value="<?php echo $result['email']; ?>" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Mobile:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" value="<?php echo $result['mobile']; ?>" readonly>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">City Name:</label>
                    <div class="col-sm-10"> 
                        <input type="text" name="city" class="form-control" value="<?php echo $result['city']; ?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Active/Deactive:</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($result['status'] == 1) ? 'selected' : '' ?>>Activate</option>
                        <option value="2" <?php echo ($result['status'] == 2) ? 'selected' : '' ?>>Dectivate</option>
                      </select> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Photo:</label>
                    <div class="col-sm-10">
                      <input type="file" name="image" class="form-control">
                      <?php if(!empty($result['image'])) { ?>
                      <img src="<?php echo base_url('mediaFile/drivers/'); ?><?php echo $result['image']; ?>" width="180" height="205">
                    <?php  } else { ?>
                     <img src="http://localhost/codruk/theme/dist/img/user2-160x160.jpg" width="180" height="205">
                    <?php } ?>
                    </div>
                  </div>

                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Update</button>
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

  <!-- /.content-wrapper-->