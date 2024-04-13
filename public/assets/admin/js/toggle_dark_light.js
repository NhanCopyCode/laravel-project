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

    //Table branch / Modal branch
    const tableBranch = document.querySelector('table');
    const modal = document.querySelectorAll('.modal');


    // console.log(mainApp);
    const currentMode = mainApp.classList.contains('dark') ? 'dark' : 'light';
    let newMode = currentMode === 'light' ? 'dark' : 'light';
    localStorage.setItem('mode', newMode);
    newMode = localStorage.getItem('mode') || 'light';


    if(newMode === 'light') {
        iconLight.style.display = 'none';
        iconDark.style.display = 'block';

        //Add class table-dark into table
        if(tableBranch) {
            tableBranch.classList.remove('table-dark');
        }
        
    }else {
        iconLight.style.display = 'block';
        iconDark.style.display = 'none';

         //remove class table-dark from table
        if(tableBranch) {
            tableBranch.classList.add('table-dark');
            modal.forEach(function(e) {
                e.style.color = "#333"; 
            })
        }

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
    
    //Table branch / Modal branch
    const tableBranch = document.querySelector('table');
    const modal = document.querySelectorAll('.modal');

    console.log(modal); 

    const mode = localStorage.getItem('mode');
    // console.log(mode);
    if(mode) {
        if(mode === 'light') {
           iconLight.style.display = 'none'
           iconDark.style.display = 'block'
            //Add class table-dark into table
            if(tableBranch) {
                tableBranch.classList.remove('table-dark');
            }
        }

        if(mode === 'dark') {
            iconDark.style.display = 'none'
            iconLight.style.display = 'block'

            //Remove class table-dark from table
           if(tableBranch) {
                tableBranch.classList.add('table-dark');
                modal.forEach(function(e) {
                    e.style.color = "#333"; 
                });
           }
        }

      
    }else {
        iconLight.style.display = 'none';
        iconDark.style.display = 'block';

        //Add default class table-dark into table
        tableBranch.classList.remove('table-dark');
        
    }

    var savedMode = localStorage.getItem('mode') || 'light';
    const mainApp = document.querySelector('.main');

    mainApp.classList.add(savedMode);
});
