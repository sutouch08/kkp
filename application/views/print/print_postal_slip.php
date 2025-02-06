<?php
$Page = '';
$config   = array(
  "row" => 13,
  "total_row" => 1,
  "header_row" => 0,
  "footer_row" => 0,
  "sub_total_row" => 0,
  "content_border" => 0
);


$this->printer->config($config);

echo $this->printer->doc_header();
echo $this->printer->page_start();
echo $this->printer->content_start();

$province = parseProvince($order->province);
$district = parseDistrict($order->district, $province);
$sub_district = parseSubDistrict($order->sub_district, $province);
$address = parseAddress($order->address, $sub_district, $district, $province, $order->postcode);
?>
<div class="row" style="height:80mm; border-bottom:dashed 1px #607D8B; padding:5mm;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div style="width:65mm;">
      <span style="font-size:12px; font-weight:bolder; white-space:normal;"><?php echo getConfig('COMPANY_FULL_NAME'); ?></span>
      <p style="font-size:12px; white-space:prewrap;">
        <?php echo getConfig('COMPANY_ADDRESS1').' '.getConfig('COMPANY_ADDRESS2').' '.getConfig('COMPANY_POST_CODE'); ?>
        <span class="display-block">โทร. <?php echo getConfig('COMPANY_PHONE'); ?></span>
      </p>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div style="width:95mm; margin-left:65mm;">
      <p style="font-size:14px; margin-bottom:3px;">กรูณานำส่ง</p>
      <?php if( ! empty($order->contact_person)) : ?>
        <p style="font-size:14px; margin-bottom:3px;"><?php echo $order->contact_person; ?></p>
      <?php endif; ?>
      <p style="font-size:14px; margin-bottom:3px;"><?php echo $order->customer_name; ?></p>
      <p style="font-size:14px;">
        <?php echo $address; ?>
      </p>
    </div>
  </div>
</div>
<?php
echo $this->printer->content_end();
echo $this->printer->page_end();
echo $this->printer->doc_footer();

?>
