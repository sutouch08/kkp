<?php $this->load->view('include/header'); ?>
<div class="row hidden-print">
	<div class="col-sm-6 col-xs-9 padding-5">
    <h4 class="title">
      <i class="fa fa-bar-chart"></i>
      <?php echo $this->title; ?>
    </h4>
    </div>
		<div class="col-sm-6 col-xs-3 padding-5">
			<p class="pull-right top-p">
				<button type="button" class="btn btn-sm btn-primary" onclick="doExport()"><i class="fa fa-file-excel-o"></i> ส่งออก</button>
			</p>
		</div>
</div><!-- End Row -->
<hr class="padding-5 hidden-print"/>
<form class="hidden-print" id="reportForm" method="post" action="<?php echo $this->home; ?>/do_export">
<div class="row">
	<div class="col-sm-3 col-xs-12 padding-5">
		<label class="display-block">รูปแบบ</label>
    <div class="btn-group width-100">
      <button type="button" class="btn btn-sm btn-primary width-33" id="btn-all" onclick="toggleRole('all')">ทั้งหมด</button>
      <button type="button" class="btn btn-sm width-33" id="btn-sale" onclick="toggleRole('S')">ขาย</button>
			<button type="button" class="btn btn-sm width-33" id="btn-consign" onclick="toggleRole('M')">ฝากขาย</button>
    </div>
	</div>

	<div class="col-sm-2 padding-5">
    <label class="display-block">วันที่</label>
		<div class="input-daterange input-group width-100">
      <input type="text" class="form-control input-sm width-50 text-center from-date" name="fromDate" id="fromDate" placeholder="เริ่มต้น" readonly />
      <input type="text" class="form-control input-sm width-50 text-center" name="toDate" id="toDate" placeholder="สิ้นสุด" readonly/>
    </div>
  </div>
</div>
<hr class="padding-5">

	<input type="hidden" id="role" name="role" value="all" />
	<input type="hidden" id="token" name="token" value="<?php echo uniqid(); ?>" />

</form>

<div class="row">
	<div class="col-sm-12 col-xs-12 padding-5" id="rs">
		<blockquote>
      <p class="lead" style="color:#CCC;">
        รายงานจะไม่แสดงข้อมูลทางหน้าจอ เนื่องจากข้อมูลมีจำนวนคอลัมภ์ที่ยาวเกินกว่าที่จะแสดงผลทางหน้าจอได้ทั้งหมด กรุณา export ข้อมูลเป็นไฟล์ Excel แทน
      </p>
    </blockquote>
    </div>
</div>

<script src="<?php echo base_url(); ?>scripts/report/sales/order_sold_details.js?v=<?php echo date('YmdH'); ?>"></script>
<?php $this->load->view('include/footer'); ?>
