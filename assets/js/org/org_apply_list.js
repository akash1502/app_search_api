
//import {Organization} from './organization.js';


$(document).ready(function() {
	let appln_assign = true;

	$('.appln_assign').on('click', function(e) {
		e.preventDefault();
		var error_box = $('#save_rs_err');
		var success_box = $('#save_rs_succ');

		error_box.html('');
		success_box.html('');
		
		if (appln_assign) {
			if (confirm('Are you sure want to assign your self?')) {
				appln_assign = false;				

				var appln_id = $(this).data('appln_id');
				$.ajax({
					type:'POST',
					url: 'appln_assign',
					data: {ACTION:'ASSIGN_APPLN',POST_ORGDATA:'{"appln_id":"'+appln_id+'"}'},
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
						appln_assign = true;
					},
				});
			}
		}else{
			alert('Request alredy Submitted.')
		}		
	});

});
