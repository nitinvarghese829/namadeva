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

import {CountUp} from "countup.js"
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

    const options = {
        duration: 5, // duration of the animation in seconds
    };

    const yearsInIndustry = new CountUp('yearsInIndustry', 21, options); // replace 10 with the actual number
    const yearsOfExpertise = new CountUp('yearsOfExpertise', 80, options); // replace 100 with the actual number
    const happyClients = new CountUp('happyClients', 150, options); // replace 200 with the actual number
    const successfulProjects = new CountUp('successfulProjects', 300, options); // replace 300 with the actual number
    const kilosOfSteel = new CountUp('kilosOfSteel', 400, options); // replace 400 with the actual number

    // Start animations when the section is in view
    // $(window).on('scroll', function() {
    //     console.log('test');
    //     const offsetTop = $('.infographic-wrapper').offset().top;
    //     const scrollTop = $(window).scrollTop();
    //     const windowHeight = $(window).height();
    //
    //     if (scrollTop + windowHeight > offsetTop) {
            yearsInIndustry.start();
            yearsOfExpertise.start();
            happyClients.start();
            successfulProjects.start();
            kilosOfSteel.start();

            // Unbind the scroll event after animation starts
        //     $(window).off('scroll');
        // }
    // });

    // $('a.dropdown-item').on('click', function(e) {
    //     e.preventDefault(); // Prevent default action of anchor tag
    //
    //     var tabId = $(this).data('tab'); // Get the tab ID from data-tab attribute
    //     openTab(tabId); // Call openTab function with the tab ID
    // });
    //
    // // Function to open the specified tab
    // function openTab(tabId) {
    //     // Hide all tab panes and remove active class from nav links
    //     $('.tab-pane').removeClass('show active');
    //     $('.nav-link').removeClass('active');
    //
    //     // Show the selected tab and add active class to the corresponding nav link
    //     $('#pills-' + tabId).addClass('show active');
    //     $('button[data-bs-target="#pills-' + tabId + '-tab"]').addClass('active');
    // }

    if($('.product-listing').length){
        var currentUrl = window.location.href;
        var url = new URL(currentUrl);
        var type = url.searchParams.get("type");
        console.log("Type:", type);

        if(type){
            $('#pills-tab').find('.active').removeClass('active');
            $('#pills-tabContent').find('.active.show').removeClass('active show');
            $("#pills-"+ type +"-tab").addClass('active');
            $('#pills-'+type).addClass('active show');
        }
    }

});

