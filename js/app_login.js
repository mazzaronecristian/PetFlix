document.addEventListener('DOMContentLoaded', () => {
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

function signup(serverURL){
  const signupForm = document.querySelector('#sign-up-form');
  var elements = signupForm.elements;

  var myCredentials = {};

  var elementsArray = Array.from(elements);
  $(elementsArray).each((i,input)=>
    myCredentials[input.name] = input.value
  );
  var request = $.ajax({
    url : serverURL,
    type: "POST",
    data: {
      username : myCredentials['username'],
      email : myCredentials['email'],
      password : myCredentials['password'],
    },
    dataType: "json",
  });

  request.done(function (data) {  
    alert(data);
  });
}
