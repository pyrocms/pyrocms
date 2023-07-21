import './bootstrap';
import '../scss/app.scss';

import Alpine from 'alpinejs';
 
window.Alpine = Alpine;
 
Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");

    menuToggle.addEventListener("click", function () {
        menu.classList.toggle("menu-open");
        menuToggle.classList.toggle("menu-toggle-open");
    });
});
