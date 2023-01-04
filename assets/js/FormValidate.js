class FormValidate {

  // constructor(nameField,  emailField,phoneField, form) {
  //   this.nameField = nameField;    
  //   this.phoneField = phoneField;  
  //   this.emailField = emailField;  
  //   this.form = form;
  // }

  // method for validation of comp name input
  validateName(nameField) {
    const regName = new RegExp("^[a-zA-Z\\s]*$");
    let isNameValid = false;
    //let name_z = nameField.value.trim(); // input value of Name input field
    let name_z = nameField; // input value of Name input field
    let isNameHasValidLength = name_z.length < 3 || name_z.length > 20 ? false : true;

    // Name input field is not empty and contain proper data -> Not Empty && value must be between 3 to 20 characters && follow reg expression for validation
    if( !(name_z === '') && isNameHasValidLength && (regName.test(name_z)) ){
        isNameValid = true;
    }
    return isNameValid;
  }

  validatePhone(phoneField) {
    let isPhoneValid = false;
    //let phone_z = phoneField.value.trim(); // input value of Phone input field
    let phone_z = phoneField; // input value of Phone input field
    let isPhoneHasValidLength = phone_z.length < 10 || phone_z.length > 13 ? false : true;  // making sure that phone number is between 10 to 13 digits -> +91 and rest 10 digits

    const regPhone = new RegExp("^([0|+[0-9]{1,5})?([7-9][0-9]{9})$");

    // Validating Phone Number -> Not Empty && Must have 10 to 13 digits only && follow reg expression for validation
    if( !(phone_z === '') && isPhoneHasValidLength && regPhone.test(phone_z)) {
        isPhoneValid = true;
    }
    return isPhoneValid;
  }

  validateMail(emailField) {
    let isEmailValid = false;
    //let email_z = emailField.value.trim(); // input value of Phone input field
    let email_z = emailField; // input value of Phone input field

    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

    if( !(email_z === '') && (testEmail.test(email_z))) {
        isEmailValid = true;
    }
    return isEmailValid;
  }
}