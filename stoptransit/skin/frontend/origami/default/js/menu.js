jQuery.fn.mainMenu = function () {
    jQuery(this).each(function () {
        var mainItem = jQuery(this),
            mainWidth = mainItem.width() + parseInt(mainItem.css('padding-left')) * 2,
            mainItems = mainItem.find('li.level-top'),
            subItems = mainItems.find('div.sub-menu');

        subItems.each(function (indx, val) {
            var el = jQuery(this),
                elWidth = el.find('.sub-menu-col').length * 150;
            if (!el.hasClass('complex-menu')) {
                el.css('width', elWidth);
                elWidth = elWidth + 40;
                var delta = (mainItem.offset().left + mainWidth) - (el.offset().left + elWidth);
                if (delta < 0) {
                    el.css('left', (delta - 20));
                }
            } else {
                var complexCols = el.find('.complex-submenu'),
                    complexNav = el.find('.complex-nav li');
                complexNav.each(function () {
                    jQuery(this).bind('mouseenter', function () {
                        complexCols.hide();
                        complexNav.removeClass('active');
                        complexCols.eq(jQuery(this).index()).show();
                        complexNav.eq(jQuery(this).index()).addClass('active');
                    });
                });
                var delta = (mainItem.offset().left + mainWidth) - (el.offset().left + 600);
                if (delta < 0) {
                    el.css('left', (delta - 70));
                }
            }
        })

        mainItems.each(function(indx, val){
            if((indx) >= mainItems.length/2){
                jQuery(this).addClass('menu-right')
            }
        })

        mainItems.on('mouseenter', function () {
            var el = jQuery(this).addClass('hovered');
            var complexCols = el.find('.complex-submenu'),
                complexNav = el.find('.complex-nav li');
            if (complexCols.length && complexNav.length) {
                complexCols.hide();
                complexNav.removeClass('active');
                complexCols.eq(0).show();
                complexNav.eq(0).addClass('active');
            }

        })
            .on('mouseleave', function () {
                jQuery(this).removeClass('hovered');
            });
    })
};

$(document).observe('dom:loaded', function () {
    jQuery('#top_menu_block').mainMenu();
});
jQuery(window).load(function () {
    jQuery('#top_menu_block').mainMenu();
});
