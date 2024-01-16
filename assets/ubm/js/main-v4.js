jQuery(document).ready(function($) {

    $('.main-slider .slides').owlCarousel({
        loop:true,
        nav:true,
        dots:true,
        items:1,
        //autoplay: true,
        autoplayHoverPause:true,
        autoplayTimeout:4000,
        autoplaySpeed:2000,
        navSpeed:2000,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        margin:0,
    });
//
    $('.mainpage .news-block .news_block_item').each(function() {
         var src = $(this).find('a').attr('href');
         $(this).append('<a href="'+src+'" class="news-podrob">Подробнее</a>');
    });
//
    $('.burger-menu').click(function () {
        $(this).toggleClass('active');
        $('.top-menu ul').slideToggle(400);
    });
    $(document).click(function () {
        if ($('.burger-menu.active').length == 1) {
            $(document).mouseup(function (e){ // событие клика по веб-документу
                var div = $( (".top-menu ul") && (".burger-menu") ); // тут указываем ID элемента
                if (!div.is(e.target) // если клик был не по нашему блоку
                    && div.has(e.target).length === 0) { // и не по его дочерним элементам
                    $('.burger-menu.active').removeClass('active');
                    $('.top-menu ul').slideUp(400);
                }
            });
        }
    });
//
    $('.sidebar-catalog-menu .h3').click(function () {
        $(this).toggleClass('active');
        $('.sidebar-catalog-menu .catalog_menu').slideToggle(400);
    });
//
    $('.scroll-down-btn a').click(function(){
    //Сохраняем значение атрибута href в переменной:
    var target = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(target).offset().top
    }, 800);
    return false;
    });

// Мобильные блоки
    mobileBlocksMove();
    
    $(window).resize(function(event) {
        mobileBlocksMove();
    });
    
    function mobileBlocksMove() {
        if ($(window).width() <= 1000) {
            $(".f-sitename").insertBefore($(".f-contacts"));
            $(".f-mail").insertBefore($(".f-addr"));
        } else {
            $(".f-sitename").insertBefore($(".f-mail"));
            $(".f-mail").insertBefore($(".counters"));
        }
    }
//
});