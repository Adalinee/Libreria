document.getElementById("btn_iniciar").addEventListener("click", iniciarSesion);
document.getElementById("btn_register").addEventListener("click", register);


let container_formulario = document.querySelector(".container-formulario");
let formulario_register = document.querySelector(".formulario-register");
let formulario_login = document.querySelector(".formulario-login");
let box_back_login = document.querySelector(".box-back-login");
let box_back_register = document.querySelector(".box-back-register");



function iniciarSesion(){
    formulario_register.style.display = "none";
    container_formulario.style.left = "10px";
    formulario_login.style.display = "block";
    box_back_register.style.opacity = "1";
    box_back_login.style.opacity = "0";
}

function register(){
    formulario_register.style.display = "block";
    container_formulario.style.left = "410px";
    formulario_login.style.display = "none";
    box_back_register.style.opacity = "0";
    box_back_login.style.opacity = "1";
}


