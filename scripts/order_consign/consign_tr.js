var HOME = BASE_URL + 'orders/consign_tr/';


function addNew(){
  window.location.href = HOME + 'add_new';
}



function goBack(){
  window.location.href = HOME;
}



function editDetail(){
  var code = $('#order_code').val();
  window.location.href = HOME + 'edit_detail/'+ code;
}


function editOrder(code){
  window.location.href = HOME + 'edit_order/'+ code;
}



function clearFilter(){
  var url = HOME + 'clear_filter';
  $.get(url, function(rs){ goBack(); });
}



function getSearch(){
  $('#searchForm').submit();
}



$('.search').keyup(function(e){
  if(e.keyCode == 13){
    getSearch();
  }
});


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


function approve(){
  var order_code = $('#order_code').val();
  $.ajax({
    url:BASE_URL + 'orders/orders/order_state_change',
    type:'POST',
    cache:false,
    data:{
      'order_code' : order_code,
      'state' : 3
    },
    success:function(rs){
      if(rs === 'success'){
        swal({
          title:'Success',
          text:'ปล่อยจัดสินค้าเรียบร้อยแล้ว',
          type:'success',
          timer:1000
        });

        setTimeout(function(){
          window.location.reload();
        }, 1500);
      }else{
        swal({
          title:'Error!!',
          text:rs,
          type:'error'
        });
      }
    }
  });
}

function toggleState(state){
  var current = $('#state_'+state).val();
  if(current == 'Y'){
    $('#state_'+state).val('N');
    $('#btn-state-'+state).removeClass('btn-info');
  }else{
    $('#state_'+state).val('Y');
    $('#btn-state-'+state).addClass('btn-info');
  }

  getSearch();
}


function toggleNotSave(){
  var current = $('#notSave').val();
  if(current == ''){
    $('#notSave').val(1);
    $('#btn-not-save').addClass('btn-info');
  }else{
    $('#notSave').val('');
    $('#btn-not-save').removeClass('btn-info');
  }

  getSearch();
}


function toggleOnlyMe(){
  var current = $('#onlyMe').val();
  if(current == ''){
    $('#onlyMe').val(1);
    $('#btn-only-me').addClass('btn-info');
  }else{
    $('#onlyMe').val('');
    $('#btn-only-me').removeClass('btn-info');
  }

  getSearch();
}


function toggleIsExpire(){
  var current = $('#isExpire').val();
  if(current == ''){
    $('#isExpire').val(1);
    $('#btn-expire').addClass('btn-info');
  }else{
    $('#isExpire').val('');
    $('#btn-expire').removeClass('btn-info');
  }

  getSearch();
}
