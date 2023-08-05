$(function(){
    // fade in
    window.onload = function() {
        setTimeout(function(){
                scroll_effect();
                $('.js-anime').addClass('is_animated');
        },200);
    }
    $(window).scroll(function() {
            scroll_effect();
    });

    //fadein
    function scroll_effect() {
        $('.js-anime-elem').each(function() {
            var elemPos = $(this).offset().top,
                scrollPos = $(window).scrollTop(),
                windowHeight = $(window).height();
            if ( scrollPos > elemPos - windowHeight + 350 ) {
                $(this).addClass('is_animated');
            }
        });
    }
});
