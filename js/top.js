
$(window).bind('load',function () {
    "use strict";
    if ($('.main_slider').length > 0) {
        $('.mv_bg').addClass('init');
        var mainSlider = $('.main_slider').slick({
            dots: true,
            infinite: true,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 6000,
            arrows: false,
            centerMode: false,
            centerPadding: 0,
            pauseOnHover: false,
            fade: true,
            variableWidth: false,
            draggable: true,
            pauseOnFocus: false
        });
        mainSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            $('.main_slider li:nth-child(' + (nextSlide + 1) + ')').addClass('zoomed');
             console.log('next' + nextSlide);
        });
        mainSlider.on('afterChange', function (event, slick, currentSlide) {
            var slideIndex = currentSlide;
            if (slideIndex === 0) {
                slideIndex = 2;
            }
            $('.main_slider li:nth-child(' + (slideIndex) + ')').removeClass('zoomed');
            console.log('current' + currentSlide);
        });
    }
    
    AOS.init({
        once: "true",
        duration: 1500,
        disable: 'mobile'
    });

    $('.sec05_list').slick({
        infinite: true,
        autoplay: true,
        slidesToShow: 4,
        variableWidth: true,
        speed: 8000,
        autoplaySpeed: 0,
        cssEase: 'linear',
        swipeToSlide: true,
        pauseOnFocus: false,
        pauseOnHover: false,
        responsive: [
            {
              breakpoint: 1566,
              settings: {
                variableWidth: false,
              }
            },
            {
                breakpoint: 751,
                settings: {
                  variableWidth: false,
                  slidesToShow: 2,
                }
            }
          ]
    });
    /*show news blog*/
    ! function($) {
        $.ajax({
            'url': 'blog/_custom/?limit=3',
            'dataType': 'jsonp',
            'success': function(json) {
                $.each(json.data, function(i, val) {
                    var DATETIME = new Date(val.date);
                    var getYear = DATETIME.getFullYear().toString();
                    var getMonth = (DATETIME.getMonth() + 1).toString();
                    getMonth = getMonth.length < 2 ? '0' + getMonth : getMonth;
                    var getDate = DATETIME.getDate().toString();
                    getDate = getDate.length < 2 ? '0' + getDate : getDate;
                    var set_post_date = getYear + '.' + '' + getMonth + '.' + getDate + ' ';
                    var $li = $('<li><p class="num">'+set_post_date+'</p><a class="txt" href="./blog/' + val.url + '">' + val.title + '</a></li>');
                    $li.appendTo('.blog_list');
                });
            }
        })
    }(jQuery);


});
