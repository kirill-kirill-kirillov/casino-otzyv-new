$(document).ready(function () {
    +function ($) {
        "use strict";

        $('a').each(function (){
            let href = $(this).attr('href');

            if ( href === window.location.href ) {
                $(this).removeAttr('href');
            }
        });

        /*$('.rmp-rating-widget__icons-list__icon').on('click', function (){
            setTimeout(function (){
                location.reload();
            }, 500);
        });*/

        $('.trust-players').each(function (){
            let $this = $(this);
            let value = $this.find('.trust-players__value span').text();

            $this.find('.trust-players__line span').css({
                'width': value + '%'
            });
        });

        $('.block-answers__item').on('click', function (){
            $(this).siblings('.block-answers__item').removeClass('active');
            $(this).siblings('.block-answers__item').find('.block-answers__item-answer').slideUp();

            $(this).toggleClass('active');
            $(this).find('.block-answers__item-answer').slideToggle();
        });

        $('.block-anchors__title').on('click', function (){
            $(this).toggleClass('active');
            $(this).siblings('.block-anchors__block').slideToggle();
        });

        $('.comment-reply-link').on('click touchstart', function (){
            $('.comment-respond').addClass('response-reply');
        });

        $('#cancel-comment-reply-link').on('click touchstart', function (){
            $('.comment-respond').removeClass('response-reply');
        });

        $('.scroll-btn').click(function(event) {
            event.preventDefault();

            var href=$(this).attr('href');
            var target=$(href);
            var top=target.offset().top;
            $('html,body').animate({
                scrollTop: top - 20
            }, 1000);
        });

        //$('.js-example-basic-single').select2();

        setTimeout(function() {
            $('.js-select').styler();
        }, 100)

        $('#check_game_btn').on('click', function (e){
            e.preventDefault();

            $('.review-check-game__success').show();
        });

        $('.mobile-open').on('click', function (){
            $(this).toggleClass('open');
            $('body').toggleClass('hidden');
            $('.header__menu').toggleClass('open');
        });

        $(document).on('click', '.js-rmp-rating-item', function(e) {
            e.preventDefault();

            var $self = $(this);
            var id = $self.closest('.js-rmp-widgets-container').data('post-id');
            var data = {
                action: 'pr_update_rating',
                nonce_code: cj_ajax.nonce,
                id: id
            };

            setTimeout(function() {
                $.post(cj_ajax.url, data, function(res) {
                    if (!res.success) return;

                    $('.rmp-rating-widget__results').html(res.data.html.rating.current);
                    $('.rating-view__number').html(res.data.html.rating.current);
                    $('.votes-count').html(res.data.html.rating.count);
                    $('.rating-view__stars').html(res.data.html.rating.stars);
                });
            }, 1000);
        });

        $('.submenu-arrow').on('click', function (){
            $(this).toggleClass('active');
            $(this).siblings('.submenu').slideToggle();
        });

    }(window.jQuery);
});