(function ($) {
    "use strict";

    /**=========================
        SELECT
    =========================**/
    $(".select2").select2();
    $(".select2-no-search").select2({
        minimumResultsForSearch: Infinity,
    });

    /**=========================
        DATE YEAR
    =========================**/
    var year = new Date().getFullYear();
    $("#year").html(year);
    $(".datepicker").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        calendarWeeks: true,
        todayHighlight: true
    });
    $(".datepicker").datepicker("setDate", "today");

    new DataTable('.datatable', {
        responsive: true,
        language: {
            'paginate': {
                'previous': 'Prev',
                'next': 'Next'
            }
        },
    });

    /**=========================
        EASING
    =========================**/
    $(".easing-click").click(function () {
        if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html, body").animate(
                    {
                        scrollTop: target.offset().top - 100,
                    },
                    1000,
                    "easeInOutExpo"
                );
                return false;
            }
        }
    });

    /**=========================
        BACK TO TOP
    =========================**/
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 300) {
            $(".backtotop").addClass("backtotop-bottom");
        } else {
            $(".backtotop").removeClass("backtotop-bottom");
        }
    });

     $('#privacyModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open'); // Remove the modal-open class
        $('.modal-backdrop').remove(); // Remove any remaining backdrop
     });
     $('#termsModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open'); // Remove the modal-open class
        $('.modal-backdrop').remove(); // Remove any remaining backdrop
     });

})(jQuery);
