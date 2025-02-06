<?php $this->load->view('include/header'); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 padding-top-5">
		<h3 class="title"><?php echo $this->title; ?></h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-white btn-warning top-btn" onclick="goBack()"><i class="fa fa-arrow-left"></i> กลับ</button>
		<button type="button" class="btn btn-white btn-success top-btn" onclick="showCustomerModal()">ข้อมูลลูกค้า</button>
		<?php if($order->status != 2 && $this->pm->can_delete) : ?>
			<button type="button" class="btn btn-white btn-danger top-btn" onclick="getDelete()"><i class="fa fa-times"></i> ยกเลิก</button>
		<?php endif; ?>
		<?php if($order->status == 1) : ?>
			<?php if($use_vat) : ?>
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-info btn-white dropdown-toggle margin-top-5" aria-expanded="false">
						<i class="ace-icon fa fa-print icon-on-left"></i>
						พิมพ์
						<i class="ace-icon fa fa-angle-down icon-on-right"></i>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li class="success">
							<a href="javascript:print_tax_receipt()"><i class="fa fa-print"></i> ใบเสร็จ/ใบกำกับภาษี</a>
						</li>
						<li class="info">
							<a href="javascript:print_tax_invoice()"><i class="fa fa-print"></i> ใบแจ้งหนี้/ใบกำกับภาษี</a>
						</li>
						<li class="purple">
							<a href="javascript:print_tax_billing_note()"><i class="fa fa-print"></i>  ใบวางบิล/ใบแจ้งหนี้ี</a>
						</li>
						<li class="">
							<a href="javascript:print_postal_slip()"><i class="fa fa-print"></i>  ใบนำส่ง</a>
						</li>
					</ul>
				</div>
			<?php else : ?>
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-info btn-white dropdown-toggle margin-top-5" aria-expanded="false">
						<i class="ace-icon fa fa-print icon-on-left"></i>
						พิมพ์
						<i class="ace-icon fa fa-angle-down icon-on-right"></i>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li class="info">
							<a href="javascript:print_do_invoice()"><i class="fa fa-print"></i>  ใบแจ้งหนี้ี</a>
						</li>
						<li class="success">
							<a href="javascript:print_do_receipt()"><i class="fa fa-print"></i> ใบเสร็จ</a>
						</li>
						<li class="">
							<a href="javascript:print_postal_slip()"><i class="fa fa-print"></i>  ใบนำส่ง</a>
						</li>
					</ul>
				</div>
			<?php endif; ?>
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
		<select class="form-control input-sm edit" id="vat_type" name="vat_type" disabled>
			<option value="I" <?php echo is_selected('I', $order->vat_type); ?>>Include</option>
			<option value="E" <?php echo is_selected('E', $order->vat_type); ?>>Exclude</option>
		</select>
	</div>
	<div class="col-lg-1-harf col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
		<label>วันที่</label>
		<input type="text" class="form-control input-sm text-center e" id="doc_date" value="<?php echo thai_date($order->doc_date); ?>" readonly disabled/>
	</div>
	<div class="col-lg-2 col-md-1-harf col-sm-2 col-xs-6 padding-5">
		<label>รหัสลูกค้า</label>
		<input type="text" class="form-control input-sm text-center e" id="customer_code" data-code="<?php echo $order->customer_code; ?>" value="<?php echo $order->customer_code; ?>" disabled/>
	</div>
	<div class="col-lg-5-harf col-md-6 col-sm-5 col-xs-12 padding-5">
		<label>ลูกค้า</label>
		<input type="text" class="form-control input-sm e" id="customer-name" value="<?php echo $order->customer_name; ?>"/>
	</div>
	<div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 padding-5">
		<label>ผู้ติดต่อ</label>
		<input type="text" class="form-control input-sm e" id="contact" value="<?php echo $order->contact_person; ?>" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>เลขที่ผู้เสียภาษี</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="13" id="tax-id" value="<?php echo $order->tax_id; ?>" />
	</div>
	<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-4 padding-5">
		<label class="display-block not-show">นิติ</label>
		<label style="padding-top:4px;">
			<input type="checkbox" class="ace" id="is-company" onchange="toggleBranch()" value="1" <?php echo is_checked($order->is_company, '1') ?>/>
			<span class="lbl"> นิติบุคคล</span>
		</label>
	</div>
	<div class="col-lg-1 col-md-2 col-sm-2 col-xs-3 padding-5">
		<label>สาขา</label>
		<input type="text" class="form-control input-sm text-center e" maxlength="10" id="branch-code" value="<?php echo $order->branch_code; ?>" />
	</div>
	<div class="col-lg-1-harf col-md-3 col-sm-3 col-xs-5 padding-5">
		<label>ชื่อสาขา</label>
		<input type="text" class="form-control input-sm e" maxlength="100" id="branch-name" value="<?php echo $order->branch_name; ?>" />
	</div>
	<div class="col-lg-4-harf col-md-12 col-sm-12 col-xs-12 padding-5">
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
	<div class="col-lg-3 col-md-2 col-sm-2 col-xs-6 padding-5">
		<label>เบอร์โทร</label>
		<input type="text" class="form-control input-sm e" maxlength="32" id="phone" value="<?php echo $order->phone; ?>" />
	</div>
	<?php if($this->pm->can_add OR $this->pm->can_edit) : ?>
		<div class="row">
			<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
				<label class="display-block not-show">btn</label>
				<button type="button" class="btn btn-xs btn-primary btn-block" id="btn-update" onclick="updateHeader()">
					บันทึกหัวเอกสาร
				</button>
			</div>
		</div>
	<?php endif; ?>
</div>
<input type="hidden" id="customerCode" value="<?php echo $order->customer_code; ?>" />
<?php
if($order->status == 2)
{
  $this->load->view('cancle_watermark');
}
?>
<hr class="padding-5" />
<div class="row">
<div class="col-sm-12 col-xs-12 padding-5">
	<?php if(!empty($reference)) : ?>
		<span>อ้างอิง : </span>
		<?php foreach($reference as $ref) : ?>
			<span class="label label-info label-white label-xlg middle">
				<?php echo $ref->order_code; ?>
			</span>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
</div>
<hr class="padding-5 margin-top-15" />
<div class="row">
	<div class="col-sm-12 col-xs-12 padding-5 table-responsive">
		<table class="table border-1" style="min-width:1110px;">
			<thead>
				<tr>
					<th class="fix-width-50 text-center">#</th>
					<th class="fix-width-100">รหัส</th>
					<th class="fix-width-250">รายละเอียด</th>
					<th class="fix-width-120">อ้างอิง</th>
					<th class="fix-width-80 text-right">จำนวน</th>
					<th class="fix-width-80">หน่วยนับ</th>
					<th class="fix-width-80 text-right">ราคา</th>
					<th class="fix-width-100 text-right">ส่วนลด</th>
				<?php if($use_vat) : ?>
					<th class="fix-width-100 text-right">ภาษี</th>
				<?php endif; ?>
					<th class="fix-width-150 text-right">จำนวนเงิน</th>
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
				<?php if($use_vat) : ?>
					<td class="middle text-right"><?php echo $rs->vat_rate > 0 ? round($rs->vat_rate, 2) ."%" : "ยกเว้น"; ?></td>
				<?php endif; ?>
					<td class="middle text-right"><?php echo number($amount, 2); ?></td>
				</tr>
			<?php $no++; ?>
			<?php $total_amount_inc += $rs->amount; ?>
			<?php $total_amount_ex += $amount; ?>
			<?php $total_vat += $rs->vat_amount; ?>
			<?php $total_vat_amount += $rs->vat_rate > 0 ? $amount : 0; ?>
			<?php $total_non_vat_amount += $rs->vat_rate > 0 ? 0 : $amount; ?>
		<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="10" class="text-center">&nbsp;</td>
		</tr>
	<?php endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="<?php echo ($use_vat === TRUE ? 7 : 6); ?>" rowspan="<?php echo ($use_vat === TRUE ? 5 : 2); ?>" style="white-space:normal; border-right: solid 1px #dddddd;">
						<b>หมายเหตุ : </b>
						<?php echo $order->remark; ?>
					</td>
					<td colspan="2" class="middle text-right">รวมเป็นเงิน</td>
					<td class="middle text-right"><?php echo number($total_amount_ex, 2); ?></td>
				</tr>
			<?php if($use_vat) : ?>
				<tr>
					<td colspan="2" class="middle text-right">มูลค่าสินค้าที่ไม่มี/ยกเว้นภาษี</td>
					<td class="middle text-right"><?php echo number($total_non_vat_amount, 2); ?></td>
				</tr>
				<tr>
					<td colspan="2" class="middle text-right">มูลค่าสินค้าที่คำนวณภาษี</td>
					<td class="middle text-right"><?php echo number($total_vat_amount, 2); ?></td>
				</tr>
				<tr>
					<td colspan="2" class="middle text-right">ภาษีมูลค่าเพิ่ม <?php echo getConfig('SALE_VAT_RATE'); ?> %</td>
					<td class="middle text-right"><?php echo number($total_vat, 2); ?></td>
				</tr>
			<?php endif; ?>
				<tr>
					<td colspan="2" class="middle text-right">จำนวนเงินรวมทั้งสิ้น</td>
					<td class="middle text-right"><?php echo number($total_amount_inc, 2); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>


<?php $this->load->view('order_invoice/customer_modal'); ?>


<div class="modal fade" id="order-list-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:300px;">
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





<script src="<?php echo base_url(); ?>scripts/order_invoice/order_invoice.js?v=<?php echo date('YmdH'); ?>"></script>
<script src="<?php echo base_url(); ?>scripts/order_invoice/order_invoice_control.js?v=<?php echo date('YmdH'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
