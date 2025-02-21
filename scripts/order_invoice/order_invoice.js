var HOME = BASE_URL + 'orders/order_invoice/';

function goBack() {
	window.location.href = HOME;
}

function addNew() {
	window.location.href = HOME + 'add_new';
}


function goEdit(code) {
	window.location.href = HOME + 'edit/'+code;
}


function view_detail(code) {
	window.location.href = HOME + 'view_detail/'+code;
}


function getDelete(code) {
	if(code === undefined){
		var code = $('#code').val();
	}

	swal({
		title:'คุณแน่ใจ ?',
		text:'ต้องการยกเลิก '+code+' หรือไม่?',
		type:'warning',
		showCancelButton:true,
		confirmButtonColor:'#DD6B55',
		confirmButtonText:'ใช่ ต้องการยกเลิก',
		cancelButtonText:'ไม่ใช่',
		closeOnConfirm:false
	},
	function() {
		load_in();
		$.ajax({
			url:HOME + 'cancle_invoice',
			type:'POST',
			cache:false,
			data:{
				'code' : code
			},
			success:function(rs) {
				load_out();
				var rs = $.trim(rs);
				if(rs === 'success') {
					swal({
						title:'Deleted',
						type:'success',
						timer:1000
					});

					setTimeout(function() {
						window.location.reload();
					},1200);
				}
				else {
					load_out();
					swal({
						title:'Error!',
						text:rs,
						type:'error'
					});
				}
			},
			error:function(xhr, status, error) {
				load_out();
				var errorMessage = xhr.status + ': '+xhr.statusText;
				swal({
					title:'Error!',
					text:'Error-'+errorMessage,
					type:'error'
				});
			}
		})
	});
}


function printSelectedInvoice(option) {
	var data = [];
	var url = '';

	$('.chk').each(function() {
		if($(this).is(':checked')) {
			data.push($(this).val());
		}
	});

	if(option == 'tax') {
		url = BASE_URL + "orders/order_invoice/print_selected_tax_invoice";
	}
	else {
		url = BASE_URL + "orders/order_invoice/print_selected_do_invoice";
	}

	if(data.length) {

			var mapForm = document.createElement("form");
		 mapForm.target = "Map";
		 mapForm.method = "POST";
		 mapForm.action = url;

		 var mapInput = document.createElement("input");
		 mapInput.type = "text";
		 mapInput.name = "data";
		 mapInput.value = data;
		 mapForm.appendChild(mapInput);

		 document.body.appendChild(mapForm);

		 var center = ($(document).width() - 800)/2;
		 var prop = "width=800, height=900, left="+center+", scrollbars=yes";

		 map = window.open("", "Map", prop);

			if (map) {

				 mapForm.submit();
			}
			else {
				 alert('You must allow popups for this map to work.');
			}
	}
}


function print_postal_slip() {
	let width = 800;
	let center = ($(document).width() - width)/2;
	let prop = "width="+width+", height=900, left="+center+", scrollbars=yes";
	let code = $('#code').val().trim();
	let target = HOME + 'print_postal_slip/'+code;
	window.open(target, '_blank', prop);
}


function print_invoice() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_invoice/'+code;
  window.open(target, '_blank', prop);
}

function clearFilter() {
	$.get(HOME+'clear_filter', function() {
		goBack();
	});
}


function print_do_invoice() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_do_invoice/'+code;
  window.open(target, '_blank', prop);
}

function print_do_receipt() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_do_receipt/'+code;
  window.open(target, '_blank', prop);
}

function print_tax_receipt() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_tax_receipt/'+code;
  window.open(target, '_blank', prop);
}


function print_tax_invoice() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_tax_invoice/'+code;
  window.open(target, '_blank', prop);
}


function print_tax_billing_note() {
	//--- properties for print
	var center = ($(document).width() - 800)/2;
	var prop = "width=800, height=900, left="+center+", scrollbars=yes";
	var code = $('#code').val();
	var target  = HOME + 'print_tax_billing_note/'+code;
  window.open(target, '_blank', prop);
}

$('#from_date').datepicker({
	dateFormat:'dd-mm-yy',
	onClose:function(sd) {
		$('#to_date').datepicker('option', 'minDate', sd);
	}
})

$('#to_date').datepicker({
	dateFormat:'dd-mm-yy',
	onClose:function(sd) {
		$('#from_date').datepicker('option', 'maxDate', sd);
	}
})


$('#doc_date').datepicker({
	dateFormat:'dd-mm-yy'
});


$('#customer_code').autocomplete({
	source:BASE_URL + 'auto_complete/get_customer_code_and_name',
	autoFocus:true,
	close:function() {
		var rs = $(this).val();
		var arr = rs.split(' | ');
		if(arr.length == 2) {
			let code = arr[0];
			let name = arr[1];
			$('#customerCode').val(code); //--- for check with customer
			$('#customer_code').val(code);
			$('#customer-name').val(name);

			get_customer_bill_to_address(code);
		}
		else {
			$('#customerCode').val('');
			$('#customer_code').val('');
			$('#customer-name').val('');
		}
	}
})


function get_customer_bill_to_address(code) {
	load_in();

	$.ajax({
		url:HOME + 'get_customer_bill_to_address',
		type:'POST',
		cache:false,
		data:{
			'customer_code' : code
		},
		success:function(rs) {
			load_out();

			if(isJson(rs)) {
				let ds = JSON.parse(rs);

				if(ds.status == 'success') {
					let adr = ds.bill_to;

					if(adr != null) {
						$('#customer-name').val(adr.name);
						$('#tax-id').val(adr.tax_id);
						$('#branch-code').val(adr.branch_code);
						$('#branch-name').val(adr.branch_name);
						$('#address').val(adr.address);
						$('#sub-district').val(adr.sub_district);
						$('#district').val(adr.district);
						$('#province').val(adr.province);
						$('#postcode').val(adr.postcode);
						$('#phone').val(adr.phone);
					}
					else {
						$('#tax-id').val('');
						$('#branch-code').val('');
						$('#branch-name').val('');
						$('#address').val('');
						$('#sub-district').val('');
						$('#district').val('');
						$('#province').val('');
						$('#postcode').val('');
						$('#phone').val('');
					}
				}
				else {
					showError(ds.message);
				}
			}
			else {
				showError(rs);
			}
		},
		error:function(rs) {
			load_out();
			showError(rs);
		}
	})
}


function toggleFormBranch() {
	if($('#form-is-company').is(':checked')) {
		$('#form-branch-code').val('00000');
		$('#form-branch-name').val('สำนักงานใหญ่');
	}
	else {
		$('#form-branch-code').val('');
		$('#form-branch-name').val('');
	}
}


function toggleBranch() {
	let bCode = $('#branch-code').val();

	if($('#is-company').is(':checked')) {
		if(bCode.length == 0) {
			$('#branch-code').val('00000');
			$('#branch-name').val('สำนักงานใหญ่');
		}
	}
	else {
		$('#branch-code').val('');
		$('#branch-name').val('');
	}
}


function showCustomerModal() {
	$('#customerModal').modal('show');
	$('#customerModal').on('shown.bs.modal', () => {
		$('#tax-search').focus();
	})
}

$('#tax-search').autocomplete({
	source:BASE_URL + 'auto_complete/get_invoice_customer',
	autoFocus:true,
	open:function(event) {
		let ul = $(this).autocomplete('widget');
		ul.css('width', 'auto');
	},
	select:function(event, ui) {
		$('#cust-id').val(ui.item.id);
		$('#form-name').val(ui.item.name);
		$('#form-tax-id').val(ui.item.tax_id);
		$('#form-branch-code').val(ui.item.branch_code);
		$('#form-branch-name').val(ui.item.branch_name);
		$('#form-address').val(ui.item.address);
		$('#form-sub-district').val(ui.item.sub_district);
		$('#form-district').val(ui.item.district);
		$('#form-province').val(ui.item.province);
		$('#form-postcode').val(ui.item.postcode);
		$('#form-phone').val(ui.item.phone);

		if(ui.item.is_company == '1') {
			$('#form-is-company').prop('checked', true);
		}
		else {
			$('#form-is-company').prop('checked', false);
		}
	},
	close:function() {
		let arr = $(this).val().split(' | ');
		$(this).val(arr[0]);
	}
})

function newCustomer() {
	let taxId = $('#tax-search').val();
	$('.cust-form').removeAttr('disabled');
	$('#form-tax-id').val(taxId);
	$('#cust-id').val('');
	$('#form-name').focus();
}


function addCustomer() {
	$('.cust-form').removeClass('has-error');

	let h = {
		'customer_id' : $('#cust-id').val(),
		'customer_name' : $.trim($('#form-name').val()),
		'tax_id' : $('#form-tax-id').val(),
		'branch_code' : $.trim($('#form-branch-code').val()),
		'branch_name' : $.trim($('#form-branch-name').val()),
		'address' : $.trim($('#form-address').val()),
		'sub_district' : $.trim($('#form-sub-district').val()),
		'district' : $.trim($('#form-district').val()),
		'province' : $.trim($('#form-province').val()),
		'postcode' : $.trim($('#form-postcode').val()),
		'phone' : $.trim($('#form-phone').val()),
		'is_company' : $('#form-is-company').is(':checked') ? 1 : 0
	};

	if(h.customer_name.length == 0) {
		$('#form-name').addClass('has-error');
		return false;
	}

	if(h.tax_id.length < 13) {
		$('#form-tax-id').addClass('has-error');
		return false;
	}

	if(h.is_company && (h.branch_code.length == 0 || h.branch_name.length == 0)) {
		if(h.branch_code.length == 0) {
			$('#form-branch-code').addClass('has-error');
		}

		if(h.branch_name.length == 0) {
			$('#form-branch-name').addClass('has-error');
		}

		return false;
	}

	if(h.address.length == 0) {
		$('#form-address').addClass('has-error');
		return false;
	}

	$('#customerModal').modal('hide');

	load_in();

	$.ajax({
		url:HOME + 'add_invoice_customer',
		type:'POST',
		cache:false,
		data:{
			"data" : JSON.stringify(h)
		},
		success:function(rs) {
			load_out();

			if(isJson(rs)) {
				let ds = JSON.parse(rs);

				if(ds.status == 'success') {
					addToBill();
				}
				else {
					message = '<h4 class="title-xs red text-center">'+ds.message+'</h4>';
					$('#cust-result-table').html(message);
					$('.cust-form').val('').attr('disabled', 'disabled');
					$('#tax-search').focus();
				}
			}
			else {
				message = '<h4 class="title-xs red text-center">'+rs+'</h4>';
				$('#cust-result-table').html(message);
				$('#tax-search').focus();
			}
		}
	})
}


function addToBill() {
	$('.cust-form').removeClass('has-error');

	let h = {
		'customer_id' : $('#cust-id').val(),
		'customer_name' : $.trim($('#form-name').val()),
		'tax_id' : $('#form-tax-id').val(),
		'branch_code' : $.trim($('#form-branch-code').val()),
		'branch_name' : $.trim($('#form-branch-name').val()),
		'address' : $.trim($('#form-address').val()),
		'sub_district' : $.trim($('#form-sub-district').val()),
		'district' : $.trim($('#form-district').val()),
		'province' : $.trim($('#form-province').val()),
		'postcode' : $.trim($('#form-postcode').val()),
		'phone' : $.trim($('#form-phone').val()),
		'is_company' : $('#form-is-company').is(':checked') ? 1 : 0
	};

	if(h.customer_name.length == 0) {
		$('#form-name').addClass('has-error');
		return false;
	}

	if(h.tax_id.length < 10) {
		$('#form-tax-id').addClass('has-error');
		return false;
	}

	if(h.is_company && (h.branch_code.length == 0 || h.branch_name.length == 0)) {
		if(h.branch_code.length == 0) {
			$('#form-branch-code').addClass('has-error');
		}

		if(h.branch_name.length == 0) {
			$('#form-branch-name').addClass('has-error');
		}

		return false;
	}

	if(h.address.length == 0) {
		$('#form-address').addClass('has-error');
		return false;
	}

	$('#customerModal').modal('hide');

	$('#customer-name').val(h.customer_name);
	$('#tax-id').val(h.tax_id);
	$('#branch-code').val(h.branch_code);
	$('#branch-name').val(h.branch_name);
	$('#address').val(h.address);
	$('#sub-district').val(h.sub_district);
	$('#district').val(h.district);
	$('#province').val(h.province);
	$('#postcode').val(h.postcode);
	$('#phone').val(h.phone);

	if(h.is_company) {
		$('#is-company').prop('checked', true);
	}
	else {
		$('#is-company').prop('checked', false);
	}
}


function clearForm() {
	$('.cust-form').val('');
}

function parseAddress(address, subDistrict, district, province, postcode) {
	let addr = address;

	if(subDistrict != "" || subDistrict != null || subDistrict != undefined) {
		addr = addr + " ต. " + subDistrict;
	}

	if(district != "" || disctrict != null || district != undefined) {
		addr = addr + " อ. " + district;
	}

	if(province != "" || province != null || province != undefined) {
		addr = addr + " จ. " + province;
	}

	if(postcode != "" || postcode != null || postcode != undefined) {
		addr = addr + " " +postcode;
	}

	return addr;
}


$('#form-name').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#form-tax-id').focus();
	}
});

$('#form-tax-id').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#form-branch-code').focus();
	}
});

$('#form-branch-code').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#form-branch-name').focus();
	}
});

$('#form-branch-name').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#address').focus();
	}
});

$('#form-address').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#phone').focus();
	}
});

$('#form-phone').keyup(function(e) {
	if(e.keyCode == 13) {
		$('#form-is-company').focus();
	}
});

function add() {
	$('.e').removeClass('has-error');

	let h = {
		'doc_date' : $('#doc_date').val(),
		'vat_type' : $('#vat_type').val(),
		'customerCode' : $('#customerCode').val().trim(),
		'customer_code' : $('#customer_code').val().trim(),
		'customer_name' : $('#customer-name').val().trim(),
		'tax_id' : $('#tax-id').val().trim(),
		'is_company' : $('#is-company').is(':checked') ? 1 : 0,
		'branch_code' : $('#branch-code').val().trim(),
		'branch_name' : $('#branch-name').val().trim(),
		'address' : $('#address').val().trim(),
		'sub_district' : $('#sub-district').val().trim(),
		'district' : $('#district').val().trim(),
		'province' : $('#province').val().trim(),
		'postcode' : $('#postcode').val().trim(),
		'phone' : $('#phone').val().trim()
	};

	if(h.customer_code.length == 0 || h.customer_code != h.customerCode) {
		$('#customer_code').hasError();
		return false;
	}

	if(h.customer_name.length == 0) {
		$('#customer-name').hasError();
		return false;
	}

	if(h.tax_id.length != 13) {
		$('#tax-id').hasError();
		return false;
	}

	if(h.is_company == 1 && (h.branch_code.length == 0 || h.branch_name.length == 0)) {
		$('#branch-code').hasError();
		$('#branch-name').hasError();
		return false;
	}

	if(h.branch_code.length > 0 && h.branch_name.length == 0) {
		$('#branch-name').hasError();
		return false;
	}

	if(h.address.length == 0) {
		$('#address').hasError();
		return false;
	}

	if(h.sub_district.length == 0) {
		$('#sub-district').hasError();
		return false;
	}

	if(h.district.length == 0) {
		$('#district').hasError();
		return false;
	}

	if(h.province.length == 0) {
		$('#province').hasError();
		return false;
	}

	load_in();

	$.ajax({
		url:HOME + 'add',
		type:'POST',
		cache:false,
		data:{
			"data" : JSON.stringify(h)
		},
		success:function(rs) {
			load_out();

			if(isJson(rs)) {
				let ds = JSON.parse(rs);

				if(ds.status === 'success') {
					goEdit(ds.code);
				}
				else {
					showError(ds.message);
				}
			}
			else {
				showError(rs);
			}
		},
		error:function(rs) {
			load_out();
			showError(rs);
		}
	})
}


function getEdit(){
	$('.edit').removeAttr('disabled');
	$('#btn-edit').addClass('hide');
	$('#btn-update').removeClass('hide');
}


function updateHeader() {
	$('.e').removeClass('has-error');

	let h = {
		'code' : $('#code').val().trim(),
		'doc_date' : $('#doc_date').val(),
		'vat_type' : $('#vat_type').val(),
		'customerCode' : $('#customerCode').val().trim(),
		'customer_code' : $('#customer_code').val().trim(),
		'customer_name' : $('#customer-name').val().trim(),
		'contact_person' : $('#contact').val().trim(),
		'tax_id' : $('#tax-id').val().trim(),
		'is_company' : $('#is-company').is(':checked') ? 1 : 0,
		'branch_code' : $('#branch-code').val().trim(),
		'branch_name' : $('#branch-name').val().trim(),
		'address' : $('#address').val().trim(),
		'sub_district' : $('#sub-district').val().trim(),
		'district' : $('#district').val().trim(),
		'province' : $('#province').val().trim(),
		'postcode' : $('#postcode').val().trim(),
		'phone' : $('#phone').val().trim()
	};

	let original_customer = $('#customer_code').data('code');

	if(h.customer_code.length == 0 || h.customer_code != h.customerCode) {
		$('#customer_code').hasError();
		return false;
	}

	if(h.customer_name.length == 0) {
		$('#customer-name').hasError();
		return false;
	}

	if(h.tax_id.length != 13) {
		$('#tax-id').hasError();
		return false;
	}

	if(h.is_company == 1 && (h.branch_code.length == 0 || h.branch_name.length == 0)) {
		$('#branch-code').hasError();
		$('#branch-name').hasError();
		return false;
	}

	if(h.branch_code.length > 0 && h.branch_name.length == 0) {
		$('#branch-name').hasError();
		return false;
	}

	if(h.address.length == 0) {
		$('#address').hasError();
		return false;
	}

	if(h.sub_district.length == 0) {
		$('#sub-district').hasError();
		return false;
	}

	if(h.district.length == 0) {
		$('#district').hasError();
		return false;
	}

	if(h.province.length == 0) {
		$('#province').hasError();
		return false;
	}


	if(h.customer_code != original_customer) {
		swal({
			title:'Warning !',
			text:'รหัสลูกค้าเปลียน รายการสินค้าจะถูกเคลียร์<br/>ต้องการดำเนินการต่อหรือไม่ ?',
			type:'warning',
			html:true,
			showCancelButton:true,
			confirmButtonText:'Yes',
			cancelButtonText:'No',
			closeOnConfirm:true
		},function() {
			update();
		});
	}
	else {
		update();
	}
}


function update() {
	$('.e').removeClass('has-error');

	let h = {
		'code' : $('#code').val().trim(),
		'doc_date' : $('#doc_date').val(),
		'vat_type' : $('#vat_type').val(),
		'customerCode' : $('#customerCode').val().trim(),
		'customer_code' : $('#customer_code').val().trim(),
		'customer_name' : $('#customer-name').val().trim(),
		'contact_person' : $('#contact').val().trim(),
		'tax_id' : $('#tax-id').val().trim(),
		'is_company' : $('#is-company').is(':checked') ? 1 : 0,
		'branch_code' : $('#branch-code').val().trim(),
		'branch_name' : $('#branch-name').val().trim(),
		'address' : $('#address').val().trim(),
		'sub_district' : $('#sub-district').val().trim(),
		'district' : $('#district').val().trim(),
		'province' : $('#province').val().trim(),
		'postcode' : $('#postcode').val().trim(),
		'phone' : $('#phone').val().trim()
	};

	let original_customer = $('#customer_code').data('code');

	if(h.customer_code.length == 0 || h.customer_code != h.customerCode) {
		$('#customer_code').hasError();
		return false;
	}

	if(h.customer_name.length == 0) {
		$('#customer-name').hasError();
		return false;
	}

	if(h.tax_id.length != 13) {
		$('#tax-id').hasError();
		return false;
	}

	if(h.is_company == 1 && (h.branch_code.length == 0 || h.branch_name.length == 0)) {
		$('#branch-code').hasError();
		$('#branch-name').hasError();
		return false;
	}

	if(h.branch_code.length > 0 && h.branch_name.length == 0) {
		$('#branch-name').hasError();
		return false;
	}

	if(h.address.length == 0) {
		$('#address').hasError();
		return false;
	}

	if(h.sub_district.length == 0) {
		$('#sub-district').hasError();
		return false;
	}

	if(h.district.length == 0) {
		$('#district').hasError();
		return false;
	}

	if(h.province.length == 0) {
		$('#province').hasError();
		return false;
	}

	load_in();

	$.ajax({
		url:HOME + 'update',
		type:'POST',
		cache:false,
		data:{
			"data" : JSON.stringify(h)
		},
		success:function(rs) {
			load_out();

			if(rs.trim() == 'success') {
				setTimeout(() => {
					swal({
						title:'Success',
						type:'success',
						timer:1000
					});

					setTimeout(() => {
						window.location.reload();
					}, 1200);
				}, 100);
			}
			else {
				setTimeout(() => {
					showError(rs);
				}, 100);
			}
		},
		error:function(rs) {
			load_out();
			setTimeout(() => {
				showError(rs);
			}, 100);
		}
	})
}


function updateRemark(code) {
	let remark = $('#remark').val().trim();

	$.ajax({
		url:HOME + 'update_remark',
		type:'POST',
		cache:false,
		data:{
			'code' : code,
			'remark' : remark
		},
		success:function(rs) {
			if(rs.trim() === 'success') {
				console.log(rs);
			}
			else {
				showError(rs);
			}
		},
		error:function(rs) {
			showError(rs);
		}
	})
}


function getSearch() {
	$('#searchForm').submit();
}
