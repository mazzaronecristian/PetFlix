(function($){
    $.fn.popup = function(){
        return this.each(function(){
            let $popup = $(this);
            let $closeBtn = $('.close-button', $popup);
            let overlay = document.getElementsByClassName("overlay");
            let $overlay = $(overlay);
            let parent = $popup.parent();
            let $parent = $(parent);
            let $openButton = $('.open-popup', $parent);

            $closeBtn.on('click', function(){
                console.log("CLOSED!");
                $popup.removeClass('active');
                $overlay.removeClass('active');
            });

            $overlay.on('click', function(){
                $popup.removeClass('active');
                $overlay.removeClass('active');
                console.log("CLOSED!");

            });

            $openButton.on('click', function(){
                console.log('OPENED!');
                $popup.addClass('active');
                $overlay.addClass('active');
            });
        });
    };
})(jQuery);