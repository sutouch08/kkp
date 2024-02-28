<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-3 padding-5">
    <h3 class="title hidden-xs">
      <?php echo $this->title; ?>
    </h3>
    </div>
		<div class="col-xs-12 padding-5 text-center visible-xs" style="background-color:#eee;">
			<h3 class="margin-top-0">
	      <?php echo $this->title; ?>
	    </h3>
		</div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 padding-5">
    	<p class="pull-right" style="margin-bottom:1px;">
				<button type="button" class="btn btn-xs btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
				<?php if(($this->pm->can_add OR $this->pm->can_edit) && $order->status == 1 && $order->is_paid == 0) : ?>
				<button type="button" class="btn btn-xs btn-info top-btn" onclick="payOrder()"><i class="fa fa-credit-card"></i> แจ้งชำระเงิน</button>
				<?php endif; ?>
				<?php if(($this->pm->can_add OR $this->pm->can_edit) && $order->status == 1) : ?>
				<button type="button" class="btn btn-xs btn-grey top-btn" onClick="inputDeliveryNo()"><i class="fa fa-truck"></i> บันทึกการจัดส่ง</button>
				<?php endif; ?>

				<button type="button" class="btn btn-xs btn-purple top-btn" onclick="getSummary()"><i class="fa fa-bolt"></i> สรุปข้อมูล</button>

				<button type="button" class="btn btn-xs btn-default top-btn" onclick="printOrderSheet()"><i class="fa fa-print"></i> พิมพ์</button>
				<!--
				<?php if($this->pm->can_delete && $order->never_expire == 0) : ?>
				<button type="button" class="btn btn-sm btn-primary" onclick="setNotExpire(1)">ยกเว้นการหมดอายุ</button>
				<?php endif; ?>
				<?php if($this->pm->can_delete && $order->never_expire == 1) : ?>
					<button type="button" class="btn btn-sm btn-info" onclick="setNotExpire(0)">ไม่ยกเว้นการหมดอายุ</button>
				<?php endif; ?>
			-->
				<?php if($this->pm->can_delete && $order->is_expired == 1) : ?>
								<button type="button" class="btn btn-xs btn-warning top-btn" onclick="unExpired()">ทำให้ไม่หมดอายุ</button>
				<?php endif; ?>
				<?php if($order->state < 4 && ($this->pm->can_add OR $this->pm->can_edit) && $order->is_paid == 0) : ?>
				<button type="button" class="btn btn-xs btn-yellow top-btn" onclick="editDetail()"><i class="fa fa-pencil"></i> แก้ไขรายการ</button>
				<?php endif; ?>
				<?php if($order->status == 0) : ?>
					<button type="button" class="btn btn-xs btn-success top-btn" onclick="saveOrder()"><i class="fa fa-save"></i> บันทึก</button>
				<?php endif; ?>
      </p>
    </div>
</div><!-- End Row -->
<hr class="padding-5"/>
<?php if($order->status == 2) : ?>
<?php $this->load->view('cancle_watermark', array('top_pos' => 400)); ?>
<?php endif; ?>
<input type="hidden" id="order_code" value="<?php echo $order->code; ?>" />
<?php $this->load->view('orders/order_edit_header'); ?>
<?php $this->load->view('orders/order_panel'); ?>
<?php //$this->load->view('orders/order_discount_bar'); ?>
<?php $this->load->view('orders/order_view_detail'); ?>
<?php $this->load->view('orders/order_online_modal'); ?>
<script src="<?php echo base_url(); ?>assets/js/clipboard.min.js"></script>
<script src="<?php echo base_url(); ?>scripts/orders/orders.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/orders/order_add.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/orders/order_online.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/print/print_order.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/print/print_address.js?v=<?php echo date('Ymd'); ?>"></script>


<?php $this->load->view('include/footer'); ?>
