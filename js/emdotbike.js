/**
 * supporter functions for our theme
 */

/**
 * toggles the mobile nav
 */
jQuery(document).ready(function() {
    jQuery('.toggle-nav').click(function(e) {      
        jQuery('.main-navigation .emdb-nav').toggle(500);

        jQuery('i', this).toggleClass('dashicons-no-alt');

        e.preventDefault();
    });
});

/**
 * back to top button function
 */
jQuery(document).ready(function($) {
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.emdotbike-back-to-top');

    //hide or show the "back to top" link
    $(window).on('scroll', function() {
        ($(this).scrollTop() > offset) ? $back_to_top.addClass('btt-is-visible'): $back_to_top.removeClass('btt-is-visible btt-fade-out');
        if ($(this).scrollTop() > offset_opacity) {
            $back_to_top.addClass('btt-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event) {
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0,
        }, scroll_top_duration);
    });

});