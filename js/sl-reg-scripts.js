jQuery(document).ready(function() {
    jQuery('.sl_parent_topic input').each(function() {
        if(jQuery(this).is(':checked')) {
            var _id = jQuery(this).attr("value");
            jQuery('.sl_childof_'+_id).find(':checkbox').each(function() {
                jQuery(this).parent().removeClass('sl-hide');
                
            });
        }
    });
    jQuery('.sl_parent_topic input').change(function() {
        /*
        var classes = jQuery(this).parent().prop("classList");
        var topic_id_class = classes[classes.find(function(element) {
            return element.search("sl_topic_");
        })];
        */
        var parent_id = jQuery(this).attr("value");
        var sibs = jQuery(this).parent().siblings().hasClass("sl_childof_"+parent_id);

        if(jQuery(this).is(':checked')) {
            /*
            if (jQuery(this).parent().siblings().hasClass("sl_childof_"+parent_id)) {
                var childof = "sl_childof_"+parent_id;
                console.log(childof);
                console.log("classes:");
                var classList = jQuery(this).parent().siblings().attr('class').split(/\s+/);
                for (var i = 0; i < classList.length; i++) {
                    console.log(classList[i]);
                    if (classList[i] == childof) {
                        console.log("=> do something");
                        this.removeClass('sl-hide');
                    }
                }
                
                if (jQuery(this).parent().siblings('.sl_childof_'+parent_id+'').hasClass('sl-hide')) {
                    console.log("does has");
                    jQuery(this).parent().siblings().removeClass('sl-hide');
                } 
            } */
            jQuery('.sl_childof_'+parent_id).removeClass('sl-hide');
            jQuery('.sl_childof_'+parent_id).find(':checkbox').each(function() {
                jQuery(this).prop('checked', true);
            });
        } else {
            jQuery('.sl_childof_'+parent_id).find(':checkbox').each(function() {
                jQuery(this).prop('checked', false);
            });
            jQuery('.sl_childof_'+parent_id).addClass('sl-hide');
            /*
            if (jQuery(this).parent().siblings().hasClass("sl_childof_"+parent_id)) {
                console.log("no has");
                jQuery(this).parent().siblings().addClass('sl-hide');
            } */
    }
    });
});