
$(document).ready(function() {

  let appHelper = new AppHelper();

  $('#username').on('keyup', function(e) {
    e.preventDefault();
    appHelper.setTextEmptyValidater('username','username_err','Please enter username.');
  });

  $('#password').on('keyup', function(e) {
    e.preventDefault();
    appHelper.setTextEmptyValidater('password','password_err','Please enter password.');
  });

  $('#login_form').submit(function(e) {
    e.preventDefault();

    var isProcess = false;
    var error_box = $('#save_rs_err');
    var success_box = $('#save_rs_succ');

    error_box.html('');
    success_box.html('');

    
    var username_Flag = appHelper.setTextEmptyValidater('username','username_err');
    var password_Flag = appHelper.setTextEmptyValidater('password','password_err');

    if (username_Flag && password_Flag ) {
      isProcess = true;
    }

    if (isProcess) {

      var username = $('#username').val();
      var password = $('#password').val();

      var postLoginData = '{"username": "'+username+'","password" : "'+password+'"}';
      $.ajax({
        type: 'POST',
        url: 'verify_login_user',
        data: {ACTION:'LOGIN_REQUEST',POST_LOGINDATA:postLoginData},
        success: function (res) {
          if(res!=''){
            var data= JSON.parse(res);
            if(data.ERR_CODE!=''){
              var errText = "Code -> "+data.ERR_CODE+"<br>Description -> "+data.ERR_DESCRIPTION+"<br>Logs -> "+data.RES_LOGS
              error_box.html(errText);
            }else if(data.SUC_CODE!=''){
              success_box.html(data.SUC_DESCRIPTION);
              //window.location.href=data.success_url;

              //On success redirect.
              window.location.replace("dashBoardIndex");
          
              // $(".errormsg").html(data.msg).show();  
              // setTimeout(function(){
              //    window.location.reload();
              // }, 5000);

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


  $('.selected_role').on("click", function(e) {
    
    if(confirm("Are you want to sure?")){
      var error_box = $('#save_rs_err');
      var success_box = $('#save_rs_succ');

      error_box.html('');
      success_box.html('');
      
      var user_role_id = $(this).attr('data-Select_role');

      var postLoginData = '{"user_role_id": "'+user_role_id+'"}';
      $.ajax({
        type: 'POST',
        url: 'submitUserRole',
        data: {ACTION:'SELECT_ROLE_REQUEST',POST_SELROLEDATA:postLoginData},
        success: function (res) {
          if(res!=''){
            var data= JSON.parse(res);
            if(data.ERR_CODE!=''){
              var errText = "Code -> "+data.ERR_CODE+"<br>Descriptio -> "+data.ERR_DESCRIPTION+"<br>Logs -> "+data.RES_LOGS
              error_box.html(errText);
            }else if(data.SUC_CODE!=''){
              success_box.html(data.SUC_DESCRIPTION);
              //window.location.href=data.success_url;

              //On success redirect.
              window.location.replace("dashBoardIndex");
          
              // $(".errormsg").html(data.msg).show();  
              // setTimeout(function(){
              //    window.location.reload();
              // }, 5000);

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
  })

});
