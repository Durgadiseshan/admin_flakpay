

const Auth = function () {

    const slider = function() {
        $('.js-slider').slick({
            dots: true,
            infinite: false,
            speed: 500,
            fade: true,
            arrows: false
        });
    }


    return {
        init: function () {
            slider();
        }
    };
}();

$(document).ready(function () {
    Auth.init();
});
