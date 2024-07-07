// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
require('./styles/app.scss');
import './styles/app.scss';
import 'animate.css';

const $ = require('jquery');

require('bootstrap');
import 'bootstrap';


// import Swiper JS 
import Swiper from 'swiper';
import { Autoplay, EffectFade } from 'swiper/modules';
// import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
$(document).ready(function() {
    console.log('This log comes from assets/app.js - wel come to jQuery! 🎉');
    var swiper = new Swiper(".mySwiper", {
        modules: [Autoplay],
        slidesPerView: 4,
        spaceBetween: 5,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    var swiper = new Swiper(".testimonial-swiper", {
        modules: [Autoplay],
        slidesPerView: 1,
        spaceBetween: 5,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });


    var swiperApp = new Swiper(".application-swipper", {
        modules: [Autoplay],
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        freeMode: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        }
    });

});

