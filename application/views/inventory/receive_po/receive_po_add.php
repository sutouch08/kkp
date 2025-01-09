<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
    <h3 class="title">
      <?php echo $this->title; ?>
    </h3>
  </div>
	<div class="col-xs-12 visible-xs">
    <h3 class="title-xs">
      <?php echo $this->title; ?>
    </h3>
  </div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <p class="pull-right top-p">
			<button type="button" class="btn btn-sm btn-warning" onclick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
    </p>
  </div>
</div>
<hr />

<div class="row">
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('doc_num'); ?></label>
		<input type="text" class="form-control input-sm text-center" disabled />
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('date'); ?></label>
		<input type="text" class="form-control input-sm text-center" name="date_add" id="dateAdd" value="<?php echo date('d-m-Y'); ?>" readonly />
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('vender_code'); ?></label>
		<input type="text" class="form-control input-sm text-center" name="venderCode" id="venderCode" placeholder="ค้นหารหัสผู้ขาย"/>
	</div>
	<div class="col-lg-4-harf col-md-4-harf col-sm-6 col-xs-12">
		<label><?php label('vender_name'); ?></label>
		<input type="text" class="form-control input-sm" name="venderName" id="venderName" placeholder="ค้นหาชื่อผู้ขาย"/>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('po'); ?></label>
		<input type="text" class="form-control input-sm text-center" name="poCode" id="poCode" placeholder="ค้นหาใบสั่งซื้อ" />
		<span class="help-block red" id="po-error"></span>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('inv'); ?></label>
		<input type="text" class="form-control input-sm text-center" name="invoice" id="invoice" placeholder="อ้างอิงใบส่งสินค้า" />
		<span class="help-block red" id="invoice-error"></span>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-4">
		<label><?php label('zone_code'); ?></label>
		<input type="text" class="form-control input-sm text-center zone" name="zoneCode" id="zoneCode" placeholder="ค้นหารหัสโซน"  />
		<span class="help-block red" id="zone-error"></span>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<label><?php label('zone_name'); ?></label>
		<input type="text" class="form-control input-sm text-center zone" name="zoneName" id="zoneName" placeholder="ค้นหาชื่อโซน"  />
		<span class="help-block red" id="zone-error"></span>
	</div>
	<div class="col-lg-6-harf col-md-6 col-sm-10-harf col-xs-9">
		<label><?php label('remark'); ?></label>
		<input type="text" class="form-control input-sm" name="remark" id="remark" placeholder="ระบุหมายเตุ(ถ้ามี)" />
	</div>
	<div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-3">
		<label class="display-block not-show"><?php label('save'); ?></label>
		<?php 	if($this->pm->can_add) : ?>
			<button type="button" class="btn btn-xs btn-success btn-block" onclick="addNew()"><i class="fa fa-plus"></i> <?php label('add_new'); ?></button>
		<?php	endif; ?>
	</div>
</div>

<hr class="margin-top-15"/>

<script src="<?php echo base_url(); ?>scripts/inventory/receive_po/receive_po.js"></script>
<script src="<?php echo base_url(); ?>scripts/inventory/receive_po/receive_po_add.js"></script>
<?php $this->load->view('include/footer'); ?>
