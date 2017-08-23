$(document).ready(function() {
    var options = {
        auto: true,
        visible: 1,
        circular: true,
        speed: 1000,
        pause: true,
        btnGo: $('div.nav a'),
        btnNext: '.next',
        btnPrev: '.prev',
        activeClass: 'active'
    };


    $('.slideshow').jCarouselLite(options);

    $("a#single_cert_image").fancybox();
});