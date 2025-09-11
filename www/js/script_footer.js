let footer_displayHtml = gsap.matchMedia();
footer_displayHtml.add("(min-width: 1024px)", () => {
    $(".footer_content_mid_mid").show();
    $(".footer_content_mid_bottom_m").hide();
});
footer_displayHtml.add("(max-width: 1023px) and (min-width: 599px)", () => {
    $(".footer_content_mid_mid").show();
    $(".footer_content_mid_bottom_m").hide();
});
footer_displayHtml.add("(max-width: 599px)", () => {
    $(".footer_content_mid_mid").show();
    $(".footer_content_mid_bottom_m").hide();
});

//폼메일
$('.quick_submit').on('click', function() {
    if ($('#tel1_quick').val().trim() == '') {
        alert('연락처를 입력 해주세요.');
        return
    }
    if ($('.quickAgree_checkbox').is(':checked')) {
        $('.quick_submit').css('pointer-events', 'none');
        $.ajax({
            url: "/bbs/mail.php",
            type: "post",
            data: {
                name: $('#name_quick').val(),
                tel1: $('#tel1_quick').val(),
                area: $('#area_quick').val(),
            }
        }).done(function(data) {
            alert("문의양식이 전송 되었습니다.");
            $('#name_quick').val('');
            $('#tel1_quick').val('');
            $('#area_quick').val('');
            $('.quick_submit').css('pointer-events', 'unset');
        });
    } else{
        alert('개인정보취급방침 동의란을 확인해주세요.');
    }
})
//폼메일 끝
//개인정보처리 방침//
var elements = document.getElementsByClassName("footer_agree_text");
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