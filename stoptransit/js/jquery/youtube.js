jQuery(document).ready(function () {
	jQuery('iframe').each(function() {
		var url = jQuery(this).attr("src")
		jQuery(this).attr("src",url+"?wmode=transparent")
});
});

jQuery.noConflict();