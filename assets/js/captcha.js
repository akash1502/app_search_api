
let alphaNums = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 
'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];



function setCaptcha(captchaOutputTextId, captchaInputTextId, captchaMessageId, refreshButtonId){

  //let submitButton = document.querySelector('#submit');

  let outputText = document.querySelector('#'+captchaOutputTextId);
  let inputText = document.querySelector('#'+captchaInputTextId);
  let messageText = document.querySelector('#'+captchaMessageId);
  let refreshButton = document.querySelector('#'+refreshButtonId);

  let captchaArr = [];

  for(let i = 1; i <= 7; i++) {
    captchaArr.push(alphaNums[Math.floor(Math.random() * alphaNums.length)]);
  }
  outputText.innerHTML = captchaArr.join('');

  refreshButton.addEventListener('click', function () {
    inputText.value = "";
    let refreshArr = [];
    for(let j = 1; j <= 7; j++) {
      refreshArr.push(alphaNums[Math.floor(Math.random() * alphaNums.length)]);
    }
    outputText.innerHTML = refreshArr.join('');
    messageText.innerHTML = "";
  });

  inputText.addEventListener('keyup', function(e) {
    //verifyCaptcha(captchaOutputTextId,captchaInputTextId,captchaMessageId)
  });
}


function verifyCaptcha(captchaOutputTextId,captchaInputTextId,captchaMessageId){

  let outputText = document.querySelector('#'+captchaOutputTextId);
  let inputText = document.querySelector('#'+captchaInputTextId);
  let messageText = document.querySelector('#'+captchaMessageId);

  var returnFlag = false;
  
  messageText.classList.remove("redText");
  messageText.classList.remove("greenText");

  if(inputText.value === outputText.innerHTML) {
    messageText.classList.add("greenText");
    messageText.innerHTML = "Captcha Matched";
    returnFlag = true;
  } else {
    messageText.classList.add("redText");
    messageText.innerHTML = "Incorrect captcha, Please try again..";
    returnFlag = false;
  }

  return returnFlag;

}






/*

submitButton.addEventListener('click',  function() {
  if(inputText.value === outputText.innerHTML) {
    messageText.classList.add("greenText");
    messageText.innerHTML = "Correct!";
  } else {
    messageText.classList.add("redText");
    messageText.innerHTML = "Incorrect, please try again";
  }
});

submitButton.addEventListener('keyup', function(e) {
  if(e.keyCode === 13) {
    if(inputText.value === outputText.innerHTML) {
      console.log("correct!");
      messageText.classList.add("greenText");
      messageText.innerHTML = "Correct!";
    } else {
      messageText.classList.add("redText");
      messageText.innerHTML = "Incorrect, please try again";
    }
  }
});*/







