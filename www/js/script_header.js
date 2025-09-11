let header = document.querySelector("header");

let header_displayHtml = gsap.matchMedia();
header_displayHtml.add("(min-width: 1024px)", () => {

    $(".header_menu").show();
    $(".header_menu_modbile").hide();

    $(".header_menu_modbile_div").hide();
    $(".header_menu_modbile_icon").hide();
    
    var prevScrollTop = 0;
    var nowScrollTop = 0;
    
    function wheelDelta(){
        return prevScrollTop - nowScrollTop > 0 ? 'up' : 'down';
    };
    
    $(window).on('scroll', function(){
        nowScrollTop = $(this).scrollTop();
        if(wheelDelta() == 'down'){
            header.classList.remove("drop");
            header.classList.add("insert");
        }
        if(wheelDelta() == 'up'){
            header.classList.add("drop");
            header.classList.remove("insert");
        }
        prevScrollTop = nowScrollTop;
    });

    $(".header_menu_modbile_icon_h").hide();
    
    $(".header_menu_modbile_div").click(function() {
        $(".header_menu_modbile_div").hide();

        $(".header_menu_modbile_icon").show();

        $(".header_menu_modbile_icon_h").hide();
    });
});
header_displayHtml.add("(max-width: 1023px) and (min-width: 599px)", () => {
    $(".header_menu").show();
    $(".header_menu_modbile").hide();

    $(".header_menu_modbile_div").hide();
    $(".header_menu_modbile_icon").hide();
});
header_displayHtml.add("(max-width: 599px)", () => {

    // var prevScrollTop = 0;
    // var nowScrollTop = 0;
    
    // function wheelDelta(){
    //     return prevScrollTop - nowScrollTop > 0 ? 'up' : 'down';
    // };
    
    // $(window).on('scroll', function(){
    //     nowScrollTop = $(this).scrollTop();
    //     if(wheelDelta() == 'down'){
    //         header.classList.remove("drop");
    //         header.classList.add("insert");
    //     }
    //     if(wheelDelta() == 'up'){
    //         header.classList.add("drop");
    //         header.classList.remove("insert");
    //     }
    //     prevScrollTop = nowScrollTop;
    // });

    $(".header_menu").hide();
    $(".header_menu_modbile").hide();

    $(".header_menu_modbile_div").hide();
    $(".header_menu_modbile_icon").show();

    $('.head_mobile_div').click(function() {
        console.log('tsets')
        var imgElement = $(this).find('.head_mobile_img_div');
        console.log(imgElement[0].className);
        imgElement.toggleClass('head_mobile_img_rotate');

        setTimeout(function() {
            if ($(".head_mobile_img_div").hasClass('head_mobile_img_rotate')) {
                $(".header_menu_m").css('width', '99.46vw');
                $(".header_menu_m").css('border', '1px solid');

            } else {
                $(".header_menu_m").css('width', '0vw');
                $(".header_menu_m").css('border', '0px solid');
            }

        }, 300);

        event.stopPropagation();
    });
    $(document).click(function() {

        $(".head_mobile_img_div").removeClass('head_mobile_img_rotate');

        $(".header_menu_m").css('width', '0vw');
        $(".header_menu_m").css('border', '0px solid');
    });
});

$(document).ready(function() {
$('.hamburger-menu').click(function(){
        $('.line').toggleClass('line_change');
/*         $('#line-top').toggleClass('line-top').toggleClass('top-reverse');
        $('#line-mid').toggleClass('line-mid').toggleClass('mid-reverse');
        $('#line-bot').toggleClass('line-bot').toggleClass('bot-reverse'); */
        if(!$('div.line').hasClass('init')){
            $('div.line').addClass('init');
            $("div.line").removeClass("on");
            $('.menu').addClass('menu-hide');
            $(".menu").removeClass("menu-show");
            /* $('.hamburger').removeClass('hamburger-top'); */
            $('.header_menu').removeClass('header_menu_drop');
    
        }else{
            $('div.line').removeClass('init');
            $("div.line").addClass("on");
            $('.menu').addClass('menu-show');
            $(".menu").removeClass("menu-hide");
            /* $('.hamburger').addClass('hamburger-top'); */
            $('.header_menu').addClass('header_menu_drop');
    
        }
    })

    $(".admin_head li").mouseover(function(){
        $(this).find('.drop-down').slideDown(300);
        $(this).find(".accent").addClass("animate");
//        $(this).find(".item").css("color","#fff");
    }).mouseleave(function(){
        $(this).find(".drop-down").slideUp(300);
        $(this).find(".accent").removeClass("animate");
//        $(this).find(".item").css("color","#fff");
    });
    $(".head_line").click(function() {
        $(".header_menu_modbile").show();
        $(".header_menu_modbile_div").show();

        $(".header_menu_modbile_icon").hide();

        $(".header_menu_modbile_icon_h").show();

        $(".header_menu_modbile").css("display", "flex");
        $(".header_menu_modbile_div").css("display", "flex");
        move_head();
    });
    $(".head_line_h_01").click(function() {
        $(".header_menu_modbile").hide();
        $(".header_menu_modbile_div").hide();

        $(".header_menu_modbile_icon").show();

        $(".header_menu_modbile_icon_h").hide();
        

        $(".header_menu_modbile_div").css("display", "none");
        move_head_02();
    });
    $(".head_line_h_02").click(function() {
        $(".header_menu_modbile").hide();
        $(".header_menu_modbile_div").hide();

        $(".header_menu_modbile_icon").show();

        $(".header_menu_modbile_icon_h").hide();
        

        $(".header_menu_modbile_div").css("display", "none");
        move_head_02();
    });
});

function move_head(){
    const ver01 = gsap.timeline({
        scrollTrigger: {
            trigger: ".headerWrap",
            toggleActions: "play none none none",
        },
        defaults: { duration: 1, ease: "circ.out" },
    })
    ver01.from(".head_line", {
        ease: "circ.out",
        scale: 0,
        duration: 1,
        opacity: 1,
        rotate: -540,
    },"<with%")
}

function move_head_02(){
    const ver01 = gsap.timeline({
        scrollTrigger: {
            trigger: ".headerWrap",
            toggleActions: "play none none none",
        },
        defaults: { duration: 1, ease: "circ.out" },
    })
    ver01.from(".head_line_h_01", {
        ease: "circ.out",
        scale: 0,
        duration: 1,
        opacity: 1,
        rotate: -540,
    },"<with%").from(".head_line_h_02", {
        ease: "circ.out",
        scale: 0,
        duration: 1,
        opacity: 1,
        rotate: -540,
    },"<with%")
}