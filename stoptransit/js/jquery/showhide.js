/*footer*/
jQuery(document).ready(function(){
    jQuery(".footer-button a").click(function(){
        jQuery(".footer").slideToggle("slow");
        jQuery(this).toggleClass("hideactive"); 
		return false;
    });
});

/*headerpanel*/
jQuery(document).ready(function(){
	jQuery(".click-show-hide").click(function(){
        jQuery(".quick-access").toggle("slow");
        jQuery(this).toggleClass("activetopshow"); 
		return false;
    });
});




/*sliderhide*/
jQuery(document).ready(function(){
    jQuery(".special-header-panel a").click(function(){
        jQuery("#my-slideshow").toggle("slow");

		return false;
    });
});


jQuery.noConflict();