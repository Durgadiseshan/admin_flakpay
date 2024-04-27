
    //===== Sticky

    // $(window).on('scroll', function (event) {
    //     var scroll = $(window).scrollTop();
    //     if (scroll < 20) {
    //         $(".navbar-area").removeClass("sticky");
    //         $(".navbar .navbar-brand img").attr("src", "assets/img/final-img.png");
    //     } 
    //     else {
    //         $(".navbar-area").addClass("sticky");
    //         $(".navbar .navbar-brand img").attr("src", "assets/img/final-img.png");
    //     }
    // });  



    //===== Section Menu Active

    // var scrollLink = $('.page-scroll');
    // Active link switching
    // $(window).scroll(function () {
    //     var scrollbarLocation = $(this).scrollTop();

    //     scrollLink.each(function () {

    //         var sectionOffset = $(this.hash).offset().top - 73;

    //         if (sectionOffset <= scrollbarLocation) {
    //             $(this).parent().addClass('active');
    //             $(this).parent().siblings().removeClass('active');
    //         }
    //     });
    // });


    //===== close navbar-collapse when a  clicked

    // $(".navbar-nav a").on('click', function (e) {
    //     e.preventDefault();
    //     $(".navbar-collapse").removeClass("show");
    // });

    // $(".navbar-toggler").on('click', function () {
    //     $(this).toggleClass("active");
    // });

    // $(".navbar-nav a").on('click', function () {
    //     $(".navbar-toggler").removeClass('active');
    // });    
    

//jQuery for page scrolling feature - requires jQuery Easing plugin
// $(function() {

//     $('a.page-scroll[href*="#"]:not([href="#"])').on('click', function () {
//         if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
//             var target = $(this.hash);
//             target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
//             if (target.length) {
//                 $('html, body').animate({
//                     scrollTop: (target.offset().top -60)
//                 }, 1200, "easeInOutExpo");
//                 return false;
//             }
//         }
//     });

// });


//side bar
// function openLeft() {
//     document.getElementById("leftMenu").style.display = "block";
//   }

//   function closeLeftMenu() {
//     document.getElementById("leftMenu").style.display = "none";
//   }

// HEADER ANIMATION
// window.onscroll = function() {scrollFunction()};
// var element = document.getElementById("body");
// function scrollFunction() {
//   if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
//       $(".navbar").addClass("fixed-top");
//       element.classList.add("header-small");
//       $("body").addClass("body-top-padding");

//   } else {
//       $(".navbar").removeClass("fixed-top");
//       element.classList.remove("header-small");
//       $("body").removeClass("body-top-padding");
//   }
// }

// OWL-CAROUSAL
$('.owl-carousel').owlCarousel({
    items: 3,
    loop:true,
    nav:false,
    dot:true,
    autoplay: true,
    slideTransition: 'linear',
    autoplayHoverPause: true,
    responsive:{
      0:{
          items:1
      },
      600:{
          items:2
      },
      1000:{
          items:3
      }
  }
})

// SCROLLSPY
$(document).ready(function() {
  $(".nav-link").click(function() {
      var t = $(this).attr("href");
      $("html, body").animate({
          scrollTop: $(t).offset().top - 75
      }, {
          duration: 1000,
      });
      $('body').scrollspy({ target: '.navbar',offset: $(t).offset().top });
      return false;
  });

});

// AOS
AOS.init({
    offset: 120, 
    delay: 0,
    duration: 1200, 
    easing: 'ease', 
    once: true, 
    mirror: false, 
    anchorPlacement: 'top-bottom', 
    disable: "mobile"
  });

//SIDEBAR-OPEN
  $('#navbarSupportedContent').on('hidden.bs.collapse', function () {
    $("body").removeClass("sidebar-open");
  })

  $('#navbarSupportedContent').on('shown.bs.collapse', function () {
    $("body").addClass("sidebar-open");
  })


  window.onresize = function() {
    var w = window.innerWidth;
    if(w>=786) {
      $('body').removeClass('sidebar-open');
      $('#navbarSupportedContent').removeClass('show');
    }
  }
  


  //
  $(function () {
    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > 100 ) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });
});


// $(window).scroll(function(){
//     var sticky = $('.sticky'),
//         scroll = $(window).scrollTop();
  
//     if (scroll >= 20) sticky.addClass('fixed');
//     else sticky.removeClass('fixed');
//   });