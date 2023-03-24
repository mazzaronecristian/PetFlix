document.addEventListener("DOMContentLoaded", () => {
  const sign_in_btn = document.querySelector("#sign-in-btn");
  const sign_up_btn = document.querySelector("#sign-up-btn");
  const container = document.querySelector(".container");

  sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
  });

  sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
  });
});

//TODO: verifica della validità delle credenziali di registrazione: email valida e conferma password

function signup(serverURL) {
  emptyErrorLog();
  const signupForm = document.querySelector("#sign-up-form");
  var elements = signupForm.elements;

  var myCredentials = {};

  var elementsArray = Array.from(elements);
  $(elementsArray).each(
    (i, input) => (myCredentials[input.name] = input.value)
  );

  var validEmail = validateEmail(myCredentials["email"]);

  var validPwd = validatePwd(
    myCredentials["password"],
    myCredentials["cpassword"]
  );

  if (validEmail && validPwd) {
    var request = $.ajax({
      url: serverURL,
      type: "POST",
      data: {
        username: myCredentials["username"],
        email: myCredentials["email"],
        password: myCredentials["password"],
      },
      dataType: "json",
    });

    request.done(function (data) {
      if (!data) alert("email già in uso");
      else{
        alert("registrazione avvenuta con successo");
        window.location.href = "index.php";
      }
    });
  }
}

function validateEmail(mail) {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (mail.match(mailformat)) return true;

  writeErrorMessage("Email non valida.");
  return false;
}

function validatePwd(pwd, cPwd) {
  var pwdFormat = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  if (!pwd.match(pwdFormat)) {
    writeErrorMessage(
      "La password deve contenere almeno 8 caratteri, tra cui almeno un numero, una maiuscola e un carattere speciale."
    );
    return false;
  }
  if (pwd !== cPwd) {
    writeErrorMessage("Le due password non coincidono.");
    return false;
  }
  return true;
}

function writeErrorMessage(errMess) {
  var errLog = document.querySelector("#errorSection");
  let html = "<span>"+errMess+"<br></span>";
  $(errLog).append(html);
}

function emptyErrorLog(){
  let errLog = document.querySelector("#errorSection");
  while (errLog.hasChildNodes()) {
    errLog.removeChild(errLog.firstChild);
  }
}