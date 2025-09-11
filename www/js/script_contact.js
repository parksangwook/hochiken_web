$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {
    const pairs = [
        ["#con12_div_03_absol_01", "#con12_img_01"],
        ["#con12_div_03_absol_02", "#con12_img_02"],
        ["#con12_div_03_absol_03", "#con12_img_03"],
        ["#con12_div_03_absol_04", "#con12_img_04"]
    ];

    let index = 0;

    function showNextPair() {
        // 모든 요소 opacity 0
        pairs.forEach(pair => {
            $(pair[0]).css("opacity", 0);
            $(pair[1]).css("opacity", 0);
        });

        // 현재 쌍만 opacity 1
        $(pairs[index][0]).css("opacity", 1);
        $(pairs[index][1]).css("opacity", 1);

        // 다음 쌍 인덱스
        index = (index + 1) % pairs.length;
    }

    // 처음 한 번 보여주기
    showNextPair();

    // 1초 간격으로 반복
    setInterval(showNextPair, 1000);

    $('.con03_sd_div').on('click', function () {
        var videoId = $(this).data('youtube'); // wr_2 값 (유튜브 v 값)
        var videoTitle = $(this).data('title'); // wr_subject 값

        // iframe 교체
        $('.con03_video').attr(
            'src',
            'https://www.youtube.com/embed/' + videoId +
            '?autoplay=1&loop=1&playlist=' + videoId +
            '&controls=0&modestbranding=1&rel=0'
        );

        // 제목 교체
        $('.con03_text_rtlv').text(videoTitle);
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
const con02_swiper = new Swiper('.con02_swiper', {
    slidesPerView: 2,
    spaceBetween:5,
    slidesPerGroup: 1,
    loop: true,
    speed: 5000,
     autoplay: {
         delay: 0,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 6,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 6,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con02-button-prev',
        nextEl: '.con02-button-next',
    },
});
const con03_swiper = new Swiper('.con03_swiper', {
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
            slidesPerView: 8,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 8,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con03-button-prev',
        nextEl: '.con03-button-next',
    },
});
const con09_swiper_y = new Swiper('.con09_swiper_y', {
    direction: 'vertical',
    effect: 'slide',
    spaceBetween: 3,
    slidesPerView: 3,
    allowTouchMove: false,
    loop: true,
    speed: 5000,
       autoplay: {
           delay: 0,
           disableOnInteraction: false,
           reverseDirection: true,
       },
    loopAdditionalSlides: 5,
    breakpoints: {
        1024: {
            slidesPerView: 3,
            spaceBetween: 40
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 40
        },
    },
    navigation: {
        nextEl: '.con09-button-prev_y',
        prevEl: '.con09-button-next_y',
    },
});
const con09_swiper_y2 = new Swiper('.con09_swiper_y2', {
    direction: 'vertical',
    effect: 'slide',
    spaceBetween: 3,
    slidesPerView: 3,
    allowTouchMove: false,
    loop: true,
    speed: 5000,
       autoplay: {
           delay: 0,
           disableOnInteraction: false,
       },
    loopAdditionalSlides: 5,
    breakpoints: {
        1024: {
            slidesPerView: 3,
            spaceBetween: 40
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 40
        },
    },
    navigation: {
        nextEl: '.con09-button-prev_y',
        prevEl: '.con09-button-next_y',
    },
});
const con11_swiper = new Swiper('.con11_swiper', {
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
        prevEl: '.con11-button-prev',
        nextEl: '.con11-button-next',
    },
});
const con13_swiper = new Swiper('.con13_swiper', {
    slidesPerView: 2,
    spaceBetween:10,
    slidesPerGroup: 1,
    loop: true,
    speed: 5000,
     autoplay: {
         delay: 0,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 5,
            spaceBetween: 30
        },
        600: {
            slidesPerView: 5,
            spaceBetween: 30
        },
    },
    navigation: {
        prevEl: '.con13-button-prev',
        nextEl: '.con13-button-next',
    },
});
const con14_swiper = new Swiper('.con14_swiper', {
    slidesPerView: 1,
    spaceBetween:10,
    slidesPerGroup: 1,
    loop: true,
    speed: 5000,
     autoplay: {
         delay: 0,
         disableOnInteraction: false,
     },
    breakpoints: {
        1024: {
            slidesPerView: 5,
            spaceBetween: 20
        },
        600: {
            slidesPerView: 5,
            spaceBetween: 20
        },
    },
    navigation: {
        prevEl: '.con14-button-prev',
        nextEl: '.con14-button-next',
    },
});
const con06_swiper_m = new Swiper('.con06_swiper_m', {
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
            slidesPerView: 8,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 8,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con06-button-prev_m',
        nextEl: '.con06-button-next_m',
    },
});
const con08_swiper_m = new Swiper('.con08_swiper_m', {
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
            slidesPerView: 8,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 8,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con08-button-prev_m',
        nextEl: '.con08-button-next_m',
    },
});
const con09_swiper_m = new Swiper('.con09_swiper_m', {
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
            slidesPerView: 8,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 8,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con09-button-prev_m',
        nextEl: '.con09-button-next_m',
    },
});
const con12_swiper_m = new Swiper('.con12_swiper_m', {
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
            slidesPerView: 8,
            spaceBetween: 10
        },
        600: {
            slidesPerView: 8,
            spaceBetween: 10
        },
    },
    navigation: {
        prevEl: '.con12-button-prev_m',
        nextEl: '.con12-button-next_m',
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
            alert('성함를 입력 해주세요.')
            return
        }
        if ($('#tel').val().trim() == '') {
            alert('연락처를 입력 해주세요.')
            return
        }
        if ($('#area').val().trim() == '') {
            alert('창업 희망 지역을 입력 해주세요.')
            return
        }
        if ($('#form_index').val().trim() == '') {
            alert('문의내용을 입력 해주세요.')
            return
        }
        if (!$('.agree_checkbox').is(':checked')) {
            alert('개인정보취급방침에 동의해주세요.');
            return;
        }

        mail_submit();

        function mail_submit(checkBoxIndex){
                $('.form_button').css('pointer-events', 'none');
                $.ajax({
                    url: "/bbs/mail4.php",
                    type: "post",
                    data: {
                        area: $('#area').val(),
                        name: $('#name').val(),
                        tel1: $('#tel').val(),
                        budget: $('#budget').val(),
                        have: $('#have').val(),
                        period: $('#period').val(),
                        gold: $('#gold').val(),
                        form_index: $('#form_index').val(),
                        type: 'A',
                    }
                }).done(function(data) {
                    alert("문의양식이 전송되었습니다.");
                    
                    $('#name').val('')
                    $('#tel').val('')
                    $('#area').val('')
                    $('#budget').val('');
                    $('#have').val('')
                    $('#period').val('')
                    $('#gold').val('')
                    $('#form_index').val('')
                    $('.form_button').css('pointer-events', 'unset');
                });
        }
    });
    //폼메일 끝

//개인정보처리 방침//
 var elements = document.getElementsByClassName("agree_text");
 var modal = document.getElementById("modal");

 for (var i = 0; i < elements.length; i++) {
     elements[i].addEventListener("click", function() {
         event.preventDefault();
         modal.style.display = "block";
     });
 }

 var closeButton = document.getElementsByClassName("close")[0];

 closeButton.addEventListener("click", function() {
     modal.style.display = "none";
 });

 window.addEventListener("click", function(event) {
     if (event.target == modal) {
         modal.style.display = "none";
     }
 });
//개인정보처리 방침//