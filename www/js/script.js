$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {

    // 엔터 키 입력 시
    $('#direct').on('keypress', function(e) {
        if (e.which === 13) { // 13 = Enter
            $('.pagination').css('display', 'none');
        }
    });

    // 아이콘 클릭 시
    $('#map_icon').on('click', function() {
        $('.pagination').css('display', 'none');
    });
    
    // menu_button start
    let isAnimating = false;
    let currentValue = null;

    $('.menu_button_div > div').on('click', function () {
        const value = $(this).data('value');
        const targetId = "#menu_swiper_" + value.split("_")[1];

        // 현재 클릭된 버튼과 동일하면 무시
        if (isAnimating || currentValue === value) return;

        isAnimating = true;
        currentValue = value;

        // 버튼 색상 처리
        $(".menu_button_s").css({
            "color": "#000",
            "text-decoration": "unset",
        });
        $(this).css({
            "color": "#13472e",
            "text-decoration": "underline",
            "text-underline-offset": "0.5vw",
            "text-decoration-thickness": "0.2vw",
        });

        // 모든 콘텐츠 숨기기
        $(".menu_border_div > div").css({
            "opacity": "0",
            "zIndex" : 0,
        });

        // 해당 콘텐츠만 보여주기 (GSAP 애니메이션 적용)
        gsap.fromTo(targetId,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                "zIndex" : 10,
                duration: 1,
                ease: "power2.out",
                onComplete: () => { // 애니메이션 끝난 후에만 클릭 가능
                    isAnimating = false;
                }
            }
        );
    });

    // 최초 1번 버튼 자동 클릭
    $(".menu_button_div > div").eq(0).click();
    // menu_button end
    
    function goToMap() {
        var value = $('.con07_search').val().trim();
        if(value) {
            window.location.href = 'bbs/content.php?co_id=map#map_move&search=' + encodeURIComponent(value);
        }
    }

    // 엔터 입력 시
    $('.con07_search').on('keydown', function(e) {
        if(e.key === 'Enter') {
            goToMap();
        }
    });

    // 이미지 클릭 시 → div에 걸기
    $('.con07_02_div').on('click', goToMap);


    $('.con01_sd_div').on('click', function () {
        var videoId = $(this).data('youtube'); // wr_2 값 (유튜브 v 값)
        var videoTitle = $(this).data('title'); // wr_subject 값

        // iframe 교체
        $('.con01_video').attr(
            'src',
            'https://www.youtube.com/embed/' + videoId +
            '?autoplay=1&loop=1&playlist=' + videoId +
            '&controls=0&modestbranding=1&rel=0'
        );

        // 제목 교체
        $('.con01_video_tite').text(videoTitle);
    });


   
});

function numberWithCommas(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

let js_displayHtml = gsap.matchMedia();
js_displayHtml.add("(min-width: 1024px)", () => {

});
js_displayHtml.add("(max-width: 599px)", () => {

});
const main_swiper = new Swiper('.main_swiper', {
    slidesPerView: 1,
    spaceBetween:0,
    slidesPerGroup: 1,
    loop: true,
    autoplay: {
        delay: 2250,
        disableOnInteraction: false,
    },
    breakpoints: {
        1024: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        600: {
            slidesPerView: 1,
            spaceBetween: 0
        },
    },
    navigation: {
        prevEl: '.main-button-prev',
        nextEl: '.main-button-next',
    },
    pagination: {
        el: '.swiper-pagination_main',
        clickable: true,
        renderBullet3: function (index3, className3) {
            $('.swiper-pagination_main-bullet-active').css('background','url('+ menu3[index3]+') no-repeat center / contain')
            console.log("t" + index3)
            console.log("t" + className3)
            className3 = 'swiper-pagination_03-bullet'
            return '<span class="' + className3+' '+className3+index3 + '"></span>';
        },
    },
});
const main_swiper_m = new Swiper('.main_swiper_m', {
    slidesPerView: 1,
    spaceBetween:0,
    slidesPerGroup: 1,
    loop: true,
    autoplay: {
        delay: 2250,
        disableOnInteraction: false,
    },
    breakpoints: {
        1024: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        600: {
            slidesPerView: 1,
            spaceBetween: 0
        },
    },
    navigation: {
        prevEl: '.main-button-prev',
        nextEl: '.main-button-next',
    },
    pagination: {
        el: '.swiper-pagination_main_m',
        clickable: true,
        renderBullet3: function (index3, className3) {
            $('.swiper-pagination_main-bullet-active_m').css('background','url('+ menu3[index3]+') no-repeat center / contain')
            console.log("t" + index3)
            console.log("t" + className3)
            className3 = 'swiper-pagination_03-bullet_m'
            return '<span class="' + className3+' '+className3+index3 + '"></span>';
        },
    },
});
const con01_swiper = new Swiper('.con01_swiper', {
    slidesPerView: 2,
    spaceBetween:10,
    slidesPerGroup: 1,
    loop: true,
    autoplay: {
        delay: 2250,
        disableOnInteraction: false,
    },
    breakpoints: {
        1024: {
            slidesPerView: 4,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 4,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con01-button-prev',
        nextEl: '.con01-button-next',
    },
});
const menu_swiper = new Swiper('.menu_swiper', {
    slidesPerView: 2,
    spaceBetween:10,
    slidesPerGroup: 1,
    loop: true,
//     autoplay: {
//         delay: 2250,
//         disableOnInteraction: false,
//     },
    breakpoints: {
        1024: {
            slidesPerView: 4,
            spaceBetween: 50
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 50
        },
    },
    navigation: {
        prevEl: '.menu-button-prev',
        nextEl: '.menu-button-next',
    },
});
const con03_swiper_left = new Swiper('.con03_swiper_left', {
    slidesPerView: 1,
    spaceBetween:0,
    slidesPerGroup: 1,
    loop: true,
     autoplay: {
         delay: 2250,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        600: {
            slidesPerView: 1,
            spaceBetween: 0
        },
    },
    navigation: {
        prevEl: '.con03-button-next_left',
        nextEl: '.con03-button-prev_left',
    },
});
const con03_swiper_right = new Swiper('.con03_swiper_right', {
    slidesPerView: 1,
    spaceBetween:0,
    slidesPerGroup: 1,
    loop: true,
     autoplay: {
         delay: 2250,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        600: {
            slidesPerView: 1,
            spaceBetween: 0
        },
    },
    navigation: {
        prevEl: '.con03-button-next_right',
        nextEl: '.con03-button-prev_right',
    },
});
const con05_swiper = new Swiper('.con05_swiper', {
    slidesPerView: 1,
    spaceBetween:0,
    slidesPerGroup: 1,
    loop: true,
     autoplay: {
         delay: 2250,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 3,
            spaceBetween: 30
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 30
        },
    },
    navigation: {
        prevEl: '.con05-button-prev',
        nextEl: '.con05-button-next',
    },
});
    //폼메일
    $('.form_button').on('click', function() {

        // XSS 필터링 함수
        function containsMaliciousCode(input) {
            const pattern = /<\s*script|<\/\s*script\s*>|javascript:|on\w+\s*=/gi;
            return pattern.test(input);
        }

        // xss_check 클래스 가진 모든 입력값 검사
        let hasMalicious = false;
        $('.xss_check').each(function() {
            if (containsMaliciousCode($(this).val().trim())) {
                alert("입력값에 유효하지 않은 코드가 포함되어 있습니다.");
                hasMalicious = true;
                return false;
            }
        });
        if (hasMalicious) return;
        
        if ($('#name').val().trim() == '') {
            alert('이름를 입력 해주세요.')
            return
        }
        if ($('#tel1').val().trim() == '') {
            alert('연락처를 입력 해주세요.')
            return
        }
        if ($('#area').val().trim() == '') {
            alert('희망 지역을 입력 해주세요.')
            return
        }
        if ($('#budget').val().trim() == '') {
            alert('유입경로를 선택해주세요.')
            return
        }
        if ($('#form_index').val().trim() == '') {
            alert('문의내용을 입력 해주세요.')
            return
        }

        mail_submit();

        function mail_submit(checkBoxIndex){
                $('.form_button').css('pointer-events', 'none');
                $.ajax({
                    url: "/bbs/mail.php",
                    type: "post",
                    data: {
                        area: $('#area').val(),
                        name: $('#name').val(),
                        tel1: $('#tel1').val(),
                        budget: $('#budget').val(),
                        form_index: $('#form_index').val(),
                        type: 'A',
                    }
                }).done(function(data) {
                    alert("문의양식이 전송되었습니다.");
                    
                    $('#name').val('')
                    $('#tel1').val('')
                    $('#area').val('')
                    $('#budget').val('');
                    $('#form_index').val('')
                    $('.form_button').css('pointer-events', 'unset');
                });
        }
    });
    //폼메일 끝

//개인정보처리 방침//
// var elements = document.getElementsByClassName("agree_text");
// var modal = document.getElementById("modal");

// for (var i = 0; i < elements.length; i++) {
//     elements[i].addEventListener("click", function() {
//         event.preventDefault();
//         modal.style.display = "block";
//     });
// }

// var closeButton = document.getElementsByClassName("close")[0];

// closeButton.addEventListener("click", function() {
//     modal.style.display = "none";
// });

// window.addEventListener("click", function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// });
//개인정보처리 방침//