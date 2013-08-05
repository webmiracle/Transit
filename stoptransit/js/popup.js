(function($){
    $(document).ready(
        function(){
            homepagePopup('.homepagePopup');
        }
    );

    var homepagePopup = function(el){
        var self = $(el),
            $close = $('<a/>',{'class':'hP-close','href':'javascript:void(0)'});

        self.prepend($close);
        self.show();

        $close.bind('click',function(e){
            e.preventDefault();
            self.hide();
            $.cookie('show_popup',1, { expires: 30, path: '/' });
        })
        self.find('.hP-links a').each(function(){
            $(this).click(function(){
                $.cookie('show_popup',1, { expires: 30, path: '/' });
            })
        })

    }
})(jQuery);