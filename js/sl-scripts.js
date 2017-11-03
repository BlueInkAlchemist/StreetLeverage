jQuery(document).ready(function() {
    jQuery('p').each(function() {
        var $this = jQuery(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
    });
    jQuery(function($){
        $('.matchheight').matchHeight();
	});
    jQuery('.bxslider').bxSlider();
    jQuery('.essb_item a').on('click', function() {
        console.log("Yay!");
        sl_share_popup_close();
    });
    jQuery(".sl-share-popup-shadow").hide();
    jQuery('.sl-like-logged-out').on('click', function() {
        if (jQuery(this).parent().children( ".like-login" ).hasClass("sl-hide")) {
            console.log("does has");
            jQuery(this).parent().children( ".like-login" ).removeClass("sl-hide");
        } else {
            console.log("no has");
            jQuery(this).parent().children( ".like-login" ).addClass("sl-hide");
        }
    });
});

var sl_share_popup_close = function() {
    jQuery(".sl-share-popup").fadeOut(200);
    jQuery(".sl-share-popup-shadow").fadeOut(400);
}

var sl_share_popup_show = function() {
    jQuery.fn.extend({
        center: function () {
            return this.each(function() {
                var top = (jQuery(window).height() - jQuery(this).outerHeight()) / 2;
                var left = (jQuery(window).width() - jQuery(this).outerWidth()) / 2;
                jQuery(this).css({position:'fixed', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
            });
        }
    });

    var element = jQuery('.sl-share-popup');
    if (!element.length) { return; }

    var popWidth = jQuery(element).attr("data-width") || "";
    var popHideOnClose = jQuery(element).attr("data-close-hide") || "";
    var popHideOnCloseAll = jQuery(element).attr("data-close-hide-all") || "";
    var popPostId = jQuery(element).attr("data-postid") || "";

    var popAutoCloseAfter = jQuery(element).attr("data-close-after") || "";

    if (popHideOnClose == "1" || popHideOnCloseAll == "1") {
        var cookie_name = "";
        var base_cookie_name = "essb_popup_";
        if (popHideOnClose == "1") {
            cookie_name = base_cookie_name + popPostId;

            var cookieSet = essbGetCookie(cookie_name);
            if (cookieSet == "yes") { return; }
            essbSetCookie(cookie_name, "yes", 7);
        }
        if (popHideOnCloseAll == "1") {
            cookie_name = base_cookie_name + "all";

            var cookieSet = essbGetCookie(cookie_name);
            //console.log("cookie exist all =" + cookieSet);
            if (cookieSet == "yes") { return; }
            essbSetCookie(cookie_name, "yes", 7);
        }
    }

    var win_width = jQuery( window ).width();
    var doc_height = jQuery('document').height();

    var base_width = 800;
    var userwidth = popWidth;
    if (Number(userwidth) && Number(userwidth) > 0) {
        base_width = userwidth;
    }

    if (win_width < base_width) { base_width = win_width - 60; }

    // automatically close
    if (Number(popAutoCloseAfter) && Number(popAutoCloseAfter) > 0) {
        shortly = new Date();
        var user_message = jQuery('#essb_settings_popup_user_autoclose').text();
        if (user_message == '') {
            user_message = "Window will automatically close in ";
        }
        shortly.setSeconds(shortly.getSeconds() + Number(popAutoCloseAfter));
        jQuery('.essb_popup_counter_text').countdown({until: shortly, onExpiry: essb_popup_close, "layout" : user_message + " {sn} {sl}"});
    }

    jQuery(".sl-share-popup").css( { width: base_width+'px'});
    jQuery(".sl-share-popup").center();

    jQuery(".sl-share-popup").fadeIn(400);
    jQuery(".sl-share-popup-shadow").fadeIn(200);


}