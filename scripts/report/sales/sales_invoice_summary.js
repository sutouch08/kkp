var HOME = BASE_URL + 'report/sales/sales_invoice_summary/';

$("#fromDate").datepicker({
	dateFormat: 'dd-mm-yy',
	onClose: function(ds){
		$("#toDate").datepicker("option", "minDate", ds);
	}
});

$("#toDate").datepicker({
	dateFormat: 'dd-mm-yy',
	onClose: function(ds){
		$("#fromDate").datepicker("option", "maxDate", ds);
	}
});



function getReport() {
  let h = {
    'from_date' : $('#fromDate').val().trim(),
    'to_date' : $('#toDate').val().trim(),
    'status' : $('#status').val(),
    'order_by' : $('#orderBy').val()
  };

  if( ! isDate(h.from_date) || ! isDate(h.to_date)) {
    showError("วันที่ไม่ถูกต้อง");
    return false;
  }

  load_in();

  $.ajax({
    url:HOME + 'get_report',
    type:'GET',
    cache:'false',
    data:{
      'data' : JSON.stringify(h)
    },
    success:function(rs) {
      load_out();

      if(isJson(rs)) {
        let source = $('#template').html();
        let data = JSON.parse(rs);
        let output = $('#result-table');
        render(source,  data, output);
      }
      else {
        showError(rs);
      }
    },
    error:function(rs) {
      showError(rs);
    }
  });

}


function doExport() {
	let h = {
    'from_date' : $('#fromDate').val().trim(),
    'to_date' : $('#toDate').val().trim(),
    'status' : $('#status').val(),
    'order_by' : $('#orderBy').val()
  };

	let token = generateUID();

	$('#token').val(token);

  if( ! isDate(h.from_date) || ! isDate(h.to_date)) {
    showError("วันที่ไม่ถูกต้อง");
    return false;
  }

	get_download(token);

  $('#reportForm').submit();
}
