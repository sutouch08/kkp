var HOME = BASE_URL + 'users/users/';

var validUname = true;
var validDname = true;
var validPwd = true;



function newUser(){
  window.location.href = HOME+'add_user';
}



function goBack(){
  window.location.href = HOME;
}

function getEdit(id){
  window.location.href = HOME + 'edit_user/'+id;
}


function getReset(id){
  window.location.href = HOME + 'reset_password/'+id;
}




function getDelete(id, uname){
  swal({
    title:'Are sure ?',
    text:'ต้องการลบ '+ uname +' หรือไม่ ?',
    type:'warning',
    showCancelButton: true,
		confirmButtonColor: '#FA5858',
		confirmButtonText: 'ใช่, ฉันต้องการลบ',
		cancelButtonText: 'ยกเลิก',
		closeOnConfirm: false
  },function(){
    $.ajax({
      url: HOME + 'delete_user/'+id,
      type:'GET',
      cache:false,
      success:function(rs){
        if(rs == 'success'){
          swal({
            title:'Deleted',
            title:'User deleted',
            type:'success',
            time: 1000
          });

          setTimeout(function(){
            window.location.reload();
          }, 1500)
        }else{
          swal({
            title:'Error!',
            text:'Cannot delete user',
            type:'error'
          });
        }
      }
    })
  })
}






function addUser(){
  var dname = $('#dname').val();
  var uname = $('#uname').val();
  var pwd = $('#pwd').val();
  var cmp = $('#cm-pwd').val();
  var profile = $('#profile').val();
  var status = $('input[name=status]:checked').val();
	var sale_code = $('#sale_id').val();

  if( !validDname || !validUname || !validPwd ){
    return false;
  }

	$.ajax({
		url:HOME + 'new_user',
		type:'POST',
		cache:false,
		data:{
			'dname' : dname,
			'uname' : uname,
			'pwd' : pwd,
			'profile' : profile,
			'status' : status,
			'sale_code' : sale_code
		},
		success:function(rs) {
			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});

				setTimeout(function() {
					newUser();
				}, 1200);
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				})
			}
		}
	})

} //--- end function



function updateUser(){
  var id = $('#user_id').val();
  var dname = $('#dname').val();
  var uname = $('#uname').val();
  var profile = $('#profile').val();
  var status = $('input[name=status]:checked').val();
	var sale_code = $('#sale_id').val();

  if( !validDname || !validUname ){
    return false;
  }

	$.ajax({
		url:HOME + 'update_user',
		type:'POST',
		cache:false,
		data:{
			'user_id' : id,
			'dname' : dname,
			'uname' : uname,
			'profile' : profile,
			'status' : status,
			'sale_code' : sale_code
		},
		success:function(rs) {
			if(rs === 'success') {
				swal({
					title:'Success',
					type:'success',
					timer:1000
				});
			}
			else {
				swal({
					title:'Error!',
					text:rs,
					type:'error'
				})
			}
		}
	})

}




function changePassword(){
  var id = $('#user_id').val();
  var pwd = $('#pwd').val();
  var cmp = $('#pwd').val();
  if(pwd.length == 0 || cmp.length == 0){
    validPWD();
  }

  if(! validPwd){
    return false;
  }

  $('#resetForm').submit();
}



function validPWD(){
  var pwd = $('#pwd').val();
  var cmp = $('#cm-pwd').val();
  if(pwd.length > 0 && cmp.length > 0){
    if(pwd != cmp){
      $('#cm-pwd-error').text('Password missmatch!');
      $('#pwd').addClass('has-error');
      $('#cm-pwd').addClass('has-error');
      validPwd = false;
    }else{
      $('#cm-pwd-error').text('');
      $('#pwd').removeClass('has-error');
      $('#cm-pwd').removeClass('has-error');
      validPwd = true;
    }
  }else{
    $('#cm-pwd-error').text('Password is required!');
    $('#pwd').addClass('has-error');
    $('#cm-pwd').addClass('has-error');
    validPwd = false;
  }
}





function validUserName(){
  var uname = $('#uname').val();
  var id = $('#user_id').val();
  if(uname.length > 0){

		$.ajax({
			url:BASE_URL + 'users/users/valid_uname',
			type:'GET',
			cache:false,
			data:{
				'uname' : uname,
				'id' : id
			},
			success:function(rs) {
				rs = $.trim(rs);
        if(rs === 'exists'){
          $('#uname-error').text('User name already exists!');
          $('#uname').addClass('has-error');
          validUname = false;
        }else{
          $('#uname-error').text('');
          $('#uname').removeClass('has-error');
          validUname = true;
        }
			},
			error:function(xhr, status, error) {
				var errorMessage = xhr.status+": "+xhr.statusText;
				swal({
					title:'Error!',
					text:'Error-'+errorMessage,
					type:'error'
				});
			}
		})

  }else{
    $('#uname-error').text('User name is required!');
    $('#uname').addClass('has-error');
    validUname = false;
  }
}



function validDisplayName(){
  var dname = $('#dname').val();
  var id = $('#user_id').val();
  if(dname.length > 0){
		$.ajax({
			url:BASE_URL + 'users/users/valid_dname',
			type:'GET',
			cache:false,
			data:{
				'dname' : dname,
				'id' : id
			},
			success:function(rs) {
				rs = $.trim(rs);
	      if(rs === 'exists'){
	        $('#dname-error').text('Display name already exists!');
	        $('#dname').addClass('has-error');
	        validDname = false;
	      }else{
	        $('#dname-error').text('');
	        $('#dname').removeClass('has-error');
	        validDname = true;
	      }
			},
			error:function(xhr, status, error) {
				var errorMessage = xhr.status+": "+xhr.statusText;
				swal({
					title:'Error!',
					text:'Error-'+errorMessage,
					type:'error'
				});
			}
		})

  }else{
    $('#dname-error').text('Display name is required!');
    $('#dname').addClass('has-error');
    validDname = false;
  }
}




$('#dname').focusout(function(){
  validDisplayName();
})



$('#uname').focusout(function(){
  validUserName();
})



$('#pwd').focusout(function(){
  validPWD();
})



$('#pwd').keyup(function(e){
  validPWD();
});



$('#cm-pwd').keyup(function(e){
  validPWD(e);
})


function clearFilter(){
  var url = BASE_URL+'users/users/clear_filter';
  var page = BASE_URL+'users/users';
  $.get(url, function(rs){
    window.location.href = page;
  });
}




//--- active user
function setActive(id){
  url = BASE_URL+'users/users/active_user/'+id;
  $.get(url, function(rs){
    rs = $.trim(rs);
    if(rs === 'success'){
      $('#btn-active-'+id).addClass('hide');
      $('#btn-disActive-'+id).removeClass('hide');

      $('#label-disActive-'+id).addClass('hide');
      $('#label-active-'+id).removeClass('hide');
    }else{
      //err = $.parseJSON(rs);
      swal({
        title:'Error!',
        text: rs,
        type:'error'
      });
    }
  });
}





//--- disactive user
function disActive(id){
  url = BASE_URL+'users/users/disactive_user/'+id;
  $.get(url, function(rs){
    rs = $.trim(rs);
    if(rs === 'success'){
      $('#btn-disActive-'+id).addClass('hide');
      $('#btn-active-'+id).removeClass('hide');

      $('#label-active-'+id).addClass('hide');
      $('#label-disActive-'+id).removeClass('hide');
    }else{
      swal({
        title:'Error!',
        text:rs,
        type:'error'
      });
    }
  })
}


function getSearch(){
  $('#searchForm').submit();
}
