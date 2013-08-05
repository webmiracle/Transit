jQuery(document).ready(function () {	
	
	jQuery('#nav-footer li').hover(
		function () {
			//show its submenu
			jQuery('ul', this).slideDown(400);

		}, 
		function () {
			//hide its submenu
			jQuery('ul', this).slideUp(400);			
		}
	);
	
});

jQuery.noConflict();