// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
require("./styles/app.scss");
import "./styles/app.scss";
import "animate.css";

const $ = require("jquery");

require("bootstrap");
import "bootstrap";

// import Swiper JS
import Swiper from "swiper";
import { Autoplay, EffectFade, Navigation } from "swiper/modules";
// import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

import { CountUp } from "countup.js";

//
// import tinymce from "../public/bundles/tinymce/ext/tinymce/tinymce";
// import "../public/bundles/tinymce/ext/tinymce/models/dom/model";
// import "../public/bundles/tinymce/ext/tinymce/skins/ui/oxide/skin.css";
// import "../public/bundles/tinymce/ext/tinymce/skins/ui/oxide/skin.min.css";
// import "../public/bundles/tinymce/ext/tinymce/skins/content/default/content.css";
// import "../public/bundles/tinymce/ext/tinymce/skins/content/default/content.min.css";
// import "../public/bundles/tinymce/ext/tinymce/skins/ui/oxide/content.css";
// import "../public/bundles/tinymce/ext/tinymce/themes/silver/theme";
// import "../public/bundles/tinymce/ext/tinymce/icons/default/icons";

document.addEventListener("DOMContentLoaded", function () {
  const imageObserver = new IntersectionObserver((entries, imgObserver) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const lazyImage = entry.target;
        lazyImage.src = lazyImage.dataset.src;
      }
    });
  });
  const arr = document.querySelectorAll(".lazy_img");
  arr.forEach((v) => {
    imageObserver.observe(v);
  });
});

$(document).ready(function () {
  $(".hover-card").hover(
    function () {
      // On hover in: Show the content with a smooth fade-in effect
      $(this)
        .find(".hover-content")
        .removeClass("d-none")
        .css({
          opacity: 0, // Start transparent
          transition: "opacity 0.3s ease", // Smooth transition
        })
        .animate({ opacity: 1 }, 300); // Fade in
    },
    function () {
      // On hover out: Hide the content with a smooth fade-out effect
      $(this)
        .find(".hover-content")
        .animate({ opacity: 0 }, 300, function () {
          $(this).addClass("d-none"); // Hide after animation
        });
    }
  );
  // tinymce.init({
  //     selector: 'textarea'
  // })

  //Sample dates
  var dates = [
    "6/12/1995",
    "2/15/1996",
    "10/22/2000",
    "5/5/2005",
    "8/15/2010",
    "11/2/2018",
    "12/22/2019",
    "3/10/2022",
    "6/1/2024",
  ];
  //For the purpose of stringifying MM/DD/YYYY date format
  var monthSpan = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  //Format MM/DD/YYYY into string
  function dateSpan(date) {
    console.log(date);
    var month = date.split("/")[0];
    month = monthSpan[month - 1];
    var day = date.split("/")[1];
    if (day.charAt(0) == "0") {
      day = day.charAt(1);
    }
    var year = date.split("/")[2];

    //Spit it out!
    return month + " " + day + ", " + year;
  }
  function dateDescSpan(date) {
    console.log(date);
    switch (date) {
      case "6/12/1995":
        return '<h2 class="text-tertiary fw-bold mt-3">Company Formation</h2><p class="text-primary font-16">On this day, we officially founded our company with a vision to lead the industry.</p>';
      case "2/15/1996":
        return '<h2 class="text-tertiary fw-bold mt-3">First Major Order</h2><p class="text-primary font-16">We successfully secured our first major contract, marking a key milestone in our growth.</p>';
      case "10/22/2000":
        return '<h2 class="text-tertiary fw-bold mt-3">First Industry Award</h2><p class="text-primary font-16">We received our first award for excellence in quality and service, solidifying our reputation in the industry.</p>';
      case "5/5/2005":
        return '<h2 class="text-tertiary fw-bold mt-3">Global Expansion</h2><p class="text-primary font-16">We opened our first international office, marking the beginning of our global expansion efforts.</p>';
      case "8/15/2010":
        return '<h2 class="text-tertiary fw-bold mt-3">Innovation Award</h2><p class="text-primary font-16">We were recognized for our innovative approach in product development and operational efficiency.</p>';
      case "11/2/2018":
        return '<h2 class="text-tertiary fw-bold mt-3">Sustainability Initiative</h2><p class="text-primary font-16">Launched our company-wide sustainability initiative to reduce our environmental footprint.</p>';
      case "12/22/2019":
        return '<h2 class="text-tertiary fw-bold mt-3">Record-breaking Revenue</h2><p class="text-primary font-16">Achieved record-breaking revenue, thanks to our continuous innovation and customer satisfaction.</p>';
      case "3/10/2022":
        return '<h2 class="text-tertiary fw-bold mt-3">New Headquarters</h2><p class="text-primary font-16">Moved into our state-of-the-art headquarters, designed to foster collaboration and innovation.</p>';
      case "6/1/2024":
        return '<h2 class="text-tertiary fw-bold mt-3">30th Anniversary Celebration</h2><p class="text-primary font-16">Celebrated 30 years of growth, innovation, and customer satisfaction.</p>';
    }
  }

  //Main function. Draw your circles.
  function makeCircles() {
    //Forget the timeline if there's only one date. Who needs it!?
    if (dates.length < 2) {
      $("#line").hide();
      $("#span").show().text(dateSpan(dates[0]));
      //This is what you really want.
    } else if (dates.length >= 2) {
      //Set day, month and year variables for the math
      var first = dates[0];
      var last = dates[dates.length - 1];

      // Convert first and last dates to Date objects
      var firstDate = new Date(
        first.split("/")[2],
        first.split("/")[0] - 1,
        first.split("/")[1]
      );
      var lastDate = new Date(
        last.split("/")[2],
        last.split("/")[0] - 1,
        last.split("/")[1]
      );

      // Calculate the total number of days between the first and last dates
      var totalDays = Math.floor(
        (lastDate - firstDate) / (1000 * 60 * 60 * 24)
      );

      // Draw the first date circle
      $("#line").append(`
                <div class="circle" id="circle0" style="left: 0%;">
                    <div class="popupSpan text-white fw-semibold">${dateSpan(
                      dates[0]
                    )}</div>
                </div>
            `);
      $("#mainCont").append(
        `<span id="span0" class="center">${dateDescSpan(dates[0])}</span>`
      );

      // Loop through middle dates
      for (var i = 1; i < dates.length - 1; i++) {
        var currentDate = new Date(
          dates[i].split("/")[2],
          dates[i].split("/")[0] - 1,
          dates[i].split("/")[1]
        );
        var daysSinceFirst = Math.floor(
          (currentDate - firstDate) / (1000 * 60 * 60 * 24)
        );
        var relativePosition = (daysSinceFirst / totalDays) * 100;

        // Draw the date circle for each middle date
        $("#line").append(`
                    <div class="circle" id="circle${i}" style="left: ${relativePosition}%;">
                        <div class="popupSpan text-white fw-semibold">${dateSpan(
                          dates[i]
                        )}</div>
                    </div>
                `);
        $("#mainCont").append(
          `<span id="span${i}" class="right">${dateDescSpan(dates[i])}</span>`
        );
      }

      // Draw the last date circle
      $("#line").append(`
                <div class="circle" id="circle${i}" style="left: 99%;">
                    <div class="popupSpan text-white fw-semibold">${dateSpan(
                      dates[dates.length - 1]
                    )}</div>
                </div>
            `);
      $("#mainCont").append(
        `<span id="span${i}" class="right">${dateDescSpan(
          dates[dates.length - 1]
        )}</span>`
      );
    }

    $(".circle:first").addClass("active");
  }

  makeCircles();

  $(".circle").mouseenter(function () {
    $(this).addClass("hover");
  });

  $(".circle").mouseleave(function () {
    $(this).removeClass("hover");
  });

  $(".circle").click(function () {
    var spanNum = $(this).attr("id");
    selectDate(spanNum);
  });

  function selectDate(selector) {
    let $selector;
    $selector = "#" + selector;
    let $spanSelector;
    $spanSelector = $selector.replace("circle", "span");
    var current = $selector.replace("circle", "");

    $(".active").removeClass("active");
    $($selector).addClass("active");

    if ($($spanSelector).hasClass("right")) {
      $(".center").removeClass("center").addClass("left");
      $($spanSelector).addClass("center");
      $($spanSelector).removeClass("right");
    } else if ($($spanSelector).hasClass("left")) {
      $(".center").removeClass("center").addClass("right");
      $($spanSelector).addClass("center");
      $($spanSelector).removeClass("left");
    }
  }

  console.log();

  console.log("app");
  $(window).scroll(function () {
    $(".content").each(function () {
      var contentTop = $(this).offset().top;
      var contentBottom = contentTop + $(this).outerHeight();
      var windowTop = $(window).scrollTop();
      var windowBottom = windowTop + $(window).height();

      if (windowBottom > contentTop && windowTop < contentBottom) {
        $(this).addClass("visible");
      } else {
        $(this).removeClass("visible");
      }
    });
  });

  // Trigger scroll event on page load to check visibility
  $(window).scroll();
  var swiper = new Swiper(".mySwiper", {
    modules: [Autoplay],
    slidesPerView: 4,
    spaceBetween: 5,
    speed: 800,
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
    speed: 600,
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

  var swiperApp = new Swiper(".services-swiper", {
    modules: [Autoplay, Navigation],
    slidesPerView: 4,
    spaceBetween: 20,
    speed: 800,
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
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      0: {
        // Small screens (sm)
        slidesPerView: 1,
      },
      768: {
        // Medium screens (md)
        slidesPerView: 2,
      },
      1024: {
        // Large screens (lg+)
        slidesPerView: 4,
      },
    },
  });

  var swiperApp = new Swiper(".application-swipper", {
    modules: [Autoplay],
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    freeMode: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  const options = {
    duration: 5, // duration of the animation in seconds
  };

  const yearsInIndustry = new CountUp("yearsInIndustry", 27, options); // replace 10 with the actual number
  const yearsOfExpertise = new CountUp("yearsOfExpertise", 70, options); // replace 100 with the actual number
  const happyClients = new CountUp("happyClients", 150, options); // replace 200 with the actual number
  const successfulProjects = new CountUp("successfulProjects", 300, options); // replace 300 with the actual number
  const kilosOfSteel = new CountUp("kilosOfSteel", 400, options); // replace 400 with the actual number
  const monthlySale = new CountUp("monthlySale", 400, options); // replace 400 with the actual number

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
  monthlySale.start();

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

  if ($(".product-listing").length) {
    var currentUrl = window.location.href;
    var url = new URL(currentUrl);
    var type = url.searchParams.get("type");
    console.log("Type:", type);

    if (type) {
      $("#pills-tab").find(".active").removeClass("active");
      $("#pills-tabContent").find(".active.show").removeClass("active show");
      $("#pills-" + type + "-tab").addClass("active");
      $("#pills-" + type).addClass("active show");
    }
  }
});
