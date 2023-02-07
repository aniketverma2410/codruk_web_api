<style type="text/css">
  .box-body{overflow-x: hidden;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Comment
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Comments</a></li>
        <li class="active">Update Comment</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Admin/updatecomment/'.$id); ?>" enctype="multipart/form-data" method="post" > 

            <input type="hidden" name="id" value="<?php echo $id; ?>">

                  
                <div class="row">
                  <div class="col-sm-12">

                      <label>Comment:</label>
                      <textarea name="comment" class="form-control"><?php echo $comment_data['comment']?></textarea>

                  </div>
                 
  
                </div> <br> 

                <div class="row">
                  <div class="col-sm-12">
                      <label>Activated/Deactivated:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($comment_data['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($comment_data['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 

                  </div>
                 
  
                </div> <br> 

         

                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" class="btn btn-info">Submit</button>
                       
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
 
  <!-- /.content-wrapper-->