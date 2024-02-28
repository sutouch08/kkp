

<div class="row">
  <div class="col-sm-2 col-xs-8 padding-5 first">
    <label>รหัสโซน</label>
    <input type="text" class="form-control input-sm" id="barcode-zone" autofocus />
  </div>
  <div class="col-sm-1 col-xs-4 padding-5">
    <label class="display-block not-show">changeZone</label>
    <button type="button" class="btn btn-xs btn-info btn-block" id="btn-change-zone" onclick="changeZone()">เปลี่ยนโซน</button>
  </div>
  <div class="col-sm-1 col-xs-4 padding-5">
    <label>จำนวน</label>
    <input type="number" class="form-control input-sm text-center" id="qty" value="1" disabled/>
  </div>
  <div class="col-sm-2 col-xs-8 padding-5">
    <label>บาร์โค้ดสินค้า</label>
    <input type="text" class="form-control input-sm" id="barcode-item" disabled/>
  </div>
  <div class="col-sm-1 col-xs-12 padding-5">
    <label class="display-block not-show">Submit</label>
    <button type="button" class="btn btn-xs btn-default btn-block" id="btn-submit" onclick="doPrepare()" disabled>ตกลง</button>
  </div>


  <input type="hidden" name="zone_code" id="zone_code" />

</div>
