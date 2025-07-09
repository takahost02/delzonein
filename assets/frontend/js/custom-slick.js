(function ($) {
    "use strict";

    /**=========================
        CAROUSEL
    =========================**/
    // items carousel
    var items_items = $('.items-carousel').data('item');
    $(".items-carousel").not(".slick-initialized").slick({
        arrows: true,
        slidesToShow: items_items,
        autoplay: false,
        dots: false,
        variableWidth: false,
        centerMode: true,
        centerPadding: "0",
        pauseOnHover: false,
        pauseOnFocus: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });

})(jQuery);
