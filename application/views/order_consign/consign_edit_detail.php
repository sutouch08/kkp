<?php $this->load->view('include/header'); ?>
<?php
$add = $this->pm->can_add;
$edit = $this->pm->can_edit;
$delete = $this->pm->can_delete;
$hide = $order->status == 1 ? 'hide' : '';
 ?>
 <div class="row">
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5">
     <h4 class="title"><?php echo $this->title; ?></h4>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5">
     <p class="pull-right top-p">
       <button type="button" class="btn btn-sm btn-warning" onClick="editOrder('<?php echo $order->code; ?>')"><i class="fa fa-arrow-left"></i> กลับ</button>
       <?php if($this->pm->can_add OR $this->pm->can_edit) : ?>
         <button type="button" class="btn btn-sm btn-success <?php echo $hide; ?>" id="btn-save-order" onclick="saveOrder()"><i class="fa fa-save"></i> บันทึก</button>
       <?php endif; ?>
     </p>
   </div>
 </div>
<hr class="margin-bottom-15" />
<?php $this->load->view('order_consign/consign_edit_header'); ?>

<!--  Search Product -->
<!--  Search Product -->
<div class="row">
	<div class="divider padding-5 visible-xs"></div>
	<div class="col-lg-2-harf col-md-2-harf col-sm-2-harf col-xs-8 padding-5 margin-bottom-10">
    <input type="text" class="form-control input-sm text-center" id="pd-box" placeholder="ค้นรหัสสินค้า" />
  </div>
  <div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-4 padding-5 margin-bottom-10">
  	<button type="button" class="btn btn-xs btn-primary btn-block" onclick="getProductGrid()">แสดงสินค้า</button>
  </div>

	<div class="divider padding-5 visible-xs"></div>

  <div class="col-lg-2-harf col-md-2-harf col-sm-2-harf col-xs-6 padding-5 margin-bottom-10">
    <input type="text" class="form-control input-sm text-center" id="item-code" placeholder="ค้นหารหัสสินค้า">
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 padding-5 margin-bottom-10">
    <input type="number" class="form-control input-sm text-center" id="stock-qty" disabled>
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2 padding-5 margin-bottom-10">
    <input type="number" class="form-control input-sm text-center" id="input-qty">
  </div>
  <div class="col-lg-1 col-md-1-harf col-sm-1 col-xs-2 padding-5 margin-bottom-10">
    <button type="button" class="btn btn-xs btn-primary btn-block" onclick="addItemToOrder()">เพิ่ม</button>
  </div>
</div>
<hr class="margin-top-15 margin-bottom-0 padding-5" />


<?php $this->load->view('orders/order_tab_menu'); ?>

<?php //$this->load->view('orders/order_detail');  ?>
<?php $this->load->view('order_consign/consign_detail');  ?>



<form id="orderForm">
  <div class="modal fade" id="orderGrid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="modal" style="min-width:250px; max-width:95vw;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="modalTitle" >title</h4>
        </div>
        <div class="modal-body text-center" >
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="max-height:60vh; padding:0; overflow:auto;" id="modalBody">

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          <button type="button" class="btn btn-primary" onClick="addToOrder()" >เพิ่มในรายการ</button>
        </div>
      </div>
    </div>
  </div>
</form>

<input type="hidden" id="auz" value="<?php echo getConfig('ALLOW_UNDER_ZERO'); ?>">
<?php if($this->menu_code == 'SOCCSO') : ?>
<script src="<?php echo base_url(); ?>scripts/order_consign/consign.js?v=<?php echo date('Ymd'); ?>"></script>
<?php else : ?>
<script src="<?php echo base_url(); ?>scripts/order_consign/consign_tr.js?v=<?php echo date('Ymd'); ?>"></script>
<?php endif; ?>
<script src="<?php echo base_url(); ?>scripts/order_consign/consign_add.js"></script>
<!-- <script src="<?php echo base_url(); ?>scripts/orders/order_add.js"></script> -->
<script src="<?php echo base_url(); ?>scripts/orders/product_tab_menu.js"></script>
<script src="<?php echo base_url(); ?>scripts/orders/order_grid.js"></script>

<?php $this->load->view('include/footer'); ?>
