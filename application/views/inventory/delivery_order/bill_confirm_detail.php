
<input type="hidden" id="order_code" value="<?php echo $order->code; ?>" />

<div class="row">
  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
    <label>เลขที่เอกสาร</label>
    <input type="text" class="form-control input-sm text-center" value="<?php echo $order->code; ?>" disabled />
  </div>
  <div class="col-lg-1 col-md-1-harf col-sm-1-harf col-xs-6 padding-5">
    <label>วันที่</label>
    <input type="text" class="form-control input-sm text-center edit" name="date" id="date" value="<?php echo thai_date($order->date_add); ?>" disabled readonly />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
    <label>ลูกค้า[ในระบบ]</label>
    <input type="text" class="form-control input-sm" id="customer-code" value="<?php echo $order->customer_code; ?>" disabled />
  </div>
  <div class="col-lg-5 col-md-6-harf col-sm-6-harf col-xs-6 padding-5">
    <label class="not-show">ลูกค้า</label>
    <input type="text" class="form-control input-sm edit" id="customer" name="customer" value="<?php echo $order->customer_name; ?>" required disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
    <label>ลูกค้า[ออนไลน์]</label>
    <input type="text" class="form-control input-sm edit" id="customer_ref" name="customer_ref" value="<?php echo $order->customer_ref; ?>" disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
    <label>ช่องทางขาย</label>
    <input type="text" class="form-control input-sm" value="<?php echo $order->channels_name; ?>" disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
    <label>การชำระเงิน</label>
    <input type="text" class="form-control input-sm" value="<?php echo $order->payment_name; ?>" disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2 col-xs-6 padding-5">
    <label>อ้างอิง</label>
    <input type="text" class="form-control input-sm text-center edit" name="reference" id="reference" value="<?php echo $order->reference; ?>" disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
    <label>เลขที่จัดส่ง</label>
    <input type="text" class="form-control input-sm text-center edit" name="shipping_code" id="shipping_code" value="<?php echo $order->shipping_code; ?>" disabled />
  </div>
  <div class="col-lg-1-harf col-md-2 col-sm-2-harf col-xs-6 padding-5">
    <label>การจัดส่ง</label>
    <input type="text" class="form-control input-sm" value="<?php echo $order->sender_name; ?>" disabled />
  </div>
  <div class="col-lg-6 col-md-12 col-sm-9-harf col-xs-12 padding-5 ">
    <label>หมายเหตุ</label>
    <input type="text" class="form-control input-sm edit" name="remark" id="remark" value="<?php echo $order->remark; ?>" disabled />
  </div>
</div>
<hr/>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-5 text-right">
    <?php if( $this->pm->can_edit || $this->pm->can_add ) : ?>
      <?php if($order->is_term == 1 OR $order->balance <= 0 OR $order->payment_role == 4) : ?>
				<?php if($use_prepare === FALSE && $has_default_zone === FALSE) : ?>
							<div class="alert alert-danger text-center margin-bottom-10">กรุณากำหนดค่า โซนขายสินค้าเริ่มต้น</div>
				<?php else : ?>
      				<button type="button" class="btn btn-sm btn-primary" id="btn-confirm-order" onclick="confirmOrder()">เปิดบิลและตัดสต็อก</button>
				<?php endif; ?>
      <?php else : ?>
        <span class="red">มียอดค้างชำระ : <?php echo number($order->balance,2); ?></span>
      <button type="button" class="btn btn-sm btn-info" onclick="refresh()"><i class="fa fa-refresh"></i> รีเฟรช</button>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<hr/>

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 padding-5 table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr class="font-size-12">
          <th class="width-5 text-center">ลำดับ</th>
          <th class="width-35 text-center">สินค้า</th>
          <th class="width-10 text-center">ราคา</th>
          <th class="width-10 text-center">ออเดอร์</th>
				<?php if($use_prepare) : ?>
          <th class="width-10 text-center">จัด</th>
				<?php endif; ?>
        <?php if($use_qc) : ?>
          <th class="width-10 text-center">ตรวจ</th>
        <?php endif; ?>
          <th class="width-10 text-center">ส่วนลด</th>
          <th class="width-10 text-center">มูลค่า</th>
        </tr>
      </thead>
      <tbody>
<?php if(!empty($details)) : ?>
<?php   $no = 1;
        $totalQty = 0;
        $totalPrepared = 0;
        $totalQc = 0;
        $totalAmount = 0;
        $totalDiscount = 0;
        $totalPrice = 0;
?>
<?php   foreach($details as $rs) :  ?>
  <?php  $color = ''; ?>
<?php     if($use_qc)
          {
            $color = ($rs->order_qty == $rs->qc OR $rs->is_count == 0) ? '' : 'red';
          }
          else
          {
						if($use_prepare)
						{
							$color = ($rs->order_qty == $rs->prepared OR $rs->is_count == 0) ? '' : 'red';
						}
          }
?>
        <tr class="font-size-12 <?php echo $color; ?>">
          <td class="text-center">
            <?php echo $no; ?>
          </td>

          <!--- รายการสินค้า ที่มีการสั่งสินค้า --->
          <td>
            <?php echo limitText($rs->product_code.' : '. $rs->product_name, 100); ?>
          </td>

          <!--- ราคาสินค้า  --->
          <td class="text-center">
            <?php echo number($rs->price, 2); ?>
          </td>

          <!---   จำนวนที่สั่ง  --->
          <td class="text-center">
            <?php echo number($rs->order_qty); ?>
          </td>

          <!--- จำนวนที่จัดได้  --->
				<?php if($use_prepare) : ?>
          <td class="text-center">
            <?php echo $rs->is_count == 0 ? number($rs->order_qty) : number($rs->prepared); ?>
          </td>
				<?php endif; ?>
        <?php if($use_qc) : ?>
          <!--- จำนวนที่ตรวจได้ --->
          <td class="text-center">
            <?php echo $rs->is_count == 0 ? number($rs->order_qty) : number($rs->qc); ?>
          </td>
      <?php endif; ?>
          <!--- ส่วนลด  --->
          <td class="text-center">
            <?php echo discountLabel($rs->discount1, $rs->discount2, $rs->discount3); ?>
          </td>

          <td class="text-right">
				<?php if($use_qc)
							{
								echo $rs->is_count == 0 ? number($rs->final_price * $rs->order_qty, 2) : number( $rs->final_price * $rs->qc , 2);
							}
							else
							{
								if($use_prepare)
								{
									echo $rs->is_count == 0 ? number($rs->final_price * $rs->order_qty) : number( $rs->final_price * $rs->prepared , 2);
								}
								else
								{
									echo number($rs->final_price * $rs->order_qty, 2);
								}
							}
				?>
          </td>

        </tr>
<?php
      $totalQty += $rs->order_qty;

			if($use_prepare)
			{
				$totalPrepared += ($rs->is_count == 0 ? $rs->order_qty : $rs->prepared);
			}

			if($use_qc)
			{
				$totalQc += ($rs->is_count == 0 ? $rs->order_qty : $rs->qc);
			}

      if($use_qc)
      {
        $totalDiscount += ($rs->is_count == 0 ? $rs->discount_amount * $rs->order_qty : $rs->discount_amount * $rs->qc);
        $totalAmount += ($rs->is_count == 0 ? $rs->final_price * $rs->order_qty : $rs->final_price * $rs->qc);
        $totalPrice += ($rs->is_count == 0 ? $rs->price * $rs->order_qty : $rs->price * $rs->qc);
      }
      else
      {
				if($use_prepare)
				{
					$totalDiscount += ($rs->is_count == 0 ? $rs->discount_amount * $rs->order_qty : $rs->discount_amount * $rs->prepared);
					$totalAmount += ($rs->is_count == 0 ? $rs->final_price * $rs->order_qty : $rs->final_price * $rs->prepared);
					$totalPrice += ($rs->is_count == 0 ? $rs->price * $rs->order_qty : $rs->price * $rs->prepared);
				}
				else
				{
					$totalDiscount += $rs->discount_amount * $rs->order_qty;
					$totalAmount += $rs->final_price * $rs->order_qty;
					$totalPrice += $rs->price * $rs->order_qty;
				}
      }

      $no++;
?>
<?php   endforeach; ?>

<?php   $netAmount = ($totalPrice - $totalDiscount - $order->bDiscAmount) + $order->shipping_fee + $order->service_fee - $order->deposit; ?>
        <tr class="font-size-12">
          <td colspan="3" class="text-right font-size-14">
            รวม
          </td>

          <td class="text-center">
            <?php echo number($totalQty); ?>
          </td>
				<?php if($use_prepare): ?>
          <td class="text-center">
            <?php echo number($totalPrepared); ?>
          </td>
				<?php endif; ?>
        <?php if($use_qc) : ?>
          <td class="text-center">
            <?php echo number($totalQc); ?>
          </td>
        <?php endif; ?>

          <td class="">ส่วนลดท้ายบิล</td>
					<td class="text-right">- <?php echo number($order->bDiscAmount,2); ?></td>

        </tr>

        <?php $colspan = $use_qc ? 3 : ($use_prepare ? 2 : 1); ?>
        <tr>
          <td colspan="3" rowspan="6">

          </td>
          <td colspan="<?php echo $colspan; ?>" class="blod">
            ราคารวม
          </td>
          <td colspan="2" class="text-right">
            <?php echo number($totalPrice, 2); ?>
          </td>
        </tr>

        <tr>
          <td colspan="<?php echo $colspan; ?>">
            ส่วนลดรวม
          </td>
          <td colspan="2" class="text-right">
            - <?php echo number($totalDiscount + $order->bDiscAmount, 2); ?>
          </td>
        </tr>

        <tr>
          <td colspan="<?php echo $colspan; ?>">
            ค่าจัดส่ง
          </td>
          <td colspan="2" class="text-right">
            <?php echo number($order->shipping_fee, 2); ?>
          </td>
        </tr>

        <tr>
          <td colspan="<?php echo $colspan; ?>">
            อื่นๆ
          </td>
          <td colspan="2" class="text-right">
            <?php echo number($order->service_fee, 2); ?>
          </td>
        </tr>

        <tr>
          <td colspan="<?php echo $colspan; ?>">
            ชำระแล้ว
          </td>
          <td colspan="2" class="text-right">
            - <?php echo number($order->deposit, 2); ?>
          </td>
        </tr>

        <tr>
          <td colspan="<?php echo $colspan; ?>" class="blod">
            ยอดเงินสุทธิ
          </td>
          <td colspan="2" class="text-right">
            <?php echo number($netAmount, 2); ?>
          </td>
        </tr>

<?php else : ?>
      <tr><td colspan="8" class="text-center"><h4>ไม่พบรายการ</h4></td></tr>
<?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
