<?php $this->load->view('include/header'); ?>
<div class="row hidden-print">
	<div class="col-sm-6 padding-5">
    <h3 class="title">
      <i class="fa fa-bar-chart"></i>
      <?php echo $this->title; ?>
    </h3>
    </div>
		<div class="col-sm-6 padding-5">
			<p class="pull-right top-p">
        <button type="button" class="btn btn-sm btn-success" onclick="getReport()"><i class="fa fa-bar-chart"></i> <?php label('report'); ?></button>
				<button type="button" class="btn btn-sm btn-primary" onclick="doExport()"><i class="fa fa-file-excel-o"></i> <?php label('export'); ?></button>
			</p>
		</div>
</div><!-- End Row -->
<hr class="padding-5 hidden-print"/>
<form class="hidden-print" id="reportForm" method="post" action="<?php echo $this->home; ?>/do_export">
<div class="row">
  <div class="col-sm-1 col-1-harf padding-5">
    <label class="display-block">สินค้า</label>
    <div class="btn-group width-100">
      <button type="button" class="btn btn-sm btn-primary width-50" id="btn-cus-all" onclick="toggleAllCustomer(1)">ทั้งหมด</button>
      <button type="button" class="btn btn-sm width-50" id="btn-cus-range" onclick="toggleAllCustomer(0)">เลือก</button>
    </div>
  </div>
  <div class="col-sm-1 col-1-harf padding-5">
    <label class="display-block">เริ่มต้น</label>
    <input type="text" class="form-control input-sm text-center" id="cusFrom" name="cusFrom" disabled>
  </div>
  <div class="col-sm-1 col-1-harf padding-5">
    <label class="display-block">สิ้นสุด</label>
    <input type="text" class="form-control input-sm text-center" id="cusTo" name="cusTo" disabled>
  </div>

  <div class="col-sm-2 padding-5">
    <label>วันที่</label>
    <div class="input-daterange input-group">
      <input type="text" class="form-control input-sm text-center width-50 from-date" name="fromDate" id="fromDate" value="" />
      <input type="text" class="form-control input-sm text-center width-50" name="toDate" id="toDate" value="" />
    </div>
  </div>

	<div class="col-sm-3 padding-5">
    <label class="display-block not-show">order by</label>
    <div class="btn-group width-100">
      <button type="button" class="btn btn-sm btn-primary width-50" id="btn-amount" onclick="toggleOrderBy('amount')">เรียงตามมูลค่า</button>
      <button type="button" class="btn btn-sm width-50" id="btn-qty" onclick="toggleOrderBy('qty')">เรียงตามจำนวนขาย</button>
    </div>
  </div>

  <input type="hidden" id="allCustomer" name="allCustomer" value="1">
	<input type="hidden" id="token" name="token" value="<?php echo uniqid(); ?>">
	<input type="hidden" id="orderBy" name="orderBy" value="amount" ><!-- amount or qty -->
</div>
<hr class="padding-5">
</form>

<div class="row">
	<div class="col-sm-12 padding-5" id="rs">

    </div>
</div>




<script id="template" type="text/x-handlebars-template">
  <table class="table table-bordered table-striped">
    <tr>
      <th colspan="5" class="text-center">รายงานยอดขาย แยกตามลูกค้า </th>
    </tr>
    <tr>
      <th colspan="5" class="text-center">วันที่ {{ reportDate }} (วันที่เปิดบิล) </th>
    </tr>
    <tr>
      <th colspan="5" class="text-center"> ลูกค้า : {{ cusList }} </th>
    </tr>
    <tr class="font-size-12">
      <th class="width-5 middle text-center">ลำดับ</th>
      <th class="width-10 middle">รหัส</th>
      <th class="middle">ลูกค้า</th>
      <th class="width-15 middle text-right">จำนวน</th>
      <th class="width-15 text-right middle">มูลค่า(vat exclude)</th>
    </tr>
{{#each bs}}
  {{#if nodata}}
    <tr>
      <td colspan="5" align="center"><h4>-----  ไม่พบสินค้าคงเหลือตามเงื่อนไขที่กำหนด  -----</h4></td>
    </tr>
  {{else}}
    {{#if @last}}
    <tr class="font-size-14">
      <td colspan="3" class="text-right">รวม</td>
      <td class="text-right">{{ totalQty }}</td>
      <td class="text-right">{{ totalAmount }}</td>
    </tr>
    {{else}}
    <tr class="font-size-12">
      <td class="middle text-center">{{no}}</td>
      <td class="middle">{{ cusCode }}</td>
      <td class="middle">{{ cusName }}</td>
      <td class="middle text-right">{{ qty }}</td>
      <td class="middle text-right">{{ amount }}</td>
    </tr>
    {{/if}}
  {{/if}}
{{/each}}
  </table>
</script>

<script src="<?php echo base_url(); ?>scripts/report/sales/sales_by_customer.js?v=<?php echo date('YmdH'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
