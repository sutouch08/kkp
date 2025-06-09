<?php $this->load->view('include/header'); ?>
<div class="row hidden-print">
	<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12 padding-5 padding-top-5">
		<h3 class="title">
			<i class="fa fa-bar-chart"></i>
			<?php echo $this->title; ?>
		</h3>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 padding-5 text-right">
		<button type="button" class="btn btn-sm btn-success top-btn" onclick="getReport()"><i class="fa fa-bar-chart"></i> รายงาน</button>
		<button type="button" class="btn btn-sm btn-primary top-btn" onclick="doExport()"><i class="fa fa-file-excel-o"></i> ส่งออก</button>
	</div>
</div><!-- End Row -->
<hr class="padding-5 hidden-print"/>
<form class="hidden-print" id="reportForm" method="post" action="<?php echo $this->home; ?>/do_export">
	<div class="row">
		<div class="col-lg-2 col-md-2-harf col-sm-3 col-xs-6 padding-5">
			<label>วันที่</label>
			<div class="input-daterange input-group width-100">
				<input type="text" class="form-control input-sm text-center width-50 from-date e" name="fromDate" id="fromDate" value="<?php echo date('01-m-Y'); ?>" />
				<input type="text" class="form-control input-sm text-center width-50 e" name="toDate" id="toDate" value="<?php echo date('t-m-Y'); ?>" />
			</div>
		</div>
		<div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-4 padding-5">
			<label>สถานะ</label>
			<select class="form-control input-sm" id="status" name="status">
				<option value="all">ทั้งหมด</option>
				<option value="1">สถานะปกติ</option>
				<option value="2">ยกเลิก</option>
			</select>
		</div>

		<div class="col-lg-2 col-md-2-harf col-sm-2-harf col-xs-6 padding-5">
			<label>order by</label>
			<select class="form-control input-sm" id="orderBy" name="orderBy">
				<option value="code">เรียงตามเลขที่</option>
				<option value="date">เรียงตามวันที่</option>
			</select>
		</div>
		<input type="hidden" id="token" name="token" value="">
	</div>
</form>
<hr class="padding-5">

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0 table-responsive border-1" style="min-height:300px;">
		<table class="table table-bordered" style="min-width:1440px; margin-top:-1px;">
			<thead>
				<tr>
					<th class="fix-width-50 text-center">#</th>
					<th class="fix-width-100 text-center">ว/ด/ป</th>
					<th class="fix-width-120 text-center">เลขที่ Invoice</th>
					<th class="fix-width-50 text-center">สถานะ</th>
					<th class="fix-width-120 text-center">เลขที่ Order</th>
					<th class="min-width-250 text-center">ชื่อลูกค้า</th>
					<th class="fix-width-100 text-center">Tax ID</th>
					<th class="fix-width-100 text-center">สาขา</th>
					<th class="fix-width-150 text-center">สินค้ามี VAT<br/>(ยอดก่อน vat)</th>
					<th class="fix-width-100 text-center">VAT</th>
					<th class="fix-width-100 text-center">สินค้า No-Vat</th>
					<th class="fix-width-100 text-center">มูลค่ารวม</th>
					<th class="fix-width-100 text-center">Channels</th>
				</tr>
			</thead>
			<tbody id="result-table">

			</tbody>
		</table>
	</div>
</div>



<script id="template" type="text/x-handlebars-template">
	{{#each this}}
	  {{#if nodata}}
	    <tr>
	      <td colspan="12" align="center"><h4>-----  ไม่พบสินค้าคงเหลือตามเงื่อนไขที่กำหนด  -----</h4></td>
	    </tr>
	  {{else}}
	    {{#if @last}}
	    <tr class="font-size-12">
	      <td colspan="8" class="text-right">รวม</td>
	      <td class="text-right">{{ totalBefVat }}</td>
	      <td class="text-right">{{ vatTotal }}</td>
				<td class="text-right">{{ totalNonVat }}</td>
				<td class="text-right">{{ docTotal }}</td>
				<td></td>
	    </tr>
	    {{else}}
	    <tr class="font-size-12">
	      <td class="text-center">{{no}}</td>
	      <td class="text-center">{{ doc_date }}</td>
	      <td class="">{{ code }}</td>
				<td class="text-center">{{ status }}</td>
	      <td class="">{{ reference }}</td>
				<td class="">{{customer_name}}</td>
				<td class="">{{tax_id}}</td>
				<td class="">{{branch_name}}</td>
	      <td class="text-right">{{ amountBefVat }}</td>
	      <td class="text-right">{{ vatAmount }}</td>
				<td class="text-right">{{ nonVatAmount }}</td>
				<td class="text-right">{{ lineTotal }}</td>
				<td class="text-right">{{ channels }}</td>
	    </tr>
	    {{/if}}
	  {{/if}}
	{{/each}}
</script>

<script src="<?php echo base_url(); ?>scripts/report/sales/sales_invoice_summary.js?v=<?php echo date('YmdH'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
