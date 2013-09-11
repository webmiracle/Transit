jQuery.fn.mainMenu = function(){
    jQuery(this).each(function(){
        var mainItem = jQuery(this),
            mainWidth = mainItem.width() + parseInt(mainItem.css('padding-left'))* 2,
            mainItems = mainItem.find('li.level-top'),
            subItems = mainItems.find('div.sub-menu');

        subItems.each(function(){
            var el = jQuery(this),
                elWidth = el.find('.sub-menu-col').length * 150;
            el.css('width', elWidth);
            elWidth = elWidth + 40;
            var delta = (mainItem.offset().left + mainWidth) - (el.offset().left + elWidth);
            if(delta < 0){
                el.css('left',delta-20);
            }
        })

        mainItems.on('mouseenter',function(){
            jQuery(this).addClass('hovered');
        })
            .on('mouseleave',function(){
                jQuery(this).removeClass('hovered');
            })
            .each(function(){

            });
    })
};

jQuery(document).ready(function(){
    jQuery('#top_menu_block').mainMenu();
});
