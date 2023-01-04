
import {Organization} from './organization.js';


$(document).ready(function() {

	let appHelper = new AppHelper();

	let ip_address = $('#ip_address').val();
	setCaptcha('captcha_1', 'captchatextBox_1', 'captchaoutput_1', 'captcharefresh_1');
	if (!ip_address) {
		setCaptcha('captcha_2', 'captchatextBox_2', 'captchaoutput_2', 'captcharefresh_2');
	}
	
	$.ajax({
		type:'GET',
		url: 'ref_countryCodes',
		success: function (res) {
			var countryList = JSON.parse(res);
			$('#country_code').select2({
				data : countryList,
				width:'100%'
			});
		},
		error: function (data) {
			console.log('An error occurred.');
			console.log(data);
		},
	});

	$('#first_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextValidater('first_name','first_name_err');
	});

	$('#last_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextValidater('last_name','last_name_err');
	});

	$('#email_id').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setOrgEmailValidater('email_id','email_id_err');
	});

	$('#org_name').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setTextEmptyValidater('org_name','org_name_err');
	});

	$('#org_website').on('focusout', function(e) {
		e.preventDefault();
		appHelper.setOrgWebsiteValidater('org_website','org_website_err','Please provide valide website url.');
	});

	$('#mob_no').on('keyup', function(e) {
		e.preventDefault();
		appHelper.setOrgPhoneValidater('mob_no','mob_no_err');
	});


	$('#org_apply_form').submit(function(e) {
		e.preventDefault()
		var error_box = $('#save_rs_err');
		var success_box = $('#save_rs_succ');

		error_box.html('');
		success_box.html('');

		var ip_address = $('#ip_address').val();

		let isProcess = false;
		var captcha_1 = verifyCaptcha('captcha_1', 'captchatextBox_1', 'captchaoutput_1');

		var f_name_Flag = appHelper.setTextValidater('first_name','first_name_err');
		var l_name_Flag = appHelper.setTextValidater('last_name','last_name_err');
		var email_Flag = appHelper.setOrgEmailValidater('email_id','email_id_err');
		var org_name_Flag = appHelper.setTextEmptyValidater('org_name','org_name_err','Please enter organization name.');
		var org_website_Flag = appHelper.setOrgWebsiteValidater('org_website','org_website_err','Please provide valide website url.');
		var country_code_Flag = appHelper.setTextEmptyValidater('country_code','mob_no_err');
		var mob_no_Flag = appHelper.setOrgPhoneValidater('mob_no','mob_no_err');

		if (captcha_1 && f_name_Flag && l_name_Flag && email_Flag && org_name_Flag && org_website_Flag && mob_no_Flag && country_code_Flag ) {
			isProcess = true;
			if (!ip_address) {
				isProcess = verifyCaptcha('captcha_2', 'captchatextBox_2', 'captchaoutput_2');
			}
		}

		if (isProcess) {

			var first_name = $('#first_name').val();
			var last_name = $('#last_name').val();

			var email_id = $('#email_id').val();		
			var country_code = $('#country_code').val();
			var mob_no = $('#mob_no').val();

			var org_name = $('#org_name').val();
			var org_website = $('#org_website').val();


			let organization = new Organization();
			organization.first_name = first_name;
			organization.last_name = last_name;
			organization.email_id = email_id;
			organization.country_code = country_code;
			organization.mob_no = mob_no;
			organization.org_name = org_name;
			organization.org_website = org_website;
			organization.ip_address = ip_address;

			var postOrgData = JSON.stringify(organization);
			//console.log(organization);
			console.log(postOrgData);

			let appform = $(this);

			$.ajax({
				type: 'POST',
				url: 'save_apply_request',
				data: {ACTION:'SAVE_APP_REQUEST',POST_ORGDATA:postOrgData},
				success: function (res) {
					if(res!=''){
						var data= JSON.parse(res);
						if(data.ERR_CODE!=''){
							var errText = "Code -> "+data.ERR_CODE+"<br>Description -> "+data.ERR_DESCRIPTION+"<br>Logs -> "+data.RES_LOGS
							error_box.html(errText);
						}else if(data.SUC_CODE!=''){
							success_box.html(data.SUC_DESCRIPTION);
							//window.location.href=data.success_url;
						}else{
							error_box.html('Invalid response form server.');
						}
					}					
				},
				error: function (data) {
					console.log('An error occurred.');
					console.log(data);
				},
			});			
		}
	});
});
