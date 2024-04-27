
function showJobDescription(jobid){
  if(jobid!=""){
    $.ajax({
      type: "GET",
      url: "/career/job/description/"+jobid,
      dataType: "json",
      success: function (response) {
        if(typeof response != undefined && Object.keys(response).length > 0){
          $.each(response[response.length-1],function(key,value){
            $("#"+key).html(value);
          });
          $("#job-description-modal").modal({show:true,backdrop:"static",keyboard:false});
        }
      }
    });
  }
}

function openJobForm(jobid){
  $("#job_id").val(jobid);
  $("#job-application-form")[0].reset();
  $("#job-apply-modal").modal({show:true,backdrop:"static",keyboard:false});
}

function showJobDescription(element){
  var id = $(element).data("id");
  $("#job-description-"+id).slideToggle();
}

$("#job-application-form").submit(function(e){
  e.preventDefault();
  var formdata = $("#job-application-form")[0];
  var data = new FormData(formdata);
  $.ajax({
    type:"POST",
    url:"/career/job/apply",
    data:data,
    cache:false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if(response.status){
        $("#modal-title").html(response.message);
        $("#job-apply-modal").modal("hide");
        $("#job-application-form")[0].reset();
        $("#response-modal").modal({show:true,backdrop:"static",keyboard:false});
      }else{
        if(typeof response.errors != undefined && Object.keys(response.errors).length > 0){
          $.each(response.errors,function(key,value){
            $("#job-application-form #"+key+"_error").html(value[0]);
            $("#job-application-form input[name="+key+"]").click(function(){
              $("#job-application-form #"+key+"_error").html("");
            });
          });

        }else{
          $("#modal-title").html(response.message);
          $("#response-modal").modal({show:true,backdrop:"static",keyboard:false});
        }
      }
    }
  });
});

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


  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  $(".transition").hover(function () {
    $(this).addClass("image-rectangle");
    $(this).removeClass("image-polygon");
      
    }, function () {
      $(this).addClass("image-polygon");
      $(this).removeClass("image-rectangle");
    }
  );
  
//footer year
document.getElementById("year").innerHTML = new Date().getFullYear();