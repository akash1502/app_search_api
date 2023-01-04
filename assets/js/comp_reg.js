
document.getElementById('compReg_form').addEventListener('submit', function(e) {
  e.preventDefault();
  let nameOkay;
  let phoneOkay;
  let submitOkay;

  let comp_name = document.querySelector('#comp_name').value
  let email = document.querySelector('#email').value
  let mob_no = document.querySelector('#mob_no').value
  let base_url = document.getElementById('base_url').value
  let email_ids = document.getElementById('email_ids').value
  
  //let faqForm = new FormValidate(comp_name,email,mob_no);
  let faqForm = new FormValidate();

  nameOkay = faqForm.validateName(comp_name);
  phoneOkay = faqForm.validatePhone(mob_no);
  emailOkay = faqForm.validateMail(email);
  domainEmailOkay = faqForm.validateMail(email_ids);

  $("#compName_err").html("");
  if(nameOkay==false){
    $("#compName_err").html("Please enter valid company name")
  }

  $("#mob_err").html("");
  if(!phoneOkay){
    $("#mob_err").html("Please enter valid mobile no")
  }

  $("#email_err").html("");
  if(!emailOkay){
    $("#email_err").html("Please enter valid email id")
  }

  $("#domEmail_err").html("");
  if(!email_ids){
    $("#domEmail_err").html("Please enter valid domain email id")
  }

  submitOkay = nameOkay && phoneOkay;

  // Prevent form submission if form input is not okay
  if (submitOkay) {
   
    var url =base_url+"/submit_companyRegistration";
    var formData = new FormData(this);
    
    $.ajax({
      url:url,
      type:"POST",
      data:new FormData(this),
      processData:false,
      contentType:false,
      cache:false,
      async:false,
      success: function(data){
          console.log(data);
      }
    });
  }else{
    console.log("Final ==>"+submitOkay)
  }
});