<?php $this->load->view('include/header'); ?>
<?php $use_vat = getConfig('USE_VAT'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
		<button type="button" class="btn btn-white btn-success top-btn" onclick="showCustomerModal()">ข้อมูลลูกค้า</button>
	</div>
</div><!-- End Row -->
<hr class="padding-5">
<div class="row">
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
		<label>เลขที่เอกสาร</label>
		<input type="text" class="form-control input-sm text-center" id="code" name="code" disabled />
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label>ชนิด VAT</label>
		<select class="form-control input-sm edit" id="vat_type" name="vat_type">
			<option value="I">Include</option>
			<option value="E">Exclude</option>
		</select>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label>วันที่</label>
		<input type="text" class="form-control input-sm text-center e" name="doc_date" id="doc_date" value="<?php echo date('d-m-Y'); ?>" readonly />
	</div>
	<div class="col-lg-2 col-md-1-harf col-sm-2 col-xs-6 padding-5">
		<label>รหัสลูกค้า</label>
		<input type="text" class="form-control input-sm text-center e" name="customer_code" id="customer_code" value="" />
	</div>
	<div class="col-lg-5-harf col-md-6 col-sm-5 col-xs-12 padding-5">
		<label>ลูกค้า</label>
		<input type="text" class="form-control input-sm e" name="customer_name" id="customer-name" value="" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>เลขที่ผู้เสียภาษี</label>
		<input type="text" class="form-control input-sm e" maxlength="13" id="tax-id" value="" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label class="display-block not-show">เลขที่ผู้เสียภาษี</label>
		<label style="padding-top:4px;">
			<input type="checkbox" class="ace" id="is-company" onchange="toggleBranch()" value="1" />
			<span class="lbl"> นิติบุคคล</span>
		</label>
	</div>
	<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>สาขา</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="10" id="branch-code" value="" />
	</div>
	<div class="col-lg-2 col-md-3 col-sm-3-harf col-xs-6 padding-5">
		<label>ชื่อสาขา</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="branch-name" value="" />
	</div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 padding-5">
		<label>ที่อยู่</label>
		<input type="text" class="form-control input-sm e" maxlength="254"id="address" value="" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>ตำบล</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="sub-district" value="" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>อำเภอ</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="district" value="" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>จังหวัด</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="province" value="" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>รหัสไปรษณีย์</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="12" id="postcode" value="" />
	</div>
	<div class="col-lg-3 col-md-2-harf col-sm-2-harf col-xs-6 padding-5">
		<label>เบอร์โทร</label>
		<input type="text" class="form-control input-sm e" maxlength="32" id="phone" value="" />
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label class="display-block not-show">btn</label>
		<button type="button" class="btn btn-xs btn-success btn-block" onclick="add()"><i class="fa fa-plus"></i> เพิ่ม</button>
	</div>

	<input type="hidden" name="customerCode" id="customerCode" value="" />
</div>
<hr class="padding-5 margin-top-15" />
<?php $this->load->view('order_invoice/customer_modal'); ?>

<script src="<?php echo base_url(); ?>scripts/order_invoice/order_invoice.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
