$(window).bind('load', function() {
    "use strict";
    // anchor in page

    function scroll_animate(position){
        var h_pc = 170;
        var h_sp = 80;
        if ($(window).width() > 750) {
            $('html,body').animate({ scrollTop: position.top - h_pc }, 400);
        } else {
            $('html,body').animate({ scrollTop: position.top - h_sp }, 400);
        }
    }
    $(function() {
        $('a[href^="#"]').click(function() {
            if ($($(this).attr('href')).length) {
                var p = $($(this).attr('href')).offset();
                scroll_animate(p);
            }
            return false;
        });
    });

    // anchor top page #
    var hash = location.hash;
    if (hash) {
        var p = $(hash).offset();
        scroll_animate(p);
    }
   // anchorlink for contact form (Fmail) page
    if ($('.contact_page').length) {
        // anchor FMAIL
        var str = window.location.search;
        var n = str.search("mode");
        if (n >= 0) {
            var p = $('#fmail_form').offset();
            scroll_animate(p);
        }
    }

    // click all box with JS 
    // $('.class_name').on('click', function () {
    //     var href = $(this).find('a').attr('href');
    //     location.href = href;
    // });
    
});

$(window).bind('load scroll', function() {
    "use strict";
    if ($(this).scrollTop() >= 1) {
        $('.to_top,.sp_contact,header').addClass('show');
    } else {
        $('.to_top,.sp_contact,header').removeClass('show');
    }
});

$(document).ready(function() {
    "use strict";
    var windowWidth = window.innerWidth ? window.innerWidth : $(window).width();
    // nav
    $(".hamburger").click(function() {
        $(this).toggleClass("is_active");
        $("nav").fadeToggle(100);
        if( $(this).hasClass("is_active")) {
            $("body").css("overflow","hidden")
            $('.to_top').removeClass('show');
        }
        else {
            $("body").css("overflow","unset")
            $('.to_top').addClass('show');
        }
    });

    $("nav a:not([href])").click(function() {
        if (windowWidth <= 750) {
            $(this).toggleClass("open");
            $(this).next().stop(1, 0).slideToggle(400);
        } else {
            $(this).removeClass("open");
            $(this).next().removeAttr("style");
        }
    });
    if (windowWidth <= 750) {
        $("nav a[href]").click(function() {
            $('.hamburger').removeClass('is_active');
            $('nav').css('display', 'none');
        });
    }
    // back to top
   
    
    $('.to_top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 600);
    });

    /*================= JS CUSTOM ===================*/

    // JS ONLY PAGE SPECIAL
    if ($('.class_name').length) {

    }


});