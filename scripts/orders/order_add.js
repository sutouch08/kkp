$('#date').datepicker({
  dateFormat:'dd-mm-yy'
});


//---- เปลี่ยนสถานะออเดอร์  เป็นบันทึกแล้ว
function saveOrder(){
  var order_code = $('#order_code').val();
	$.ajax({
		url: BASE_URL + 'orders/orders/save/'+ order_code,
		type:"POST",
    cache:false,
		success:function(rs){
			var rs = $.trim(rs);
			if( rs == 'success' ){
				swal({
          title: 'Saved',
          type: 'success',
          timer: 1000
        });
				setTimeout(function(){ editOrder(order_code) }, 1200);
			}else{
				swal("Error ! ", rs , "error");
			}
		}
	});
}


function add() {
  clearErrorByClass('e');

  let h = {
    'date_add' : $('#date').val().trim(),
    'customer_code' : $('#customer').val().trim(),
    'customer_name' : $('#customer-name').val().trim(),
    'customer_ref' : $('#customer-ref').val().trim(),
    'reference' : $('#reference').val().trim(),
    'channels_code' : $('#channels').val(),
    'payment_code' : $('#payment').val(),
    'sender_id' : $('#sender_id').val(),
    'remark' : $('#remark').val().trim()
  };

  if( ! isDate(h.date_add)) {
    $('#date').hasError();
    return false;
  }

  if(h.customer_code.length == 0) {
    $('#customer').hasError();
    return false;
  }

  if(h.customer_name.length == 0) {
    $('#customer-name').hasError();
    return false;
  }

  if(h.channels_code == "") {
    $('#channels').hasError();
    return false;
  }

  if(h.payment_code == "") {
    $('#payment').hasError();
    return false;
  }

  $.ajax({
    url:HOME + 'add',
    type:'POST',
    cache:false,
    data:{
      'data' : JSON.stringify(h)
    },
    success:function(rs) {
      if(isJson(rs)) {
        let ds = JSON.parse(rs);

        if(ds.status = 'success') {
          window.location.href = HOME + 'edit_detail/'+ds.code;
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
      showError(rs);
    }
  })
}

function update_detail(id) {
	var c_qty = parseDefaultValue($('#current_qty_'+id).val(), 0, 'float');
	var qty = parseDefaultValue($('#qty_'+id).val(), 0, 'float');
	var price = parseDefaultValue($('#price_'+id).val(), 0, 'float');
	var discount = parseDiscount($('#disc_'+id).val(), price);
	var total_amount = parseDefaultValue($('#line_total_'+id).val(), 0, 'float');

	$.ajax({
		url:HOME + 'update_detail',
		type:'POST',
		cache:false,
		data:{
			'id' : id,
			'qty' : qty,
			'price' : price,
			'discount' : discount,
			'total_amount' : total_amount
		},
		success:function(rs) {
			var rs = $.trim(rs)
			if(rs == 'success') {
				$('#current_qty_'+id).val(qty);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});

				$('#qty_'+id).val(c_qty);
				recal(id);
			}
		}
	})

}


function update_shipping_fee()
{
	var order_code = $('#order_code').val();
	var fee = parseDefaultValue($('#shipping-box').val(), 0, 'float');
	var c_fee = $('#current_shipping_fee').val();

	$.ajax({
		url:HOME + 'update_shipping_fee',
		type:'POST',
		cache:false,
		data:{
			'code' : order_code,
			'fee' : fee
		},
		success:function(rs) {
			var rs = $.trim(rs);
			if(rs === 'success') {
				$('#current_shipping_fee').val(fee);
			}
			else {
				$('#shipping-box').val(c_fee);
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}

			recalTotal();
		}
	})
}



function update_service_fee()
{
	var order_code = $('#order_code').val();
	var fee = parseDefaultValue($('#service-box').val(), 0, 'float');
	var c_fee = $('#current_service_fee').val();

	$.ajax({
		url:HOME + 'update_service_fee',
		type:'POST',
		cache:false,
		data:{
			'code' : order_code,
			'fee' : fee
		},
		success:function(rs) {
			var rs = $.trim(rs);
			if(rs === 'success') {
				$('#current_service_fee').val(fee);
			}
			else {
				$('#service-box').val(c_fee);
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}

			recalTotal();
		}
	})
}



$("#customer").autocomplete({
	source: BASE_URL + 'auto_complete/get_customer_code_and_name',
	autoFocus: true,
	close: function(){
		var rs = $.trim($(this).val());
		var arr = rs.split(' | ');
		if( arr.length == 2 ){
			var code = arr[0];
			var name = arr[1];
			$(this).val(code);
			$("#customer-name").val(name);
		}
    else {
			$('#customer-name').val('');
			$(this).val('');
		}
	}
});


$('#qt_no').autocomplete({
	source:BASE_URL + 'auto_complete/get_quotation',
	autoFocus:true,
	close:function(){
		let rs = $(this).val().split(' | ');
		if(rs.length === 2){
			let code = rs[0];
			let name = rs[1];
			$(this).val(code);
		}
	}
});


function getEdit(){
  $('.edit').removeAttr('disabled');
  $('#btn-edit').addClass('hide');
  $('#btn-update').removeClass('hide');
}

function editRemark() {
	$('#sender_id').removeAttr('disabled');
	$('#remark').removeAttr('disabled');
	$('#btn-edit').addClass('hide');
	$('#btn-update').removeClass('hide');
	$('#remark').focus();
}

function updateRemark() {
	var order_code = $('#order_code').val();
	var sender_id = $('#sender_id').val();
	var remark = $.trim($('#remark').val());

	load_in();
	$.ajax({
		url:BASE_URL + 'orders/orders/update_remark',
		type:'POST',
		cache:false,
		data:{
			'code' : order_code,
			'sender_id' : sender_id,
			'remark' : remark
		},
		success:function(rs) {
			load_out();
			var rs = $.trim(rs);
			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});

				$('#remark').attr('disabled', 'disabled');
				$('#btn-update').addClass('hide');
				$('#btn-edit').removeClass('hide');
			}
			else {
				swal({
					title:'Error',
					text:rs,
					type:'error'
				})
			}
		}
	})
}


//---- เพิ่มรายการสินค้าเช้าออเดอร์
function addToOrder(){
  var order_code = $('#order_code').val();
	//var count = countInput();
  var data = [];
  $(".order-grid").each(function(index, element){
    if($(this).val() != ''){
      var code = $(this).attr('id');
      data.push({'code' : code, 'qty' : $(this).val()});
    }
  });

	if(data.length > 0 ){
		$("#orderGrid").modal('hide');
		$("#orderItemGrid").modal('hide');
		$.ajax({
			url: BASE_URL + 'orders/orders/add_detail/'+order_code,
			type:"POST",
      cache:"false",
      data: {
        'data' : data
      },
			success: function(rs){
				load_out();
				var rs = $.trim(rs);
				if( rs == 'success' ){
					swal({
            title: 'success',
            type: 'success',
            timer: 1000
          });
					$("#btn-save-order").removeClass('hide');
					updateDetailTable(); //--- update list of order detail
				}else{
					swal("Error", rs, "error");
				}
			}
		});
	}
}





//---- เพิ่มรายการสินค้าเช้าออเดอร์
function addItemToOrder(){
	var orderCode = $('#order_code').val();
	var qty = parseDefault(parseInt($('#input-qty').val()), 0);
	var limit = parseDefault(parseInt($('#stock-qty').val()), 0);
	var itemCode = $('#item-code').val();
  var data = [{'code':itemCode, 'qty' : qty}];
  var auz = $('#auz').val();

	if(qty > 0 && (qty <= limit || auz > 0)){
		load_in();
		$.ajax({
			url:BASE_URL + 'orders/orders/add_detail/'+orderCode,
			type:"POST",
			cache:"false",
			data:{
				'data' : data
			},
			success: function(rs){
				load_out();
				var rs = $.trim(rs);
				if( rs == 'success' ){
					swal({
						title: 'success',
						type: 'success',
						timer: 1000
					});

					$("#btn-save-order").removeClass('hide');
					updateDetailTable(); //--- update list of order detail

					setTimeout(function(){
						$('#item-code').val('');
						$('#stock-qty').val('');
						$('#input-qty').val('');
						$('#item-code').focus();
					},1200);


				}else{
					swal("Error", rs, "error");
				}
			}
		});
	}
}


// JavaScript Document
function updateDetailTable(){
	var order_code = $("#order_code").val();
	$.ajax({
		url: BASE_URL + 'orders/orders/get_detail_table/'+order_code,
		type:"GET",
    cache:"false",
		success: function(rs){
			if( isJson(rs) ){
				var source = $("#detail-table-template").html();
				var data = $.parseJSON(rs);
				var output = $("#detail-table");
				render(source, data, output);

				percent_init();
				digit_init();
			}
			else
			{
				var source = $("#nodata-template").html();
				var data = [];
				var output = $("#detail-table");
				render(source, data, output);
				percent_init();
				digit_init();
			}
		}
	});
}



function removeDetail(id, name){
	swal({
		title: "คุณแน่ใจ ?",
		text: "ต้องการลบ '" + name + "' หรือไม่ ?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: 'ใช่, ฉันต้องการลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: false
		}, function(){
			$.ajax({
				url: BASE_URL + 'orders/orders/remove_detail/'+ id,
				type:"POST",
        cache:"false",
				success: function(rs){
					var rs = $.trim(rs);
					if( rs == 'success' ){
						swal({ title: 'Deleted', type: 'success', timer: 1000 });
						updateDetailTable();
					}else{
						swal("Error !", rs , "error");
					}
				}
			});
	});
}




$("#pd-box").autocomplete({
	source: BASE_URL + 'auto_complete/get_style_code_and_name',
	autoFocus: true,
	open:function(event){
		var $ul = $(this).autocomplete('widget');
		$ul.css('width', 'auto');
	},
	close:function() {
		var rs = $(this).val();
		var arr = rs.split(' | ');
		if(arr.length == 2) {
			$(this).val(arr[0]);
		}
		else {
			$(this).val('');
		}
	}
});




$('#pd-box').keyup(function(event) {
	if(event.keyCode == 13){
		var code = $(this).val();
		if(code.length > 0){
			setTimeout(function(){
				getProductGrid();
			}, 300);

		}
	}

});



$('#item-code').autocomplete({
	source:BASE_URL + 'auto_complete/get_active_item_code_and_name',
	autoFocus:true,
	open:function(event){
		var $ul = $(this).autocomplete('widget');
		$ul.css('width', 'auto');
	},
	close:function(){
		var rs = $(this).val();
		var arr = rs.split(' | ');

		if(arr.length === 2) {
			$(this).val(arr[0]);
			setTimeout(function(){
				getItemGrid();
			}, 200);
		}
		else {
			$(this).val('');
		}
	}
});



$('#item-code').keyup(function(e){
	if(e.keyCode == 13){
		var code = $(this).val();
		if(code.length > 4){
			setTimeout(function(){
				getItemGrid();
			}, 200);
		}
	}
});


$('#input-qty').keyup(function(e){
	if(e.keyCode == 13){
		addItemToOrder();
	}
});


//--- ตรวจสอบจำนวนที่คีย์สั่งใน order grid
function countInput(){
	var qty = 0;
	$(".order-grid").each(function(index, element) {
        if( $(this).val() != '' ){
			qty++;
		}
    });
	return qty;
}



function validUpdate() {
  clearErrorByClass('e');

  let prev_customer = $('#customer-code').val();
  let prev_channels = $('#channels_code').val();
  let prev_payment = $('#payment_code').val();
  let prev_date = $('#date_add').val();
  let recal = 0;

  let h = {
    'date_add' : $('#date').val().trim(),
    'customer_code' : $('#customer').val().trim(),
    'customer_name' : $('#customer-name').val().trim(),
    'channels_code' : $('#channels').val(),
    'payment_code' : $('#payment').val()
  };

  if( ! isDate(h.date_add)) {
    $('#date').hasError();
    return false;
  }

  if(h.customer_code.length == 0) {
    $('#customer').hasError();
    return false;
  }

  if(h.customer_name.length == 0) {
    $('#customer-name').hasError();
    return false;
  }

  if(h.channels_code == "") {
    $('#channels').hasError();
    return false;
  }

  if(h.payment_code == "") {
    $('#payment').hasError();
    return false;
  }

	//--- ตรวจสอบความเปลี่ยนแปลงที่สำคัญ
	if( (h.date_add != prev_date) || ( h.customer_code != prev_customer ) || ( h.channels_code != prev_channels ) || ( h.payment_code != prev_payment ) )
  {
		recal = 1; //--- ระบุว่าต้องคำนวณส่วนลดใหม่
	}

  updateOrder(recal);
}


function updateOrder(recal) {
  clearErrorByClass('e');

  let h = {
    'code' : $('#order_code').val().trim(),
    'date_add' : $('#date').val().trim(),
    'customer_code' : $('#customer').val().trim(),
    'customer_name' : $('#customer-name').val().trim(),
    'customer_ref' : $('#customer_ref').val().trim(),
    'reference' : $('#reference').val().trim(),
    'channels_code' : $('#channels').val(),
    'payment_code' : $('#payment').val(),
    'sender_id' : $('#sender_id').val(),
    'shipping_code' : $('#shipping_code').val().trim(),
    'remark' : $('#remark').val().trim(),
    'recal' : recal
  };

  if( ! isDate(h.date_add)) {
    $('#date').hasError();
    return false;
  }

  if(h.customer_code.length == 0) {
    $('#customer').hasError();
    return false;
  }

  if(h.customer_name.length == 0) {
    $('#customer-name').hasError();
    return false;
  }

  if(h.channels_code == "") {
    $('#channels').hasError();
    return false;
  }

  if(h.payment_code == "") {
    $('#payment').hasError();
    return false;
  }

	load_in();

	$.ajax({
		url:BASE_URL + 'orders/orders/update_order',
		type:"POST",
		cache:"false",
		data:{
      "data" : JSON.stringify(h)
    },
		success: function(rs) {
			load_out();

			if( rs.trim() == 'success' ){
				swal({
          title: 'Done !',
          type: 'success',
          timer: 1000
        });

				setTimeout(function(){
          window.location.reload();
        }, 1200);

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


function recal_discount_rule() {
	updateOrder(1);
}


// JavaScript Document
function changeState(){
    var order_code = $("#order_code").val();
    var state = $("#stateList").val();
    if( state != 0){
      load_in();
        $.ajax({
            url:BASE_URL + 'orders/orders/order_state_change',
            type:"POST",
            cache:"false",
            data:{
              "order_code" : order_code,
              "state" : state
            },
            success:function(rs){
              load_out();
                var rs = $.trim(rs);
                if(rs == 'success'){
                    swal({
                      title:'success',
                      text:'status updated',
                      type:'success',
                      timer: 1000
                    });

                    setTimeout(function(){
                      window.location.reload();
                    }, 1500);

                }else{
                    swal("Error !", rs, "error");
                }
            }
        });
    }
}



function setNotExpire(option){
  var order_code = $('#order_code').val();
  load_in();
  $.ajax({
    url:BASE_URL + 'orders/orders/set_never_expire',
    type:'POST',
    cache:'false',
    data:{
      'order_code' : order_code,
      'option' : option
    },
    success:function(rs){
      load_out();
      var rs = $.trim(rs);
      if(rs == 'success'){
        swal({
          title:'Success',
          type:'success',
          timer: 1000
        });

        setTimeout(function(){
          window.location.reload();
        },1500);
      }else{
        swal('Error', rs, 'error');
      }
    }
  });
}

function unExpired(){
  var order_code = $('#order_code').val();
  load_in();
  $.ajax({
    url:BASE_URL + 'orders/orders/un_expired',
    type:'GET',
    cache:'false',
    data:{
      'order_code' : order_code
    },
    success:function(rs){
      load_out();
      var rs = $.trim(rs);
      if(rs == 'success'){
        swal({
          title:'Success',
          type:'success',
          timer: 1000
        });

        setTimeout(function(){
          window.location.reload();
        },1500);
      }else{
        swal('Error', rs, 'error');
      }
    }
  });
}


function paid_order(){
  var code = $('#order_code').val();
  load_in();
  $.ajax({
    url:BASE_URL + 'orders/orders/paid_order/'+code,
    type:'POST',
    cache:false,
    success:function(rs){
      load_out();
      if(rs === 'success'){
        swal({
          title:'Paid',
          text:'ได้รับเงินเรียบร้อยแล้ว',
          type:'success',
          timer:1000
        });

        setTimeout(function(){
          window.location.reload();
        }, 1500);
      }else{
        swal({
          title:'Error',
          text:rs,
          type:'error'
        });
      }
    }
  })
}


function unpaid_order(){
  var code = $('#order_code').val();
  load_in();
  $.ajax({
    url:BASE_URL + 'orders/orders/unpaid_order/'+code,
    type:'POST',
    cache:false,
    success:function(rs){
      load_out();
      if(rs === 'success'){
        swal({
          title:'Success',
          text:'ยกเลิกการชำระเงินเรียบร้อยแล้ว',
          type:'success',
          timer:1000
        });

        setTimeout(function(){
          window.location.reload();
        }, 1500);
      }else{
        swal({
          title:'Error',
          text:rs,
          type:'error'
        });
      }
    }
  })
}


function checkQuotation()
{
	var qt_no = $('#qt_no').val();
	var code = $('#order_code').val();

	swal({
		title: "คุณแน่ใจ ?",
		text: "การทั้งเก่าหมดจะถูกลบและโหลดใหม่  ยืนยันการดึงรายการหรือไม่ ?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: 'ยืนยัน',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: false
		}, function(){
			load_in();
			$.ajax({
				url: BASE_URL + 'orders/orders/reload_quotation',
				type:"GET",
				cache:"false",
				data:{
					'order_code' : code,
					'qt_no' : qt_no
				},
				success: function(rs){
					load_out();
					var rs = $.trim(rs);
					if( rs == 'success' ){
						swal({
							title:'Success',
							text:'ดึงรายการใหม่เรียบร้อยแล้ว',
							type:'success',
							timer:1000
						});

						window.location.reload();
						//updateDetailTable()
					}else{
						swal("Error !", rs , "error");
					}
				}
			});
	});

}


function recal(id) {
	var price = parseDefault(parseFloat($('#price_'+id).val()), 0);
	var qty = parseDefault(parseFloat($('#qty_'+id).val()), 0);
	var disc = $('#disc_'+id).val();
	var discAmount = parseDiscountAmount(disc, price);
	var lineTotal = (price * qty) - (discAmount * qty);
	$('#line_total_'+id).val(lineTotal.toFixed(2));


	recalTotal();
}

//--- convert line total to discount

function recalDiscount(id) {
	var qty = parseDefault(parseFloat($('#qty_'+id).val()), 0);
	var price = parseDefault(parseFloat($('#price_'+id).val()), 0);
	var amount = parseDefault(parseFloat($('#line_total_'+id).val()), 0);

	var disc = (1- (amount/qty)/price) * 100;

	$('#disc_'+id).val(disc.toFixed(2)+"%");

	recalTotal();
}




function recalTotal() {
	var total_order = 0;
	var totalAfDisc = 0;
	var total_qty = 0;
	var total_disc = 0;

	var net_amount = 0;
	var shipping_fee = parseDefault(parseFloat($('#shipping-box').val()), 0);
	var service_fee = parseDefault(parseFloat($('#service-box').val()), 0);
	var deposit = parseDefault(parseFloat($('#deposit-amount').val()), 0);

	$('.line-total').each(function(){
		let id = $(this).data('id');
		let price = parseDefault(parseFloat($('#price_'+id).val()), 0);
		let qty = parseDefault(parseFloat($('#qty_'+id).val()), 0);
		let amount = parseDefault(parseFloat($('#line_total_'+id).val()), 0);
		let order_amount = qty * price;
		let disc_amount = order_amount - amount;

		total_order += order_amount;
		total_qty += qty;
		total_disc += disc_amount;

	});

	totalAfDisc = total_order - total_disc;
	$('#totalAfDisc').val(totalAfDisc);


	var bill_disc = parseDefault(parseFloat($('#billDiscAmount').val()), 0);

	total_disc += bill_disc;
	net_amount = (total_order + shipping_fee + service_fee) - total_disc - deposit;

	$('#total-qty').text(addCommas(total_qty.toFixed(2)));
	$('#total-order').text(addCommas(total_order.toFixed(2)));
	$('#total-disc').text("-" + addCommas(total_disc.toFixed(2)));
	$('#shipping-fee').text(addCommas(shipping_fee.toFixed(2)));
	$('#service-fee').text(addCommas(service_fee.toFixed(2)));
	$('#deposit').text("-" + addCommas(deposit.toFixed(2)));
	$('#net-amount').text(addCommas(net_amount.toFixed(2)));

}




function updateBillDiscAmount() {
	var order_code = $('#order_code').val();
	var billDiscAmount = parseDefaultValue($('#billDiscAmount').val(), 0, 'float');
	var c_bDisc = $('#current_bill_disc_amount').val();

	$.ajax({
		url:HOME + 'update_bill_discount',
		type:'POST',
		cache:false,
		data:{
			'code' : order_code,
			'bDiscAmount' : billDiscAmount
		},
		success:function(rs) {
			var rs = $.trim(rs);
			if(rs === 'success') {
				$('#current_bill_disc_amount').val(billDiscAmount);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});

				$('#billDiscAmount').val(c_bDisc);
			}

			recalTotal();
		}
	})

}




$('#shipping-box').focusout(function() {
	var fee = parseDefault(parseFloat($(this).val()), 0);

	if(fee < 0) {
		$(this).val(0.00);
	}
	else {
		$(this).val(fee.toFixed(2));
	}

	recalTotal();
})



$('#service-box').focusout(function() {
	var fee = parseDefault(parseFloat($(this).val()), 0);

	if(fee < 0) {
		$(this).val(0.00);
	}
	else {
		$(this).val(fee.toFixed(2));
	}

	recalTotal();
})

function update_bdisc() {
	var billDisAmount = parseDefault(parseFloat(removeCommas($('#billDiscAmount').val())), 0);
	var billDisPercent = parseDefault(parseFloat($('#billDiscPercent').val()), 0);

	var code = $('#code').val();
	load_in();

	$.ajax({
		url:HOME + 'update_bill_discount',
		type:'POST',
		cache:false,
		data:{
			"code" : code,
			"bDiscText" : billDisPercent,
			"bDiscAmount" : billDisAmount
		},
		success:function(rs) {
			load_out();
			var rs = $.trim(rs);
			if(rs === 'success') {
				$('#billDiscPercent').attr('disabled', 'disabled');
				$('#billDiscAmount').attr('disabled', 'disabled');
				$('#btn-update-bdisc').addClass('hide');
				$('#btn-edit-bdisc').removeClass('hide');
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				});
			}
		}
	})

}

$('.price-box').click(function() {
	$(this).select();
})

$('.qty-box').click(function() {
	$(this).select();
})

$('.discount-box').click(function() {
	$(this).select();
})

$('.line-total').click(function() {
	$(this).select();
})

$('#billDiscAmount').click(function() {
	$(this).select();
})

$('#shipping-box').click(function() {
	$(this).select();
})

$('#service-box').click(function() {
	$(this).select();
})


function percent_init() {
	$('.row-disc').keyup(function(e) {
		if(e.keyCode === 32) {
			//-- press space bar
			var value = $.trim($(this).val());
			if(value.length) {
				var last = value.slice(-1);
				if(isNaN(last)) {
					//--- ถ้าตัวสุดท้ายไม่ใช่ตัวเลข เอาออก
					value = value.slice(0, -1);
				}
				value = value +"%";
				$(this).val(value);
			}
			else {
				$(this).val('');
			}

			recal($(this).data('id'));
		}
	})
}


function digit_init() {
	$('.digit').focusout(function(){
		var value = parseDefaultValue($(this).val(), 0, 'float');
		$(this).val(value.toFixed(2));
	});

	$('.digit').focus(function(){
		$(this).select();
	})
}


$(document).ready(function(){
	percent_init();
	digit_init();
})
