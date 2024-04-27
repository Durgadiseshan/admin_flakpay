


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
    
  
  
    //On scroll white
    $(function () {
      $(window).on('scroll', function () {
          if ( $(window).scrollTop() > 100 ) {
              $('.navbar').addClass('active');
          } else {
              $('.navbar').removeClass('active');
          }
      });
  });
  
  
  // Mega- menu
  $('.dropdown').hover(function() {
    $(this).find('.mega-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
    $(this).find('.mega-menu').stop(true, true).delay(200).fadeOut(500);
    });

// new header

    jQuery(document).ready(function($) {

      "use strict";
    
      // siteSliderRange();
    
    
      
      var siteCarousel = function () {
        if ( $('.nonloop-block-13').length > 0 ) {
          $('.nonloop-block-13').owlCarousel({
            center: false,
            items: 1,
            loop: true,
            stagePadding: 0,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 3000,
            smartSpeed: 800,
            nav: true,
            navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
            responsive:{
              600:{
                margin: 0,
                nav: true,
                items: 2
              },
              1000:{
                margin: 0,
                stagePadding: 0,
                nav: true,
                items: 3
              },
              1200:{
                margin: 0,
                stagePadding: 0,
                nav: true,
                items: 4
              }
            }
          });
        }
    
    
        if ( $('.nonloop-block-14').length > 0 ) {
          $('.nonloop-block-14').owlCarousel({
            center: false,
            items: 1,
            loop: true,
            stagePadding: 0,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 3000,
            smartSpeed: 800,
            nav: true,
            navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">'],
            responsive:{
              600:{
                margin: 20,
                nav: true,
                items: 2
              },
              1000:{
                margin: 30,
                stagePadding: 0,
                nav: true,
                items: 3
              },
              1200:{
                margin: 30,
                stagePadding: 0,
                nav: true,
                items: 4
              }
            }
          });
        }
    
        $('.slide-one-item').owlCarousel({
          center: false,
          items: 1,
          loop: true,
          stagePadding: 0,
          margin: 0,
          autoplay: true,
          autoplayTimeout: 3000,
          pauseOnHover: false,
          nav: true,
          navText: ['<span class="icon-keyboard_arrow_left">', '<span class="icon-keyboard_arrow_right">']
        });
    
        $('.slide-one-item-alt').owlCarousel({
          center: false,
          items: 1,
          loop: true,
          stagePadding: 0,
          margin: 0,
          smartSpeed: 1000,
          autoplay: true,
          autoplayTimeout: 3000,
          pauseOnHover: true,
          onDragged: function(event) {
            console.log('event : ',event.relatedTarget['_drag']['direction'])
            if ( event.relatedTarget['_drag']['direction'] == 'left') {
              $('.slide-one-item-alt-text').trigger('next.owl.carousel');
            } else {
              $('.slide-one-item-alt-text').trigger('prev.owl.carousel');
            }
          }
        });
        $('.slide-one-item-alt-text').owlCarousel({
          center: false,
          items: 1,
          loop: true,
          stagePadding: 0,
          margin: 0,
          smartSpeed: 1000,
          autoplay: true,
          autoplayTimeout: 3000,
          pauseOnHover: true,
          onDragged: function(event) {
            console.log('event : ',event.relatedTarget['_drag']['direction'])
            if ( event.relatedTarget['_drag']['direction'] == 'left') {
              $('.slide-one-item-alt').trigger('next.owl.carousel');
            } else {
              $('.slide-one-item-alt').trigger('prev.owl.carousel');
            }
          }
        });
    
        
    
    
        $('.custom-next').click(function(e) {
          e.preventDefault();
          $('.slide-one-item-alt').trigger('next.owl.carousel');
          $('.slide-one-item-alt-text').trigger('next.owl.carousel');
        });
        $('.custom-prev').click(function(e) {
          e.preventDefault();
          $('.slide-one-item-alt').trigger('prev.owl.carousel');
          $('.slide-one-item-alt-text').trigger('prev.owl.carousel');
        });
    
        
    
    
      };
      siteCarousel();
    

    
    
    });