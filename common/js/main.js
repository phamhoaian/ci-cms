jQuery(document).ready(function($) {
    "use strict";
    
    $(function() {
		// Keep track of last scroll
		var lastScroll = 0;
		var header = $("#header");
		var headerTopRow = $(".header-top-row");
		var headerFixed = $("#header-main-fixed");
		var headerFixedBg = $(".header-bg");
		$(window).scroll(function() {
			// Sets the current scroll position
            var st = $(this).scrollTop();
            // Determines up-or-down scrolling
            if (st > lastScroll) {
            	// Replace this with your function call for downward-scrolling
            	if (st > 50) {
            		header.addClass("header-top-fixed");
            		headerTopRow.addClass("hidden");
            		headerFixed.addClass("header-main-fixed");
            		headerFixedBg.addClass("header-bg-fixed");
            	}
            }
            else {
            	// Replace this with your function call for upward-scrolling
            	if (st < 50) {
            		header.removeClass("header-top-fixed");
            		headerTopRow.removeClass("hidden");
            		headerFixed.removeClass("header-main-fixed");
            		headerFixedBg.removeClass("header-bg-fixed");
            	}
            }
            // Updates scroll position
            lastScroll = st;
		});
    });
});