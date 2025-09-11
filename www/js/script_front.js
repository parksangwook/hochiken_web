$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {

    const items = document.querySelectorAll(".con03_img_div");
    let currentIndex = -1;

    function showRandom() {
        if (currentIndex >= 0) {
        items[currentIndex].style.opacity = "0";
        }

        let randomIndex;
        do {
        randomIndex = Math.floor(Math.random() * items.length);
        } while (randomIndex === currentIndex);

        currentIndex = randomIndex;

        items[currentIndex].style.opacity = "1";
    }

    showRandom();

    setInterval(showRandom, 2000);
   
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
const con04_swiper = new Swiper('.con04_swiper', {
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
            slidesPerView: 2,
            spaceBetween: 50
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 50
        },
    },
    navigation: {
        prevEl: '.con04-button-prev',
        nextEl: '.con04-button-next',
    },
});
const con05_swiper_left = new Swiper('.con05_swiper_left', {
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
        prevEl: '.con05-button-prev',
        nextEl: '.con05-button-next',
    },
});
const con05_swiper_right = new Swiper('.con05_swiper_right', {
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
            spaceBetween: 50
        },
        600: {
            slidesPerView: 3,
            spaceBetween: 50
        },
    },
    navigation: {
        prevEl: '.con05-button-prev',
        nextEl: '.con05-button-next',
    },
});
const con02_swiper_m = new Swiper('.con02_swiper_m', {
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
            slidesPerView: 2,
            spaceBetween: 50
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 50
        },
    },
    navigation: {
        prevEl: '.con02-button-prev_m',
        nextEl: '.con02-button-next_m',
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
            slidesPerView: 2,
            spaceBetween: 50
        },
        600: {
            slidesPerView: 2,
            spaceBetween: 50
        },
    },
    navigation: {
        prevEl: '.con06-button-prev_m',
        nextEl: '.con06-button-next_m',
    },
});
//폼메일
$('.form_submit_div').on('click', function() {

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

    mail_submit();

    function mail_submit(checkBoxIndex){
        if ($('.footeer_agree_checkbox_01').is(':checked')) {
            $('.form_submit_div').css('pointer-events', 'none');
            $.ajax({
                url: "/bbs/mail.php",
                type: "post",
                data: {
                    area: $('#area').val(),
                    name: $('#name').val(),
                    tel1: $('#tel1').val(),
                    budget: $('#budget').attr('data-value'),
                }
            }).done(function(data) {
                alert("문의양식이 전송 되었습니다.")
                $('#name').val('')
                $('#tel').val('')
                $('#area').val('')
                $('.form_submit_div').css('pointer-events', 'unset');
            });

        } else {
            alert('개인정보취급방침 동의란을 확인해주세요.')
        }
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