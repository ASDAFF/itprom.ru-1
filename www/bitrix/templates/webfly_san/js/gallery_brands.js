$(document).ready(function() {

    var carouselOptions = {
        // auto: true,
        circular: true,
        autoWidth: true,
        responsive: true,
        visible: 4,
        speed: 300,
        pause: true,
        btnPrev: function() {
            return $(this).find('.prev_brands');
        },
        btnNext: function() {
            return $(this).find('.next_brands');
        }
    };

    $('div.slideshow_brands').jCarouselLite(carouselOptions);

});