class AppHelper {

  // method for validation of comp name input
  validateText(textField) {
    const regName = new RegExp("^[a-zA-Z\\s]*$");
    let isNameValid = false;
    let name_z = textField; 
    if( !(name_z === '') && (regName.test(name_z)) ){
      isNameValid = true;
    }
    return isNameValid;
  }

  validateEmpty(textField) {    
    let isNameValid = false;    
    if( !(textField === '')){
      isNameValid = true;
    }
    return isNameValid;
  }

  validateNumber(numberField) {
    const regPhone = new RegExp("^([0|+[0-9]{1,5})?([7-9][0-9]{9})$");
    let isNumbervlid = false;
    let number_z = numberField; 
    if( !(number_z === '') && (regPhone.test(number_z)) ){
      isNumbervlid = true;
    }
    return isNumbervlid;
  }

  validatePhone(phoneField) {

    let isPhoneValid = false;
    let phone_z = phoneField;
    let isPhoneHasValidLength = phone_z.length < 10 || phone_z.length > 13 ? false : true;
    const regPhone = new RegExp("^([0|+[0-9]{1,5})?([7-9][0-9]{9})$");
    if( !(phone_z === '') && isPhoneHasValidLength && regPhone.test(phone_z)) {
      isPhoneValid = true;
    }
    return isPhoneValid;
  }

  validateMail(emailField) {
    let isEmailValid = true;
    let email_z = emailField; 
    var invalidProviders = ['@gmail.com','@rediff.com','@yahoo.com','@hotmail.com','@zoho.com'];
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if( !(!(email_z === '') && (testEmail.test(email_z))) ) {
      isEmailValid = false;
    }
    return isEmailValid;
  }

  validateOrgPhone(phoneField) {

    let isPhoneValid = false;
    let phone_z = phoneField;
    let allareSame = phone_z.split('').every(char => char === phone_z[0]);
    let isPhoneHasValidLength = phone_z.length < 10 || phone_z.length > 13 ? false : true;
    const regPhone = new RegExp("^([0|+[0-9]{1,5})?([7-9][0-9]{9})$");
    if( !(phone_z === '') && isPhoneHasValidLength && regPhone.test(phone_z) && !allareSame) {
      isPhoneValid = true;
    }
    return isPhoneValid;
  }

  validateOrgEmail(emailField) {
    let isEmailValid = true;
    let email_z = emailField; 
    var invalidProviders = ['@gmail.com','@rediff.com','@yahoo.com','@hotmail.com','@zoho.com'];
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,6}$/i;
    if( !(!(email_z === '') && (testEmail.test(email_z))) ) {
      isEmailValid = false;
    }
    for (let i = 0; i < invalidProviders.length; i++) {
      var invPs = invalidProviders[i];
      if(email_z.endsWith(invPs)){
        isEmailValid = false;
        break;
      }

    }
    return isEmailValid;
  }

  async validateOrgWebsite(website_url) {
    var isUrlValid = false;
    if(website_url !== "")
    {
      /*if (!(website_url.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g) !== null)){
        isWeburlValid = false;
      }*/
      var encodedURL = encodeURIComponent(website_url);

      await $.ajax({
        type: 'GET',
        url: 'verifyWebsiteUrl',
        data: {urlString:encodedURL},
        success: function (res) {
          if(res!=''){
            console.log(res);
            var data= JSON.parse(res);
            if(data.SUC_CODE!=''){
              isUrlValid = true;
            }
          }         
        },
        error: function (data) {
          console.log('An error occurred.');
          console.log(data);
        },
      });
    }
    return isUrlValid;
  }

  setOrgEmailValidater(emailField,errorShowDivId,errorMessage){
    var returnValue = false;
    var emailField = $("#"+emailField);
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    emailField.removeClass("border border-danger"); 
    let emailOkay = this.validateOrgEmail(emailField.val());
    if(emailOkay==false){
      returnValue = false;
      emailField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Please enter valid email id");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  async setOrgWebsiteValidater(org_website,errorShowDivId,errorMessage){
    var returnValue = false;
    var org_website = $("#"+org_website);
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    org_website.removeClass("border border-danger"); 
    let websiteurlOkay = await this.validateOrgWebsite(org_website.val());
    if(websiteurlOkay==false){
      returnValue = false;
      org_website.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Please enter valid website url");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  setOrgPhoneValidater(phoneField,errorShowDivId,errorMessage){
    var returnValue = false;
    var phoneField = $("#"+phoneField);    
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    phoneField.removeClass("border border-danger");
    let phoneOkay = this.validateOrgPhone(phoneField.val());
    if(phoneOkay==false){
      returnValue = false;
      phoneField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Enter valid contact no.");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  setEmailValidater(emailField,errorShowDivId,errorMessage){
    var returnValue = false;
    var emailField = $("#"+emailField);
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    emailField.removeClass("border border-danger"); 
    let emailOkay = this.validateMail(emailField.val());
    if(emailOkay==false){
      returnValue = false;
      emailField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Please enter valid email id");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  setTextValidater(textField,errorShowDivId,errorMessage){
    var returnValue = false;
    var textField = $("#"+textField);
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    textField.removeClass("border border-danger");
    let textOkay = this.validateText(textField.val());
    if(textOkay==false){
      returnValue = false;
      textField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Please enter valid text");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  setTextEmptyValidater(textField,errorShowDivId,errorMessage){
    var returnValue = false;
    var textField = $("#"+textField);
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    textField.removeClass("border border-danger");
    let textOkay = this.validateEmpty(textField.val());
    if(textOkay==false){
      returnValue = false;
      textField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Please enter text");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

  setPhoneValidater(phoneField,errorShowDivId,errorMessage){
    var returnValue = false;
    var phoneField = $("#"+phoneField);    
    var errorShowDiv = $("#"+errorShowDivId);
    errorShowDiv.html('');
    phoneField.removeClass("border border-danger");
    let phoneOkay = this.validatePhone(phoneField.val());
    if(phoneOkay==false){
      returnValue = false;
      phoneField.addClass("border border-danger");
      if (errorMessage) {
        errorShowDiv.html(errorMessage);
      }else{
        errorShowDiv.html("Enter valid contact no.");
      }
    }else{
      returnValue = true;
    }
    return returnValue;
  }

}