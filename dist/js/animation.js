$(function(){
    // fade in
    window.onload = function() {
        setTimeout(function(){
            var layout = $('.js-media-query').css('font-family').replace(/"/g, '');
            if(layout === "pc") {
                scroll_effect();
                $('.js-anime').addClass('is_animated');
            }
        },500);
    }
    $(window).scroll(function() {
        var layout = $('.js-media-query').css('font-family').replace(/"/g, '');
        if(layout === "pc") {
            scroll_effect();
        }
    });

    //fadein
    function scroll_effect() {
        $('.js-anime-elem').each(function() {
            var elemPos = $(this).offset().top,
                scrollPos = $(window).scrollTop(),
                windowHeight = $(window).height();
            if ( scrollPos > elemPos - windowHeight ) {
                $(this).addClass('is_animated');
            }
        });
    }
});
