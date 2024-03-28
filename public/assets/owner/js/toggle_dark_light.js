const darkInput = document.querySelector('#dark_input');
const lightInput = document.querySelector('#light_input');

console.log(darkInput, 123);
const body = document.body;
const main = document.querySelector('.main');

darkInput.onclick = function() {
    if(darkInput.checked) 
    {
        main.style.backgroundColor  = '#1a1d25';
        main.style.color = '#fff';
    }
}

lightInput.onclick = function() {
    if(lightInput.checked) 
    {
        main.style.backgroundColor  = null;
        main.style.color = null;
    }

}