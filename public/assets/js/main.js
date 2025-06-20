/*----------------------------------------------
*
* [Main Scripts]
*
* Theme    : Gameon
* Version  : 2.0
* Author   : Themeland
* Support  : hridoy1272@gmail.com
* 
----------------------------------------------*/

/*----------------------------------------------

[ALL CONTENTS]

1. Preloader
2. Responsive Menu
3. Navigation 
4. Slides
5. Load More
6. Shuffle
7. Contact Form

/*----------------------------------------------
1. Preloader
----------------------------------------------*/
(function ($) {
    'use strict';

    $(window).on('load', function() {
        $('#gameon-preloader').addClass('loaded');
    })

}(jQuery));

/*----------------------------------------------
2. Responsive Menu
----------------------------------------------*/
(function ($) {

    'use strict';

    function navResponsive() {

        let navbar = $('.navbar .items');
        let menu = $('#menu .items');

        menu.html('');
        navbar.clone().appendTo(menu);

        $('.menu .icon-arrow-right').removeClass('icon-arrow-right').addClass('icon-arrow-down');
    }

    navResponsive();

    $(window).on('resize', function () {
        navResponsive();
    })

    $('.menu .dropdown-menu').each(function() {

        var children = $(this).children('.dropdown').length;
        $(this).addClass('children-'+children);
    })

    
    $('.menu .nav-item.dropdown').each(function() {

        var children = $(this).children('.nav-link');
        children.addClass('prevent');
    })

    $(document).on('click', '#menu .nav-item .nav-link', function (event) {

        if($(this).hasClass('prevent')) {
            event.preventDefault();
        }

        var nav_link = $(this);

        nav_link.next().toggleClass('show');

        if(nav_link.hasClass('smooth-anchor')) {
            $('#menu').modal('hide');
        }
    })
}(jQuery));

/*----------------------------------------------
3. Navigation
----------------------------------------------*/
(function ($) {

    'use strict';

    var position = $(window).scrollTop();
    var navbar   = $('.navbar');

    $(document).ready(function() {
        if (position > 0) {
            navbar.hide();
        }
    })

    $(window).scroll(function () {

        let scroll = $(window).scrollTop();
        let navbar = $('.navbar');

        if (!navbar.hasClass('relative')) {

            if (scroll > position) {

                if (window.screen.width >= 767) {

                    navbar.fadeOut('fast');

                } else {

                    navbar.addClass('navbar-sticky');
                }

            } else {

                if (position < 76) {

                    navbar.slideDown('fast').removeClass('navbar-sticky');

                } else {

                    navbar.slideDown('fast').addClass('navbar-sticky');
                }

            }

            position = scroll;

        }
    })

    $('.nav-link').each(function() {
        let href = $(this).attr('href');
        if (href.length > 1 && href.indexOf('#') != -1) {
            $(this).addClass('smooth-anchor');
        }
    })

    $(document).on('click', '.smooth-anchor', function (event) {

        event.preventDefault();

        $('html, body').animate({

            scrollTop: $($.attr(this, 'href')).offset().top

        }, 500);
    })

    $(document).on('click', 'a[href="#"]', function (event) {
        event.preventDefault();
    })

    $('.dropdown-menu').each(function () {

        let dropdown = $(this);

        dropdown.hover(function () {

            dropdown.parent().find('.nav-link').first().addClass('active');

        }, function () {

            dropdown.parent().find('.nav-link').first().removeClass('active');

        })
    })
}(jQuery));

/*----------------------------------------------
4. Slides
----------------------------------------------*/
(function ($) {

    'use strict';

    setTimeout(function() {

        $('.no-slider .left').addClass('init');

    }, 1200)

    var animation = function(slider) {

        let image = $(slider + ' .swiper-slide-active img');
        let title = $(slider + ' .title');
        let description = $(slider + ' .description');
        let btn = $(slider + ' .btn');
        let nav = $(slider + ' nav');

        image.toggleClass('aos-animate');
        title.toggleClass('aos-animate');
        description.toggleClass('aos-animate');
        btn.toggleClass('aos-animate');
        nav.toggleClass('aos-animate');

        setTimeout(function() {

            image.toggleClass('aos-animate');
            title.toggleClass('aos-animate');
            description.toggleClass('aos-animate');
            btn.toggleClass('aos-animate');
            nav.toggleClass('aos-animate');

            AOS.refresh();

        }, 100)

        if ($('.full-slider').hasClass('animation')) {

            $('.full-slider .left').addClass('off');
            $('.full-slider .left').removeClass('init');

            setTimeout(function() {

                $('.full-slider .left').removeClass('off');

            }, 200)

            setTimeout(function() {

                $('.full-slider .left').addClass('init');

            }, 1000)

        } else {

            $('.full-slider .left').addClass('init');
        }
    }

    var fullSlider = new Swiper('.full-slider', {

        autoplay: {
            delay: 10000,
        },
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: '.swiper-pagination'
        },
        navigation: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        keyboard: {
            enabled: true,
            onlyInViewport: false
        },
        on: {
            init: function() {

                animation('.full-slider')

                let pagination = $('.full-slider .swiper-pagination');

                pagination.hide();

                setTimeout(function() {

                    pagination.show();

                }, 2000)

            },
            slideChange: function() {

                animation('.full-slider')
            }
        }
    })

    var midSlider = new Swiper('.slider-mid', {

        autoplay: true,
        loop: false,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            767: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            1023: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    })

    var minSlider = new Swiper('.slider-min', {

        autoplay: true,
        loop: true,
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
            424: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            767: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1023: {
                slidesPerView: 4,
                spaceBetween: 30
            },
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    })

    var sliderDisabled = new Swiper('.no-slider', {

        autoplay: false,
        loop: false,
        keyboard: false,
        grabCursor: false,
        allowTouchMove: false,
        on: {
            init: function() {
                animation('.no-slider')
            }
        }
    })
}(jQuery));

/*----------------------------------------------
5. Load More
----------------------------------------------*/
(function ($) {

    'use strict';

    $(".load-more .item").slice(0, 4).show();
    $(".blog-area.load-more .item").slice(0, 6).show();

    $("#load-btn").on('click', function (e) {

        e.preventDefault();

        $(".load-more .item:hidden").slice(0, 4).slideDown();
        $(".blog-area.load-more .item:hidden").slice(0, 6).slideDown();

        if ($(".load-more .item:hidden").length == 0) {
            $("#load-btn").fadeOut('slow');
        }

    });
}(jQuery));

/*----------------------------------------------
6. Shuffle
----------------------------------------------*/
(function ($) {

    'use strict';

    if ( $('.filter-items').length ) {

        $('.explore-area').each(function(index) {

            var count = index + 1;
    
            $(this).find('.filter-items').removeClass('filter-items').addClass('filter-items-'+count);
            $(this).find('.filter-item').removeClass('filter-item').addClass('filter-item-'+count);
            $(this).find('.filter-btn').removeClass('filter-btn').addClass('filter-btn-'+count);
            
            var Shuffle = window.Shuffle;
            var Filter  = new Shuffle(document.querySelector('.filter-items-'+count), {
                itemSelector: '.filter-item-'+count,
                buffer: 1,
            })
    
            $('.filter-btn-'+count).on('change', function (e) {
    
                var input = e.currentTarget;
                
                if (input.checked) {
                    Filter.filter(input.value);
                }
            })
        });

    }

}(jQuery));

/*----------------------------------------------
7. Contact Form
----------------------------------------------*/
(function ($) {
    'use strict';

    var form = $('#contact-form');
    var formMessage = $('#form-message');
    var successAlert = formMessage.find('.alert-success');
    var errorAlert = formMessage.find('.alert-danger');

    $(form).submit(function (e) {
        e.preventDefault();
        
        // Hide any existing alerts
        successAlert.hide();
        errorAlert.hide();
        formMessage.hide();

        var formData = $(form).serialize();

        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })
        .done(function (response) {
            // Show success message
            formMessage.show();
            successAlert.show();
            successAlert.find('.message-text').text(response.message);
            
            // Clear form
            $('#contact-form input, #contact-form textarea').val('');
            
            // Hide success message after 5 seconds
            setTimeout(function() {
                formMessage.fadeOut();
            }, 5000);
        })
        .fail(function (data) {
            // Show error message
            formMessage.show();
            errorAlert.show();
            
            if (data.responseJSON && data.responseJSON.message) {
                errorAlert.find('.message-text').text(data.responseJSON.message);
            } else if (data.responseText !== '') {
                errorAlert.find('.message-text').text(data.responseText);
            } else {
                errorAlert.find('.message-text').text('Oops! An error occurred and your message could not be sent.');
            }
        });
    });

}(jQuery));