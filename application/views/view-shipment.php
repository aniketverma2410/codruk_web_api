<?php $adminData = $this->session->userdata['adminData'];
?>
<style type="text/css">
   .box-body 
   {
     overflow-x: hidden; 
   }

 .nav.nav-tabs{widows: 240px; float: left; border-bottom: 0px solid #ddd; margin-top: 15px;}


  .set_w_admin {
        width: 200PX;
        border: 1px solid #ddd;
        padding: 15px 0 0;
        margin: 5px;
    }
    .loader_img{
        height: 30px;
        position: absolute;
        margin-top: -32px;
        right: 30px;
        display: none;
    }
    .trash{color: red; cursor: pointer;}
    .set_w_admin img{height: 134px; width: 100%; padding: 0 15px;}

    .set_success{
        padding: 5px;
        background: #f1f9f9;
        margin-top: 15px;
    }
    .success{float: right; color: green;}
    .progress.col-xs-12.divPadding{
        height: 5px; margin: 0px;
    }
    .set_uploaded_img{
        padding: 5px;
        margin-top: 15px;
        background: #eee;
        border-bottom: 5px solid #5bc0de;
    }
    .progress{padding: 0px;}
    .last{    margin-left: 15px;
    margin-top: 21px;}
    .pad_left{padding: 0;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Shipment Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Shipment Details</a></li>
        <li class="active">Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x: hidden;">
                <form class="form-horizontal" action="<?php echo base_url('Shipment/updateStatus'); ?>" enctype="multipart/form-data" method="post" >

                  <input type="hidden" value="<?php echo $result['ID'];?>" name="id">

                <div class="row">
                  <div class="col-sm-6">
                      <label>Shipper Name:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['customer_name'];?>">
                  </div>
                  <div class="col-sm-6">
                      <label>Shipper Address:</label>
                      <textarea  class="form-control" readonly><?php echo $result['source_address'];?></textarea>
                  </div>
                </div>
                <br>
                <div class="row">
                   <div class="col-sm-6">
                      <label>Shipper City:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['shipper_city'];?>">
                  </div>
                    <div class="col-sm-6">
                      <label>Consignee Name:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['receiver_name'];?>">
                  </div>
                </div>
                 <br>
                <div class="row">
                  <div class="col-sm-6">
                      <label>Consignee Address:</label>
                        <textarea  class="form-control" readonly><?php echo $result['destination_address'];?></textarea>
                  </div>
                   <div class="col-sm-6">
                      <label>Consignee City:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['destination_city'];?>">
                  </div>
                </div>
                 <br>
                <div class="row">
                   <div class="col-sm-6">
                      <label>Mobile Number:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['receiver_mobile_number'];?>">
                  </div>
                  <div class="col-sm-6">
                      <label>Collection Type:</label>
                     <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['shipment_type'];?>">
                  </div>
                </div>
                 <br>
                <div class="row">
                    <div class="col-sm-6">
                      <label>Amount:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['prepaid_amount'];?>">
                  </div>
                   <div class="col-sm-6">
                      <label>Borcode ID:</label>
                       <input type="text" class="form-control" name="name" required="" readonly value="<?php echo $result['borcode_id'];?>">
                  </div>
                </div>
                 <br>
                <div class="row">
                   <div class="col-sm-6">
                      <label>Barcode Image:</label>
                    <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          if (!empty($result['image'])) 
                          {
                            $img_name = base_url().'mediaFile/barcode/'.$result['image'];
                          }
                          else
                          {
                             $img_name = base_url().'mediaFile/vehicles/no.jpeg';
                          }
                          
                      ?>

                        <div class="col-sm-12" id="set_images_1" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_1">
                          <a href="<?php echo $img_name; ?>" download>
                          <img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_1">
                          </a>
                          <div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>
                    </div>
                  </div>

                  

                  <?php if ($adminData['type'] == 1) {?> 
                  <div class="col-sm-6">
                      <label>Status:</label>
                      <select class="form-control" name="status" >
                          <option value="delivered" <?php echo ($result['status'] == 'delivered' ? 'selected':'');?> >Delivered</option>
                          <option value="pickup_awaited" <?php echo ($result['status'] == 'pickup_awaited' ? 'selected':'');?> >Pickup Awaited</option>
                          <option value="Running" <?php echo ($result['status'] == 'Running' ? 'selected':'');?> >Running</option>
                          <option value="Cancel" <?php echo ($result['status'] == 'Cancel' ? 'selected':'');?> >Cancel</option>
                      </select>
                      
                  </div>
                <?php }else{?>

                  <div class="col-sm-6">
                      <label>Status:</label>
                      <select class="form-control" name="status"  disabled="">
                          <option value="delivered" <?php echo ($result['status'] == 'delivered' ? 'selected':'');?> >Delivered</option>
                          <option value="pickup_awaited" <?php echo ($result['status'] == 'pickup_awaited' ? 'selected':'');?> >Pickup Awaited</option>
                          <option value="Running" <?php echo ($result['status'] == 'Running' ? 'selected':'');?> >Running</option>
                          <option value="Cancel" <?php echo ($result['status'] == 'Cancel' ? 'selected':'');?> >Cancel</option>
                      </select>
                  </div>

                <?php }?>


                </div> 
                <br>
                <div class="row">
                  <?php if ($adminData['type'] == 1) {?> 
                  <div class="col-sm-12">
                       <button type="submit" class="btn btn-info">Submit</button>
                  </div>
                <?php }?>
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