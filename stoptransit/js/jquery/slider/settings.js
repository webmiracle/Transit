jQuery(document).ready(function(){
    jQuery('#my-slideshow').bjqs({
        'width' : 660,
        'height' : 300,
        'showMarkers' : true,
        'showControls' : true,
        'centerMarkers' : false
    });
	
	jQuery('#my-slideshow1').bjqs1({
        'width' : 660,
        'height' : 300,
        'showMarkers' : true,
        'showControls' : true,
        'centerMarkers' : false
    });
	
	jQuery('#my-slideshow2').bjqs2({
        'width' : 660,
        'height' : 300,
        'showMarkers' : true,
        'showControls' : true,
        'centerMarkers' : false
    });
});

jQuery.noConflict();