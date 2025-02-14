<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_invoice_summary extends PS_Controller
{
  public $menu_code = 'RSINVS';
	public $menu_group_code = 'RE';
  public $menu_sub_group_code = 'RESALE';
	public $title = 'รายงานสรุปภาษีขาย';
  public $filter;

  public function __construct()
  {
    parent::__construct();
    $this->home = base_url().'report/sales/sales_invoice_summary';
    $this->load->model('report/sales/sales_report_model');
  }

  public function index()
  {
    $this->load->view('report/sales/sales_invoice_summary');
  }


  public function get_report()
  {
    $sc = TRUE;
    $result = array();
    $ds = json_decode($this->input->get('data'));

    if( ! empty($ds))
    {
      $arr = array(
        'from_date' => from_date($ds->from_date),
        'to_date' => to_date($ds->to_date),
        'status' => $ds->status,
        'order_by' => $ds->order_by
      );

      $res = $this->sales_report_model->get_sales_invoice_report($arr);

      if( ! empty($res))
      {
        $totalBefVat = 0;
        $totalNonVat = 0;
        $totalVat = 0;
        $totalAmount = 0;
        $no = 1;

        foreach($res as $rs)
        {
          $sumVatable = $this->sales_report_model->get_sum_vatable_amount($rs->code);
          $sumNonVat = $this->sales_report_model->get_sum_non_vat_amount($rs->code);
          $amountBefVat = $sumVatable - $rs->vat_amount;

          $result[] = array(
            'no' => $no,
            'doc_date' => thai_date($rs->doc_date),
            'code' => $rs->code,
            'status' => $rs->status == 2 ? 'Cancel' : 'OK',
            'reference' => $rs->reference,
            'customer_name' => $rs->customer_name,
            'tax_id' => $rs->tax_id,
            'branch_name' => $rs->branch_name,
            'amountBefVat' => number($amountBefVat, 2),
            'vatAmount' => number($rs->vat_amount, 2),
            'nonVatAmount' => number($sumNonVat, 2),
            'lineTotal' => number($rs->total_amount, 2)
          );

          $totalBefVat += $amountBefVat;
          $totalNonVat += $sumNonVat;
          $totalVat += $rs->vat_amount;
          $totalAmount += $rs->total_amount;
          $no++;
        }

        $result[] = array(
          'totalBefVat' => number($totalBefVat, 2),
          'totalNonVat' => number($totalNonVat, 2),
          'vatTotal' => number($totalVat, 2),
          'docTotal' => number($totalAmount, 2)
        );
      }
      else
      {
        $result[] = ["nodata" => "nodata"];
      }
    }
    else
    {
      $sc = FALSE;
      $this->error = get_error_message('required');
    }

    echo json_encode($result);
  }


  public function do_export()
  {
		$token = $this->input->post('token');
    $from_date = db_date($this->input->post('fromDate'));
    $to_date = db_date($this->input->post('toDate'));
    $status = $this->input->post('status');
    $order_by = $this->input->post('orderBy');

    //---  Report title
    $report_title = 'รายงานยอดขาย แยกตามสินค้า';
    $date_title = 'วันที่ : '.thai_date($from_date, FALSE, '/').' - '.thai_date($to_date, FALSE, '/');

    //--- load excel library
    $this->load->library('excel');

    $this->excel->setActiveSheetIndex(0);
    $this->excel->getActiveSheet()->setTitle('Invoice Summary');

    //--- set report title header
    $this->excel->getActiveSheet()->setCellValue('A1', $report_title);
    $this->excel->getActiveSheet()->mergeCells('A1:L1');
    $this->excel->getActiveSheet()->setCellValue('A2', $date_title);
    $this->excel->getActiveSheet()->mergeCells('A2:L2');

    //--- set Table header
    $this->excel->getActiveSheet()->setCellValue('A4', '#');
    $this->excel->getActiveSheet()->setCellValue('B4', 'ว/ด/ป');
    $this->excel->getActiveSheet()->setCellValue('C4', 'เลขที่ Invoice');
    $this->excel->getActiveSheet()->setCellValue('D4', 'สถานะ');
    $this->excel->getActiveSheet()->setCellValue('E4', 'เลขที่ Order');
    $this->excel->getActiveSheet()->setCellValue('F4', 'ชื่อลูกค้า');
    $this->excel->getActiveSheet()->setCellValue('G4', 'Tax ID');
    $this->excel->getActiveSheet()->setCellValue('H4', 'สาขา');
    $this->excel->getActiveSheet()->setCellValue('I4', 'สินค้ามี VAT (ยอดก่อน VAT)');
    $this->excel->getActiveSheet()->setCellValue('J4', 'VAT');
    $this->excel->getActiveSheet()->setCellValue('K4', 'สินค้า Non-VAT');
    $this->excel->getActiveSheet()->setCellValue('L4', 'มูลค่ารวม');

    $row = 5;

    $arr = array(
      'from_date' => from_date($from_date),
      'to_date' => to_date($to_date),
      'status' => $status,
      'order_by' => $order_by
    );

    $res = $this->sales_report_model->get_sales_invoice_report($arr);


    if( ! empty($res))
    {
      $no = 1;

      foreach($res as $rs)
      {
        $sumVatable = $this->sales_report_model->get_sum_vatable_amount($rs->code);
        $sumNonVat = $this->sales_report_model->get_sum_non_vat_amount($rs->code);
        $amountBefVat = $sumVatable - $rs->vat_amount;

        $this->excel->getActiveSheet()->setCellValue('A'.$row, $no);
        $this->excel->getActiveSheet()->setCellValue('B'.$row, thai_date($rs->doc_date, FALSE, '-'));
        $this->excel->getActiveSheet()->setCellValue('C'.$row, $rs->code);
        $this->excel->getActiveSheet()->setCellValue('D'.$row, $rs->status == 2 ? 'Cancel' : 'OK');
        $this->excel->getActiveSheet()->setCellValue('E'.$row, $rs->reference);
        $this->excel->getActiveSheet()->setCellValue('F'.$row, $rs->customer_name);
        $this->excel->getActiveSheet()->setCellValue('G'.$row, $rs->tax_id);
        $this->excel->getActiveSheet()->setCellValue('H'.$row, $rs->branch_name);
        $this->excel->getActiveSheet()->setCellValue('I'.$row, $amountBefVat);
        $this->excel->getActiveSheet()->setCellValue('J'.$row, $rs->vat_amount);
        $this->excel->getActiveSheet()->setCellValue('K'.$row, $sumNonVat);
        $this->excel->getActiveSheet()->setCellValue('L'.$row, $rs->total_amount);

        $no++;
        $row++;
      }

      $re = $row - 1;

      $this->excel->getActiveSheet()->setCellValue('A'.$row, 'รวม');
      $this->excel->getActiveSheet()->mergeCells("A{$row}:H{$row}");
      $this->excel->getActiveSheet()->setCellValue("I{$row}", "=SUM(I5:I{$re})");
      $this->excel->getActiveSheet()->setCellValue("J{$row}", "=SUM(J5:J{$re})");
      $this->excel->getActiveSheet()->setCellValue("K{$row}", "=SUM(K5:K{$re})");
      $this->excel->getActiveSheet()->setCellValue("L{$row}", "=SUM(L5:L{$re})");

      $this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setHorizontal('right');
      $this->excel->getActiveSheet()->getStyle("I5:L{$row}")->getAlignment()->setHorizontal('right');
      $this->excel->getActiveSheet()->getStyle("I5:L{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
    }

		setToken($token);
    $file_name = "Report Invoice Summary.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); /// form excel 2007 XLSX
    header('Content-Disposition: attachment;filename="'.$file_name.'"');
    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    $writer->save('php://output');

  }


} //--- end class








 ?>
