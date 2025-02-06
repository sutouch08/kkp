<?php $this->load->view('include/header'); ?>
<style>
	.form-group {
		margin-bottom: 5px;
	}

	.line-total {
		border:none !important;
		background-color: transparent !important;
	}

	@media (max-width:767px) {
		#total-qty {
			margin-bottom: 5px;
		}
	}
</style>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
		<button type="button" class="btn btn-white btn-success top-btn" onclick="showCustomerModal()">ข้อมูลลูกค้า</button>
		<?php if($order->status == 0 && ($this->pm->can_add OR $this->can_edit)) : ?>
		<button type="button" class="btn btn-white btn-success top-btn" onclick="save()"><i class="fa fa-save"></i> บันทึก</button>
		<?php endif; ?>
	</div>
</div><!-- End Row -->
<hr class="padding-5">
<div class="row">
	<div class="col-lg-1-harf col-md-1-harf col-sm-2 col-xs-6 padding-5">
		<label>เลขที่เอกสาร</label>
		<input type="text" class="form-control input-sm text-center" id="code" name="code" value="<?php echo $order->code; ?>" disabled />
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label>ชนิด VAT</label>
		<select class="form-control input-sm edit" id="vat_type" name="vat_type">
			<option value="I" <?php echo is_selected('I', $order->vat_type); ?>>Include</option>
			<option value="E" <?php echo is_selected('E', $order->vat_type); ?>>Exclude</option>
		</select>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label>วันที่</label>
		<input type="text" class="form-control input-sm text-center e" id="doc_date" value="<?php echo thai_date($order->doc_date); ?>" readonly />
	</div>
	<div class="col-lg-2 col-md-1-harf col-sm-2 col-xs-6 padding-5">
		<label>รหัสลูกค้า</label>
		<input type="text" class="form-control input-sm text-center e" id="customer_code" data-code="<?php echo $order->customer_code; ?>" value="<?php echo $order->customer_code; ?>"/>
	</div>
	<div class="col-lg-5-harf col-md-6 col-sm-5 col-xs-12 padding-5">
		<label>ลูกค้า</label>
		<input type="text" class="form-control input-sm e" id="customer-name" value="<?php echo $order->customer_name; ?>"/>
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>เลขที่ผู้เสียภาษี</label>
		<input type="text" class="form-control input-sm e" maxlength="13" id="tax-id" value="<?php echo $order->tax_id; ?>" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label class="display-block not-show">เลขที่ผู้เสียภาษี</label>
		<label style="padding-top:4px;">
			<input type="checkbox" class="ace" id="is-company" onchange="toggleBranch()" value="1" <?php echo $order->branch_code === '0000' ? 'checked' : ''; ?>/>
			<span class="lbl"> นิติบุคคล</span>
		</label>
	</div>
	<div class="col-lg-1 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>สาขา</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="10" id="branch-code" value="<?php echo $order->branch_code; ?>" />
	</div>
	<div class="col-lg-2 col-md-3 col-sm-3-harf col-xs-6 padding-5">
		<label>ชื่อสาขา</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="branch-name" value="<?php echo $order->branch_name; ?>" />
	</div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 padding-5">
		<label>ที่อยู่</label>
		<input type="text" class="form-control input-sm e" maxlength="254"id="address" value="<?php echo $order->address; ?>" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>ตำบล</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="sub-district" value="<?php echo $order->sub_district; ?>" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>อำเภอ</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="district" value="<?php echo $order->district; ?>" />
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>จังหวัด</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="province" value="<?php echo $order->province; ?>" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>รหัสไปรษณีย์</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="12" id="postcode" value="<?php echo $order->postcode; ?>" />
	</div>
	<div class="col-lg-3 col-md-2-harf col-sm-2-harf col-xs-6 padding-5">
		<label>เบอร์โทร</label>
		<input type="text" class="form-control input-sm e" maxlength="32" id="phone" value="<?php echo $order->phone; ?>" />
	</div>
	<?php if($this->pm->can_add OR $this->pm->can_edit) : ?>
		<div class="row">
			<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
				<label class="display-block not-show">btn</label>
				<button type="button" class="btn btn-xs btn-primary btn-block" id="btn-update" onclick="updateHeader()">
					บันทึกหัวเอกสาร
				</button>
			</div>
		</div>
	<?php endif; ?>

	<input type="hidden" id="customerCode" value="<?php echo $order->customer_code; ?>" />
</div>
<?php if($order->status == 0) : ?>
<hr class="padding-5 margin-bottom-15" />
<div class="row">
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 padding-5">
		<?php if(!empty($reference)) : ?>
			<span>อ้างอิง : </span>
			<?php foreach($reference as $ref) : ?>
				<span class="label label-info label-white label-xlg middle">
					<?php echo $ref->order_code; ?>
					<i class="fa fa-trash red pointer order-ref" onclick="confirm_remove('<?php echo $ref->order_code; ?>')"></i>
				</span>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-xs btn-primary btn-100" onclick="getOrderList()">
			<i class="fa fa-search"></i> ออเดอร์
		</button>
	</div>
</div>
<?php endif; ?>
<hr class="padding-5" />
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 table-responsive border-1" style="padding:0px; min-height: 200px; max-height:600px;">
		<table class="table table-bordered tableFixHead" style="min-width:960px;">
			<thead>
				<tr>
					<th class="fix-width-40 text-center fix-header">#</th>
					<th class="fix-width-100 fix-header">รหัส</th>
					<th class="min-width-200 fix-header">รายละเอียด</th>
					<th class="fix-width-100 fix-header">อ้างอิง</th>
					<th class="fix-width-100 fix-header text-right">จำนวน</th>
					<th class="fix-width-80 fix-header">หน่วยนับ</th>
					<th class="fix-width-80 fix-header text-right">ราคา</th>
					<th class="fix-width-80 fix-header text-right">ส่วนลด</th>
					<th class="fix-width-80 fix-header text-right">ภาษี</th>
					<th class="fix-width-100 fix-header text-right">จำนวนเงิน</th>
				</tr>
			</thead>
			<tbody>
	<?php $no = 1; ?>
	<?php $total_amount_ex = 0; ?>
	<?php $total_amount_inc = 0; ?>
	<?php $total_vat_amount = 0; //-- มูล่ค่าสินค้าที่มีภาษี ?>
	<?php $total_non_vat_amount = 0; //--- มูลค่าสินค้าที่ยกเว้นภาษี ?>
	<?php $total_vat = 0; ?>
	<?php if(!empty($details)) : ?>
		<?php foreach($details as $rs) : ?>
				<?php $price = vat_price($rs->price, $order->vat_type, $rs->vat_rate); //--- vat_helper ?>
				<?php $amount = vat_price($rs->amount, $order->vat_type, $rs->vat_rate); ?>

				<tr id="row-<?php echo $rs->id; ?>">
					<td class="middle text-center no"><?php echo $no; ?></td>
					<td class="middle"><?php echo $rs->product_code; ?></td>
					<td class="middle"><?php echo $rs->product_name; ?></td>
					<td class="middle"><?php echo $rs->order_code; ?></td>
					<td class="middle text-right"><?php echo number($rs->qty,2); ?></td>
					<td class="middle"><?php echo $rs->unit_name; ?></td>
					<td class="middle text-right"><?php echo number($price, 2); ?></td>
					<td class="middle text-right"><?php echo $rs->discount_label; ?></td>
					<td class="middle text-right"><?php echo number($amount, 2); ?></td>
				</tr>
			<?php $no++; ?>
			<?php $total_amount_inc += $rs->amount; ?>
			<?php $total_amount_ex += $amount; ?>
			<?php $total_vat += $rs->vat_amount; ?>
			<?php $total_vat_amount += $rs->vat_rate > 0 ? $amount : 0; ?>
			<?php $total_non_vat_amount += $rs->vat_rate > 0 ? 0 : $amount; ?>
		<?php endforeach; ?>
	<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="divider-hidden"></div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5">
	  <div class="form-horizontal">
	    <div class="form-group">
	      <label class="col-lg-2 col-md-4 col-sm-4 control-label no-padding-right">Owner</label>
	      <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
	        <input type="text" class="form-control input-sm" value="<?php echo $order->uname; ?>" disabled>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5">
	  <div class="form-horizontal">
			<div class="form-group">
	      <label class="col-lg-8 col-md-8 col-sm-8 col-xs-6 control-label no-padding-right">รวมเป็นเงิน</label>
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 padding-5">
	        <input type="text" class="form-control input-sm text-right" value="<?php echo number($total_amount_ex, 2); ?>" disabled />
	      </div>
	    </div>

	    <div class="form-group">
	      <label class="col-lg-8 col-md-8 col-sm-8 col-xs-6 control-label no-padding-right">มูลค่าสินค้าที่ไม่มี/ยกเว้นภาษี</label>
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 padding-5">
	        <input type="text" class="form-control input-sm text-right" value="<?php echo number($total_non_vat_amount, 2); ?>" disabled />
	      </div>
	    </div>

			<div class="form-group">
	      <label class="col-lg-8 col-md-8 col-sm-8 col-xs-6 control-label no-padding-right">มูลค่าสินค้าที่คำนวณภาษี</label>
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 padding-5">
	        <input type="text" class="form-control input-sm text-right" value="<?php echo number($total_vat_amount, 2); ?>" disabled />
	      </div>
	    </div>

			<div class="form-group">
	      <label class="col-lg-8 col-md-8 col-sm-8 col-xs-6 control-label no-padding-right">ภาษีมูลค่าเพิ่ม <?php echo getConfig('SALE_VAT_RATE'); ?> %</label>
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 padding-5">
	        <input type="text" class="form-control input-sm text-right" value="<?php echo number($total_vat, 2); ?>" disabled />
	      </div>
	    </div>

	    <div class="form-group">
	      <label class="col-lg-8 col-md-8 col-sm-8 col-xs-6 control-label no-padding-right">รวมทั้งสิ้น</label>
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 padding-5">
	        <input type="text" class="form-control input-sm text-right" value="<?php echo number($total_amount_inc, 2); ?>" disabled/>
	      </div>
	    </div>
	  </div> <!-- form horizontal -->
	</div>
</div>

<?php $this->load->view('order_invoice/customer_modal'); ?>

<div class="modal fade" id="order-list-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:300px; max-width:90vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" >
            <div id="orderList"></div>
            </div>
            <div class="modal-footer">
               <button class="btn btn-sm btn-info btn-block" data-dismiss="modal" onclick="addToOrder()">เพิ่มรายการที่เลือก</button>
            </div>
        </div>
    </div>
</div>

<script type="text/x-handlebarsTemplate" id="orderListTemplate">
	<table class="table table-striped" style="margin-bottom:0px;">
	{{#each this}}
		<tr>
			<td class="width-50">
			<label>
				<input type="checkbox" class="ace chk" value="{{orderCode}}">
				<span class="lbl">&nbsp;&nbsp; {{orderCode}}</span>
			</label>
			</td>
			<td class="width-50 text-right">{{amount}}</td>
		</tr>
	{{/each}}
	</table>
</script>


<script src="<?php echo base_url(); ?>scripts/order_invoice/order_invoice.js?v=<?php echo date('Ymd'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/order_invoice/order_invoice_control.js?v=<?php echo date('Ymd'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
