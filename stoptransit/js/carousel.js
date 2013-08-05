(function($){

    $(document).ready(function(){
        new carousel();
    });

    Function.prototype.binding = function(object) {
        var method = this;
        return function() {
            method.apply(object, arguments);
        }
    };

    function carousel(){
        this.maxSlidesNum       =   6,
            this.carousel           =   $(".carousel"),
            this.cWidth             =   660,
            this.cItemWidth         =   $("li", this.carousel).width(),
            this.ul                 =   $("ul", this.carousel),
            this.cItems             =   $("li", this.carousel).length;
        this.uWidth             =   this.cItems*this.cItemWidth;
        this.slideTime          =   this.cItems * 1000;
        this.slideTimeOnClick   =   this.cItems * 500;
        this.timer              =   this.getSlide();
        this.pause              =   false;
        this.flag              =    false;

        if(this.cItems > this.maxSlidesNum){
            var $_lt = $('li:lt('+ this.maxSlidesNum +')', this.ul).clone(),
                $_gt = $('li:gt('+ (this.cItems - this.maxSlidesNum - 1) +')', this.ul).clone();
            this.ul.append($_lt).prepend($_gt);
            this.ul.css('margin-left', -this.cWidth);
            $(".backImages.carousel-nav, .nextImages.carousel-nav").addClass("on");
            $(".backImages.carousel-nav").bind('mousedown', {obj: this, dest: 1}, this.clickHandler);
            $(".nextImages.carousel-nav").bind('mousedown', {obj: this, dest: -1}, this.clickHandler);
            $(".backImages.carousel-nav, .nextImages.carousel-nav").bind('mouseup', function(){
                clearInterval(this.timer);
                this.timer = false;
                this.pause = true;
                this.flag = false;
                this.ul.stop();
            }.binding(this));
            $(".backImages.carousel-nav, .nextImages.carousel-nav").bind('mouseleave', function(){
                this.ul.stop();
                this.getSlide();
            }.binding(this));
            this.carousel.bind('mouseover mouseleave mousemove', {obj: this, dest: -1}, function(e){
                if (e.type == 'mouseover'){
                    this.pause = true;
                    this.ul.stop();
                } else if (e.type == 'mouseleave'){
                    this.ul.stop();
                    this.getSlide();
                } else if(e.type == 'mousemove'){
                    var move = e.clientX - this.carousel.offset().left,
                        k = this.cItems *  this.cItemWidth /  this.cWidth;

                    this.ul.css('margin-left', -move*k );

                };
                e.preventDefault();
            }.binding(this));
        };
    };

    carousel.prototype.getSlide = function(val, isClick){
        this.ul.stop();
        var func = arguments.callee,
            self = this,
            destination = (val&& val > 0) ? 1 : -1,
            delta = (destination > 0) ? 0 : -this.uWidth,
            pos         = Math.round(Math.abs(parseInt(this.ul.css('margin-left')))),
            slideTime   = (isClick && isClick === 'click') ? this.slideTimeOnClick : this.slideTime;

        if (this.pause == true){
            this.pause = false;
            slideTime = (destination > 0) ? slideTime*(Math.abs(pos))/(this.uWidth) : slideTime*(this.uWidth - Math.abs(pos))/(this.uWidth);
        };
        if ((pos <= 0 && destination > 0)){
            this.ul.css({"margin-left": -this.uWidth + 'px' });
        } else if (pos >= this.uWidth && destination < 0){
            this.ul.css({"margin-left": 0 + 'px' });
        };
        slideTime = (pos == this.cWidth) ? slideTime : slideTime*this.uWidth/(this.uWidth - this.cWidth);
        this.ul.animate({"margin-left": delta + 'px'}, slideTime, 'linear', function(){
            self.getSlide(val, isClick);
        });
    }; // <!>

    carousel.prototype.clickHandler = function(val){
        if ((val.data.dest && typeof val.data.dest !== 'number') || val.data.obj.ul.is(':animated') || val.data.obj.flag) return;
        val.data.obj.flag = true;
        this.pause = true;
        val.data.obj.getSlide(val.data.dest, 'click');
    }; // <!>


})(jQuery)