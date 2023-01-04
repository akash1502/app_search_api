
import {Location} from './location.js';

$(document).ready(function() {

	let appHelper = new AppHelper();
	
	$.ajax({
		type:'GET',
		url: 'get_countryList',
		success: function (res) {
			var countryList = JSON.parse(res);
			$('#country_id').select2({
				data : countryList,
				width:'100%'
			});
		},
		error: function (data) {
			console.log('An error occurred.');
			console.log(data);
		},
	});

	/*
		$('#country_id').select2({
	        ajax: {
	          url: 'get_countryList',
	          dataType: 'json',
	          data: function (params) {

	              var queryParameters = {
	                  searchText: params.term
	              }
	              return queryParameters;
	          },
	          processResults: function (data) {
	          	return {
	                  results: $.map(data, function (item) {
	                    //console.log(item);
	                      return {
	                          text: item.text,
	                          id: item.id
	                      }
	                  })
	          	};
	          }
	        }
	  	});
	  	*/


	  	$('#country_id').on('change', function(e) {
	  		var country_id = $(this).val();
	  		$.ajax({
	  			type:'GET',
	  			url: 'get_stateList?ctid='+country_id,
	  			success: function (res) {
	  				var stateList = JSON.parse(res);
	  				$('#state_id').select2({
	  					data : stateList,
	  					width:'100%'
	  				});
	  			},
	  			error: function (data) {
	  				console.log('An error occurred.');
	  				console.log(data);
	  			},
	  		});
	  	});

  	/*
	  	$('#country_id').on('change', function(e) {
			var country_id = $(this).val();
			$('#state_id').select2({

		        ajax: {
		          url: 'get_stateList?ctid='+country_id,
		          dataType: 'json',
		          data: function (params) {

		              var queryParameters = {
		                  searchText: params.term
		              }
		              return queryParameters;
		          },
		          processResults: function (data) {
		          	return {
		                  results: $.map(data, function (item) {
		                    //console.log(item);
		                      return {
		                          text: item.text,
		                          id: item.id
		                      }
		                  })
		          	};
		          }
		        }
		  	});
		});
	*/

	$('#state_id').on('change', function(e) {
		var state_id = $(this).val();
		$('#city_id').select2({

			ajax: {
				url: 'get_cityList?stid='+state_id,
				dataType: 'json',
				data: function (params) {

					var queryParameters = {
						searchText: params.term
					}
					return queryParameters;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
	                    //console.log(item);
	                    return {
	                    	text: item.text,
	                    	id: item.id
	                    }
	                })
					};
				}
			}
		});
	});

	$('#email_id').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setEmailValidater('email_id','email_id_err');
	});

	$('#first_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextValidater('first_name','first_name_err');
	});

	$('#last_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextValidater('last_name','last_name_err');
	});

	$('#mob_no').on('keyup', function(e) {
		e.preventDefault();
		//appHelper.setPhoneValidater('mob_no','mob_err');
	});

	$('#loc_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextEmptyValidater('loc_name','loc_name_err');
	});


	$('#location_details').hide();
	$('#location_admin_details').show();

	$('#admin_next_btn').on('click', function(e) {
		e.preventDefault();
		$('#location_details').show();
		$('#location_admin_details').hide();
	});

	$('#admin_back_btn').on('click', function(e) {
		e.preventDefault();
		$('#location_details').hide();
		$('#location_admin_details').show();
	});


	$('#add_location_from').submit(function(e) {

		e.preventDefault()

		let location = new Location();

		return;


		$('#submit').prop('disabled', true);
		var error_box=$('#error_show');
		error_box.html('');
		var err_line='';


		if (err_line != '') {
			error_box.html(err_line);
			$('#submit').prop('disabled', false);
			
		}else{

			var frm=$(this);
			$.ajax({
				type: frm.attr('method'),
				url: '/subscription_handler.php',
				data: frm.serialize(),
				success: function (res) {
					if(data!=''){
						var data= JSON.parse(res);
						if(data.flag==0){
							error_box.html(data.error_msg);
						}else if(data.flag==1){
							if(data.success_url!=''){
								window.location.href=data.success_url;
							}else{
								error_box.html('Session is not generated. Problem to get success_url');
							}
						}else{
							error_box.html('Invalid response form server.');
						}
					}
					$('#submit').prop('disabled', false);
				},
				error: function (data) {
					console.log('An error occurred.');
					console.log(data);
				},
			});
		}
		e.preventDefault()
	});



});
