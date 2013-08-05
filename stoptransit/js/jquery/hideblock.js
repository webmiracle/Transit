
jQuery(document).keyup(function(event){
	if(event.altKey && event.ctrlKey && event.keyCode == 73){
		alert('Создатель: Батраков Владимир\nEmail: xtarantulz@mail.ru\nДизайн сайта: Студия дизайна "Оригами"\nЖитомир 2012');
	}
});
jQuery(document).ready(function(){
	jQuery(".click-for-hide-left").click(function(){
		jQuery(".left-sidebar").toggle("slow");
		return false;
    });

});
jQuery(document).ready(function(){
    jQuery(".footer-button a").click(function(){
        jQuery(".footer").slideToggle("slow");
        jQuery(this).toggleClass("hideactive"); 
		return false;
    });
});

jQuery(document).ready(function(){
	jQuery('.close_alert').click(function(){
		jQuery('.fon_back_alert').hide();
		jQuery('.back_alert').hide();
	});
	setInterval('smena_banner()', 15000);
	
	
	
});
function smena_banner(){
		var ff=0;
		jQuery('.banner_main').each(function(){
			if(ff==0){
				if(jQuery(this).css('display')=='block'){
					jQuery(this).fadeOut(1000);
					ff=1;
				}
			}else{
				if(ff==1){
					if(jQuery(this).css('display')=='none'){
						jQuery(this).fadeIn(1000);
						ff=2;
					}
				}
			}
		});
		
		if(ff==1){
			if(jQuery('.first_banner_main').css('display')=='none'){
				jQuery('.first_banner_main').fadeIn(1000);
				ff=2;
			}
		}
	}


jQuery(document).ready(function(){
    jQuery(".leftclickhide").click(function(){
        jQuery(".left-sidebar").toggle("slow");
		return false;
    });

});


jQuery(document).ready(function(){ 

	var n = jQuery(".currently a").length;

	if (n > 1) {
		jQuery(".left-sidebar").css("display", "block");
	}
	else {
		jQuery(".left-sidebar").css("display", "none");
	}

});


jQuery.noConflict();