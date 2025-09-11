$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {

    // 검색 기능
    function searchBorderList() {
        let keyword = $("#border_search_text").val().toLowerCase();

        $items.each(function () {
            let subject = $(this).find(".border_list_01_content_03 p").text().toLowerCase();
            if (subject.includes(keyword)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // 검색된 아이템들만 다시 페이지네이션 적용
        $currentItems = $items.filter(":visible");
        buildPagination($currentItems);
    }

    // 아이콘 클릭 시 검색
    $("#border_icon").on("click", function () {
        searchBorderList();
    });

    // 엔터 입력 시 검색
    $("#border_search_text").on("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            searchBorderList();
        }
    });

    // 버튼 클릭 이벤트
    $(document).on("click", ".pagination_01 button", function () {
        var page = $(this).data("page");
        showPage(page, $currentItems); // 항상 최신 검색 결과 기준으로 페이징
    });

    // pagination_01
    var itemsPerPage = 5; // 한 페이지에 보여줄 개수
    var $items = $(".border_list_01_content");
    var $currentItems = $items; // 현재 페이지네이션 대상 (초기엔 전체)
    
    // 페이지 표시 함수
    function showPage(page, $targetItems) {
        $items.hide(); // 전체 숨김
        var start = (page - 1) * itemsPerPage;
        var end = start + itemsPerPage;
        $targetItems.slice(start, end).show();

        // 버튼 active 표시
        $(".pagination_01 button").removeClass("active");
        $(".pagination_01 button[data-page='" + page + "']").addClass("active");
    }

    // 페이지네이션 생성
    function buildPagination($targetItems) {
        $(".pagination_01").empty(); // 기존 버튼 삭제
        var totalItems = $targetItems.length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        if (totalPages === 0) return; // 검색 결과 없으면 버튼 X

        for (var i = 1; i <= totalPages; i++) {
            $(".pagination_01").append(
                '<button type="button" data-page="' + i + '">' + i + "</button>"
            );
        }

        // 첫 페이지 표시
        showPage(1, $targetItems);
    }

    // 초기 페이지네이션 (전체 아이템)
    buildPagination($items);
    // pagination_01

    // border_button2 start
    let isAnimating2 = false;
    let currentValue2 = null;

    $('.border_button_02 > div').on('click', function () {
        const value2 = $(this).data('value');
        const targetId2 = "#border_02_div_" + value2.split("_")[1];

        console.log("text : " + targetId2)
        // 현재 클릭된 버튼과 동일하면 무시
        if (isAnimating2 || currentValue2 === value2) return;

        isAnimating2 = true;
        currentValue2 = value2;

        // 버튼 색상 처리
        $(".border_button_02_s").css({
            "background-color": "#fff8dc00",
            "color": "#000",
        });
        $(this).css({
            "background-color": "#13472e",
            "color": "#fff",
        });

        // 모든 콘텐츠 숨기기
        $(".border_02_div_div > div").css({
            "opacity": "0",
            "z-index": 0
        });
        $(".border_02_list_div").removeClass("active");

        // 해당 콘텐츠만 보여주기
        gsap.fromTo(targetId2,
            { y: 20, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                zIndex: 10,
                duration: 1,
                ease: "power2.out",
                onStart: () => {
                     $(targetId2).find(".border_02_list_div").addClass("active"); 
                },
                onComplete: () => {
                    isAnimating2 = false;
                }
            }
        );
    });

    // 최초 1번 버튼 자동 클릭
    $(".border_button_02 > div").eq(0).click();
    // border_button2 end

});

function numberWithCommas(n) {
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

let js_displayHtml = gsap.matchMedia();
js_displayHtml.add("(min-width: 1024px)", () => {

    // border_button start
    let isAnimating = false;
    let currentValue = null;

    // 버튼 클릭 핸들러
    $('.border_button_div > div').on('click', function () {
    const value = $(this).data('value');
    const targetId = "#border_div_" + value.split("_")[1];

    // 동일 버튼 클릭 시 무시
    if (isAnimating || currentValue === value) return;

    isAnimating = true;
    currentValue = value;

    // 버튼 색상 초기화 및 활성화 처리
    $(".border_button_s").css({
        "color": "#000",
        "text-decoration": "unset",
    });
    $(this).css({
        "color": "#13472e",
        "text-decoration": "underline",
        "text-underline-offset": "0.5vw",
        "text-decoration-thickness": "0.2vw",
    });

    // 콘텐츠 숨기기
    $(".border_div > div").css({
        "opacity": "0",
        "zIndex": 0,
    });

    // 높이 설정
    let newHeight = "49vw";
    switch (targetId) {
        case "#border_div_01": newHeight = "49vw"; break;
        case "#border_div_02": newHeight = "86vw"; break;
        case "#border_div_03": newHeight = "77vw"; break;
        case "#border_div_04": newHeight = "77vw"; break;
        case "#border_div_05": newHeight = "59vw"; break;
    }

    // 높이 애니메이션
    gsap.to(".border_div", {
        height: newHeight,
        duration: 0.8,
        ease: "power2.inOut"
    });

    // 콘텐츠 표시 애니메이션
    gsap.fromTo(targetId,
        { y: 20, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            zIndex: 10,
            duration: 1,
            ease: "power2.out",
            onComplete: () => { isAnimating = false; }
        }
    );
});

// 페이지 로드 시 자동 클릭 처리
const urlParams = new URLSearchParams(window.location.search);
const stepParam = urlParams.get("step");
const autoClickValue = stepParam || "step_01";

$('.border_button_div > div').each(function () {
    const btnValue = $(this).data('value');
    if (btnValue === autoClickValue) {
        $(this).trigger('click');
        return false; // 반복 종료
    }
});



    // pagination_02_XX
    function setupPagination(listWrapId, paginationClass, itemsPerPage) {
        var $items = $("#" + listWrapId + " .border_02_list_div");
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
    setupPagination("list_wrap_02_01", "pagination_02_01", 6);
    setupPagination("list_wrap_02_02", "pagination_02_02", 6);
    setupPagination("list_wrap_02_03", "pagination_02_03", 6);
    // pagination_02_xx

    // pagination_05
    var itemsPerPage_05 = 6; // 한 페이지에 보여줄 개수
    var $items_05 = $(".border_05_list_div");
    var totalItems_05 = $items_05.length;
    var totalPages_05 = Math.ceil(totalItems_05 / itemsPerPage_05);

    function showPage_05(page) {
        $items_05.hide();
        var start_05 = (page - 1) * itemsPerPage_05;
        var end_05 = start_05 + itemsPerPage_05;
        $items_05.slice(start_05, end_05).show();

        // 버튼 active 표시
        $(".pagination_05 button").removeClass("active");
        $(".pagination_05 button[data-page='" + page + "']").addClass("active");
    }

    // 페이지 버튼 생성
    for (var i = 1; i <= totalPages_05; i++) {
        $(".pagination_05").append(
            '<button type="button" data-page="' + i + '">' + i + "</button>"
        );
    }

    // 첫 페이지 표시
    showPage_05(1);

    // 버튼 클릭 이벤트
    $(document).on("click", ".pagination_05 button", function () {
        var page_05 = $(this).data("page");
        showPage_05(page_05);
    });
    // pagination_05

});
js_displayHtml.add("(max-width: 599px)", () => {

    $('.border_list_01_content_05 > p').each(function() {
        var text = $(this).text();
        $(this).text(text.substring(5));
    });

    // border_button start
    let isAnimating = false;
    let currentValue = null;

    $('.border_button_div > div').on('click', function () {
        const value = $(this).data('value');
        const targetId = "#border_div_" + value.split("_")[1];

        console.log("text : " + targetId)
        // 현재 클릭된 버튼과 동일하면 무시
        if (isAnimating || currentValue === value) return;

        isAnimating = true;
        currentValue = value;

        // 버튼 색상 처리
        $(".border_button_s").css({
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
        $(".border_div > div").css({
            "opacity": "0",
            "zIndex" : 0,
        });

        let newHeight = "49vw"; // 기본값
        switch (targetId) {
            case "#border_div_01":
                newHeight = "99vw";
                break;
            case "#border_div_02":
                newHeight = "179vw";
                break;
            case "#border_div_03":
                newHeight = "207vw";
                break;
            case "#border_div_04":
                newHeight = "207vw";
                break;
            case "#border_div_05":
                newHeight = "110vw";
                break;
        }

        // border_div 높이 애니메이션 적용
        gsap.to(".border_div", {
            height: newHeight,
            duration: 0.8,
            ease: "power2.inOut"
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
//    $(".border_button_div > div").eq(0).click();
    // border_button end

    const urlParams = new URLSearchParams(window.location.search);
    const stepParam = urlParams.get("step");
    const autoClickValue = stepParam || "step_01";

    $('.border_button_div > div').each(function() {
        const btnValue = $(this).data('value'); // 실제 클릭 이벤트 대상
        console.log("btnValue:", btnValue, "autoClickValue:", autoClickValue);

        if (btnValue === autoClickValue) {
            console.log("1")
            $(this).trigger('click'); // 클릭 이벤트 발생
            return false; // 반복 종료
        }
    });

    // pagination_02_XX
    function setupPagination(listWrapId, paginationClass, itemsPerPage) {
        var $items = $("#" + listWrapId + " .border_02_list_div");
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
    setupPagination("list_wrap_02_01", "pagination_02_01", 4);
    setupPagination("list_wrap_02_02", "pagination_02_02", 4);
    setupPagination("list_wrap_02_03", "pagination_02_03", 4);
    // pagination_02_xx

    // pagination_05
    var itemsPerPage_05 = 4; // 한 페이지에 보여줄 개수
    var $items_05 = $(".border_05_list_div");
    var totalItems_05 = $items_05.length;
    var totalPages_05 = Math.ceil(totalItems_05 / itemsPerPage_05);

    function showPage_05(page) {
        $items_05.hide();
        var start_05 = (page - 1) * itemsPerPage_05;
        var end_05 = start_05 + itemsPerPage_05;
        $items_05.slice(start_05, end_05).show();

        // 버튼 active 표시
        $(".pagination_05 button").removeClass("active");
        $(".pagination_05 button[data-page='" + page + "']").addClass("active");
    }

    // 페이지 버튼 생성
    for (var i = 1; i <= totalPages_05; i++) {
        $(".pagination_05").append(
            '<button type="button" data-page="' + i + '">' + i + "</button>"
        );
    }

    // 첫 페이지 표시
    showPage_05(1);

    // 버튼 클릭 이벤트
    $(document).on("click", ".pagination_05 button", function () {
        var page_05 = $(this).data("page");
        showPage_05(page_05);
    });
    // pagination_05

    // upload_button start
    $('.upload_button').on('click', function () {
        $('#file-upload').click();
    });

    $('#file-upload').on('change', function () {
        const files = this.files;
        const fileCount = files.length;

        if (fileCount > 0) {
            const validExtensions = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'application/pdf'];
            let isValid = true;

            for (let i = 0; i < fileCount; i++) {
                const file = files[i];
                if (!validExtensions.includes(file.type)) {
                    isValid = false;
                    break;
                }
            }

            if (!isValid) {
                alert('PNG, JPG, JPEG, GIF, PDF 파일만 업로드 가능합니다.');
                $('#file-upload').val('');
                $('.file_whether').text('선택된 파일이 없습니다.');
                $('.file_clear_btn').hide();
                $('.file_number').hide();
                return;
            }

            // 파일명 표시
            $('.file_whether').text(`${files[0].name}`);

            // 파일이 2개 이상이면 "외 N" 표시
            if (fileCount > 1) {
                $('.file_number').text(`외 ${fileCount - 1}`).show();
            } else {
                $('.file_number').hide();
            }

            $('.file_clear_btn').show();
        } else {
            $('.file_whether').text('선택된 파일이 없습니다.');
            $('.file_clear_btn').hide();
            $('.file_number').hide();
        }
    });

    
    $('.file_clear_btn').on('click', function () {
        $('#file-upload').val('');
        $('.file_whether').text('선택된 파일이 없습니다.');
        $(this).hide();
        $('.file_number').hide();
    });
    
    $('.file_clear_btn').hide();
    // upload_button end

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
    if ($('#name').val().trim() == '') {
        alert('작성자을 입력 해주세요.')
        return
    }
    if ($('#title').val().trim() == '') {
        alert('제목을 입력 해주세요.')
        return
    }
    if ($('#tel_01').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#tel_02').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#tel_03').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#email').val().trim() == '') {
       alert('이메일을 입력 해주세요.');
       return;
    }
    if ($('#budget').val().trim() == '') {
        alert('매장명를 입력 해주세요.')
        return
    }
    if ($('#form_index').val().trim() == '') {
        alert('문의 내용을 입력 해주세요.')
        return
    }

    if (!$('.agree_checkbox').is(':checked')) {
        alert('개인정보취급방침에 동의해주세요.');
        return;
    }
    
    if (!$('.agree_checkbox2').is(':checked')) {
        alert('개인정보 제3자 제공동의에 동의해주세요.');
        return;
    }

    mail_submit();

    function mail_submit(){
        $('.form_button').css('pointer-events', 'none');

        // 파일 input
//        const fileInput = $('#file-upload')[0];
//        const files = fileInput.files;
        // FormData 객체 생성
        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('title', $('#title').val());
        formData.append('tel1', $('#tel_01').val().trim() + '-' + $('#tel_02').val().trim() + '-' + $('#tel_03').val().trim());
        formData.append('email', $('#email').val());
        formData.append('budget', $('#budget').val());
        formData.append('form_index', $('#form_index').val());
        formData.append('type', 'B');

        // 파일이 있을 경우 첨부
//        if (files.length > 0) {
//            for (let i = 0; i < files.length; i++) {
//                formData.append('attachment[]', files[i]);
//            }
//        }

        $.ajax({
            url: "/bbs/mail2.php",
            type: "post",
            data: formData,
            contentType: false,
            processData: false
        }).done(function (data) {
            alert("문의양식이 전송되었습니다.");
            // 폼 초기화
            $('#name').val('');
            $('#title').val('');
            $('#tel_01').val('');
            $('#tel_02').val('');
            $('#tel_03').val('');
            $('#email').val('');
            $('#budget').val('');
            $('#form_index').val('');
            $('#file-upload').val('');
            $('.file_whether').text('선택된 파일이 없습니다.');
            $('.form_button').css('pointer-events', 'unset');
        }).fail(function () {
            alert("오류가 발생했습니다. 다시 시도해주세요.");
            $('.form_button').css('pointer-events', 'unset');
        });
    }
});
//폼메일 끝

//폼메일
$('.form_button2').on('click', function() {

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
    if ($('#name2').val().trim() == '') {
        alert('작성자을 입력 해주세요.')
        return
    }
    if ($('#title2').val().trim() == '') {
        alert('제목을 입력 해주세요.')
        return
    }
    if ($('#tel_01_02').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#tel_02_02').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#tel_03_02').val().trim() == '') {
        alert('연락처을 입력 해주세요.')
        return
    }
    if ($('#email2').val().trim() == '') {
       alert('이메일을 입력 해주세요.');
       return;
    }
    if ($('#budget2').val().trim() == '') {
        alert('매장명를 입력 해주세요.')
        return
    }
    if ($('#form_index2').val().trim() == '') {
        alert('문의 내용을 입력 해주세요.')
        return
    }

    if (!$('#agree_checkbox3').is(':checked')) {
        alert('개인정보취급방침에 동의해주세요.');
        return;
    }
    
    if (!$('#agree_checkbox4').is(':checked')) {
        alert('개인정보 제3자 제공동의에 동의해주세요.');
        return;
    }

    mail_submit();

    function mail_submit(){
        $('.form_button2').css('pointer-events', 'none');

        // 파일 input
        const fileInput = $('#file-upload2')[0];
        const files = fileInput.files;
        // FormData 객체 생성
        let formData = new FormData();
        formData.append('name', $('#name2').val());
        formData.append('title', $('#title2').val());
        formData.append('tel1', $('#tel_01_02').val().trim() + '-' + $('#tel_02_02').val().trim() + '-' + $('#tel_03_02').val().trim());
        formData.append('email', $('#email2').val());
        formData.append('budget', $('#budget2').val());
        formData.append('form_index', $('#form_index2').val());
        formData.append('type', 'C');

        // 파일이 있을 경우 첨부
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                formData.append('attachment[]', files[i]);
            }
        }

        $.ajax({
            url: "/bbs/mail3.php",
            type: "post",
            data: formData,
            contentType: false,
            processData: false
        }).done(function (data) {
            alert("문의양식이 전송되었습니다.");
            // 폼 초기화
            $('#name2').val('');
            $('#title2').val('');
            $('#tel_01_02').val('');
            $('#tel_02_02').val('');
            $('#tel_03_02').val('');
            $('#email2').val('');
            $('#budget2').val('');
            $('#form_index2').val('');
            $('#file-upload2').val('');
            $('#form_button2').css('pointer-events', 'unset');
        }).fail(function () {
            alert("오류가 발생했습니다. 다시 시도해주세요.");
            $('.form_button2').css('pointer-events', 'unset');
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