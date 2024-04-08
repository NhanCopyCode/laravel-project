// const darkInput = document.querySelector('#dark_input');
// const lightInput = document.querySelector('#light_input');

// console.log(darkInput, 123);
// const body = document.body;
// const main = document.querySelector('.main');

// darkInput.onclick = function() {
//     if(darkInput.checked) 
//     {
//         main.style.backgroundColor  = '#1a1d25';
//         main.style.color = '#fff';
//     }
// }

// lightInput.onclick = function() {
//     if(lightInput.checked) 
//     {
//         main.style.backgroundColor  = null;
//         main.style.color = null;
//     }

// }

document.querySelector('.mode-switcher').addEventListener('click', function(e) {
    e.preventDefault();
    const mainApp = document.querySelector('.main');
    const iconDark = document.querySelector('.icon-dark');
    const iconLight = document.querySelector('.icon-light');
    const tableBranch = document.querySelector('table');

    // console.log(mainApp);
    const currentMode = mainApp.classList.contains('dark') ? 'dark' : 'light';
    let newMode = currentMode === 'light' ? 'dark' : 'light';
    console.log(newMode, 'trước');
    localStorage.setItem('mode', newMode);
    newMode = localStorage.getItem('mode') || 'light';
    console.log(newMode, 'sau');
    if(newMode === 'light') {
        iconLight.style.display = 'none';
        iconDark.style.display = 'block';

        //Add class table-dark into table
        tableBranch.classList.remove('table-dark');
    }else {
        iconLight.style.display = 'block';
        iconDark.style.display = 'none';

         //remove class table-dark from table
         tableBranch.classList.add('table-dark');
    }

    if(newMode)
    mainApp.classList.remove(currentMode);
    mainApp.classList.add(newMode);
    // Gọi AJAX tới Laravel để cập nhật session
    fetch('/switch-mode')
      .then(response => {
          // Xử lý sau khi cập nhật session
        //   console.log('Xin chào');
      })
      .catch(error => {
          console.error('Error switching mode:', error);
      });
});


document.addEventListener('DOMContentLoaded', function() {
    const iconDark = document.querySelector('.icon-dark');
    const iconLight = document.querySelector('.icon-light');

   const tableBranch = document.querySelector('table');
   console.log('table')
    console.log(tableBranch);
    const mode = localStorage.getItem('mode');
    // console.log(mode);
    if(mode) {
        if(mode === 'light') {
           iconLight.style.display = 'none'
           iconDark.style.display = 'block'
            //Add class table-dark into table
            tableBranch.classList.remove('table-dark');
        }

        if(mode === 'dark') {
            iconDark.style.display = 'none'
            iconLight.style.display = 'block'

            //Remove class table-dark from table
            tableBranch.classList.add('table-dark');

        }

      
    }else {
        iconLight.style.display = 'none';
        iconDark.style.display = 'block';

        //Add default class table-dark into table
        tableBranch.classList.add('table-dark');
        
    }

    var savedMode = localStorage.getItem('mode') || 'light';
    const mainApp = document.querySelector('.main');

    mainApp.classList.add(savedMode);
});
