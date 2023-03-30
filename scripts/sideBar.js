const main = document.querySelector('.main'),
        sideBar = document.querySelector('.side-bar'),
        navLink = document.querySelector('.nav-link'),
        menuLinks = document.querySelector('.menu-links'),
        links = document.querySelectorAll('.menu-links li');


sideBar.addEventListener('mouseover', function(){
    sideBar.classList.remove('close');
});
sideBar.addEventListener('mouseout', function(){
    sideBar.classList.add('close');
});

sideBar.addEventListener('click', function(){
    sideBar.classList.toggle('close');
});
main.addEventListener('click', function(){
    sideBar.classList.add('close');
});