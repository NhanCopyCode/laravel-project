const btnShowPassowrd = document.querySelector('#btnShowPassword');
const inputPasword = document.querySelectorAll('input[type="password"]');
// const inputPasswordConfirm = document.querySelector('input[type="password
btnShowPassowrd.onclick = function(e) 
{ 
    inputPasword.forEach(input => {
        if(input.type == 'password') {
            input.type = 'text';
        }else {
            input.type = 'password'
        }
    });
}