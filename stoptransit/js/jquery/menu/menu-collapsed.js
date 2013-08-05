function initMenu() {
  jQuery('#nav ul').hide();
  jQuery('#nav li.active a.level-top').click(
    function() {
        jQuery(this).next().slideToggle('normal');
		return false;
      }
    );

	jQuery('.active ul').show();
  }
jQuery(document).ready(function() {initMenu();

});



jQuery.noConflict();