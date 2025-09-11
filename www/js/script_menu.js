$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {

    // menu_button start
    let isAnimating = false;
    let currentValue = null;

    $('.menu_button_div > div').on('click', function () {
        const value = $(this).data('value');
        const targetId = "#menu_border_div_" + value.split("_")[1];

        console.log(targetId)
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
        $(".menu_border > div").css({
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
//    $(".menu_button_div > div").eq(0).click();
    // menu_button end
    const urlParams = new URLSearchParams(window.location.search);
    const stepParam = urlParams.get("step");
    const autoClickValue = stepParam || "step_01";

    $('.menu_button_div > div').each(function() {
        const btnValue = $(this).data('value'); // 실제 클릭 이벤트 대상
        console.log("btnValue:", btnValue, "autoClickValue:", autoClickValue);

        if (btnValue === autoClickValue) {
            console.log("1")
            $(this).trigger('click'); // 클릭 이벤트 발생
            return false; // 반복 종료
        }
    });
   
    // border_button2 start
    let isAnimating2 = false;
    let currentValue2 = null;

    $('.menu_border_button_02 > div').on('click', function () {
        const value2 = $(this).data('value');
        const targetId2 = "#menu_border_02_div_" + value2.split("_")[1];

        console.log("text : " + targetId2)
        // 현재 클릭된 버튼과 동일하면 무시
        if (isAnimating2 || currentValue2 === value2) return;

        isAnimating2 = true;
        currentValue2 = value2;

        // 버튼 색상 처리
        $(".menu_border_button_02_s").css({
            "background-color": "#fff8dc00",
            "color": "#000",
        });
        $(this).css({
            "background-color": "#13472e",
            "color": "#fff",
        });

        // 모든 콘텐츠 숨기기
        $(".menu_border_02_div_div > div").css({
            "opacity": "0",
            "zIndex" : 0,
        });

        // 해당 콘텐츠만 보여주기 (GSAP 애니메이션 적용)
        gsap.fromTo(targetId2,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                "zIndex" : 10,
                duration: 1,
                ease: "power2.out",
                onComplete: () => { // 애니메이션 끝난 후에만 클릭 가능
                    isAnimating2 = false;
                }
            }
        );
    });

    // 최초 1번 버튼 자동 클릭
    $(".menu_border_button_02 > div").eq(0).click();
    // border_button2 end

    function setupPagination(listWrapId, paginationClass, itemsPerPage) {
        var $items = $("#" + listWrapId + " .menu_border_frame");
        var totalItems = $items.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        // 기존 버튼 초기화
        $("." + paginationClass).empty();

        function showPage(page) {
            $items.hide();
            var start = (page - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            $items.slice(start, end).show();

            // 버튼 active 처리
            $("." + paginationClass + " button").removeClass("active");
            $("." + paginationClass + " button[data-page='" + page + "']").addClass("active");
        }

        // 페이지 버튼 생성
        for (var i = 1; i <= totalPages; i++) {
            $("." + paginationClass).append(
                '<button type="button" data-page="' + i + '">' + i + '</button>'
            );
        }

        if (totalPages > 0) showPage(1);

        // 버튼 클릭 이벤트
        $(document).off("click", "." + paginationClass + " button")
            .on("click", "." + paginationClass + " button", function () {
                var page = $(this).data("page");
                showPage(page);
            });
    }

    // PC 기준 (1페이지에 8개씩)
    setupPagination("menu_border_div_02 .menu_border_div_rltv", "pagination_menu_02_01", 8);
    setupPagination("menu_border_div_03 .menu_border_div_rltv", "pagination_menu_02_02", 8);
    setupPagination("menu_border_div_04 .menu_border_div_rltv", "pagination_menu_02_03", 8);

    // 반응형: 모바일 기준 (1페이지에 4개씩)
    let js_displayHtml = gsap.matchMedia();

    js_displayHtml.add("(max-width: 599px)", () => {
        setupPagination("menu_border_div_02 .menu_border_div_rltv", "pagination_menu_02_01", 4);
        setupPagination("menu_border_div_03 .menu_border_div_rltv", "pagination_menu_02_02", 4);
        setupPagination("menu_border_div_04 .menu_border_div_rltv", "pagination_menu_02_03", 4);
    });
});

function numberWithCommas(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

let js_displayHtml = gsap.matchMedia();
js_displayHtml.add("(min-width: 1024px)", () => {

    // pagination_menu_XX
    function setupPagination(listWrapId, paginationClass, itemsPerPage) {
        var $items = $("#" + listWrapId + " .menu_border_frame");
        var totalItems = $items.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        function showPage(page) {
            $items.hide();
            var start = (page - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            $items.slice(start, end).show();

            // 버튼 active 표시
            $("." + paginationClass + " button").removeClass("active");
            $("." + paginationClass + " button[data-page='" + page + "']").addClass("active");
        }

        // 페이지 버튼 생성
        for (var i = 1; i <= totalPages; i++) {
            $("." + paginationClass).append(
                '<button type="button" data-page="' + i + '">' + i + "</button>"
            );
        }

        // 첫 페이지 표시
        if (totalPages > 0) {
            showPage(1);
        }

        // 버튼 클릭 이벤트
        $(document).on("click", "." + paginationClass + " button", function () {
            var page = $(this).data("page");
            showPage(page);
        });
    }

    // 각각의 pagination 초기화
    setupPagination("list_wrap_02_01", "pagination_menu_01_01", 8);
    setupPagination("list_wrap_02_02", "pagination_menu_01_02", 8);
    setupPagination("list_wrap_02_03", "pagination_menu_01_03", 8);
    // pagination_menu_XX

});
js_displayHtml.add("(max-width: 599px)", () => {

    // pagination_menu_XX
    function setupPagination(listWrapId, paginationClass, itemsPerPage) {
        var $items = $("#" + listWrapId + " .menu_border_frame");
        var totalItems = $items.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        function showPage(page) {
            $items.hide();
            var start = (page - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            $items.slice(start, end).show();

            // 버튼 active 표시
            $("." + paginationClass + " button").removeClass("active");
            $("." + paginationClass + " button[data-page='" + page + "']").addClass("active");
        }

        // 페이지 버튼 생성
        for (var i = 1; i <= totalPages; i++) {
            $("." + paginationClass).append(
                '<button type="button" data-page="' + i + '">' + i + "</button>"
            );
        }

        // 첫 페이지 표시
        if (totalPages > 0) {
            showPage(1);
        }

        // 버튼 클릭 이벤트
        $(document).on("click", "." + paginationClass + " button", function () {
            var page = $(this).data("page");
            showPage(page);
        });
    }

    // 각각의 pagination 초기화
    setupPagination("list_wrap_02_01", "pagination_menu_01_01", 4);
    setupPagination("list_wrap_02_02", "pagination_menu_01_02", 4);
    setupPagination("list_wrap_02_03", "pagination_menu_01_03", 4);
    // pagination_menu_XX

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