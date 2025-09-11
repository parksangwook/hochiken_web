// header/footer 로드
$('#header').load("/header.html");
$('#footer').load("/footer.html");

$(document).ready(function() {

    // --- URL search 파라미터 가져오기 ---
    const urlParams2 = new URLSearchParams(window.location.search);
    let searchValue2 = urlParams2.get('search');

    // hash 안에 search 값 있는 경우 처리
    if(!searchValue2 && window.location.hash.includes('&search=')) {
        searchValue2 = decodeURIComponent(window.location.hash.split('&search=')[1]);
    }

    console.log("searchValue2:", searchValue2);

    // searchValue2가 있으면 input에 넣고 검색 실행
    if(searchValue2) {
        $('#direct').val(searchValue2);
        setTimeout(() => { handleSearchInput('#direct'); }, 500);
    }

    // --- 엔터 입력 시 검색 ---
    $('#direct').on('keydown', function(e) {
        if(e.key === 'Enter') {
            handleSearchInput(this);
        }
    });

    // --- 아이콘 클릭 시 검색 ---
    $('#map_icon').on('click', function() {
        handleSearchInput('#direct');
    });

    // --- 페이지네이션 설정 ---
    const itemsPerPage = 5; 
    const pageNumbersToShow = 4; 
    let currentPage = 1;
    let $currentItems = $(".map_list_div_s");
    let totalItems = $currentItems.length;
    let totalPages = Math.ceil(totalItems / itemsPerPage);

    function setupPagination($items) {
        $currentItems = $items;
        totalItems = $currentItems.length;
        totalPages = Math.ceil(totalItems / itemsPerPage);
        showPage(1);
    }

    function showPage(page) {
        currentPage = page;
        $currentItems.hide();
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        $currentItems.slice(start, end).show();
        renderPagination();
    }

function renderPagination() {
    const $pagination = $("#pagination");
    $pagination.empty();

    if ($currentItems.length <= itemsPerPage) return;

    const startPage = Math.floor((currentPage - 1) / pageNumbersToShow) * pageNumbersToShow + 1;
    const endPage = Math.min(startPage + pageNumbersToShow - 1, totalPages);

    if (startPage > 1) $pagination.append('<button class="prev">&lt;</button>');

    for (let i = startPage; i <= endPage; i++) {
        $pagination.append('<button class="page-btn' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>');
    }

    if (endPage < totalPages) $pagination.append('<button class="next">&gt;</button>');
}

// 동적 버튼 클릭 이벤트 (이 부분 반드시 유지)
$(document).on("click", ".page-btn", function () {
    const page = $(this).data("page");
    showPage(page);
});

$(document).on("click", ".prev", function () {
    const startPage = Math.floor((currentPage - 1) / pageNumbersToShow) * pageNumbersToShow + 1;
    let newPage = startPage - 1; // 이전 그룹 마지막 페이지
    if(newPage < 1) newPage = 1;
    showPage(newPage);
});

$(document).on("click", ".next", function () {
    const startPage = Math.floor((currentPage - 1) / pageNumbersToShow) * pageNumbersToShow + 1;
    let newPage = startPage + pageNumbersToShow; // 다음 그룹 첫 페이지
    if(newPage > totalPages) newPage = totalPages;
    showPage(newPage);
});

    showPage(1); // 초기 표시

    // --- map_view_more 토글 ---
    $(".map_view_more").on("click", function () {
        const $p = $(this).find("p");
        $p.text($p.text() === "+" ? "-" : "+");
    });

    // --- hash search value ---
    let hash = window.location.hash;
    let searchValue = null;
    if(hash.includes('&search=')) {
        searchValue = decodeURIComponent(hash.split('&search=')[1]);
    }
    console.log(searchValue);

    // --- 검색 함수 ---
    function handleSearchInput(inputElem) {
        const val = $(inputElem).val();
        const $allItems = $(".map_list_div_s");
        let $filteredItems;

        if (!val) {
            $allItems.show();
            $('.noshop').hide();
            map_reset();
            $('.pagination').show();
            $filteredItems = $allItems;
        } else {
            markerMove(val);
            $allItems.hide();
            $allItems.each(function() {
                if ($(this).attr('class').indexOf(val) > -1) $(this).show();
            });
            $filteredItems = $allItems.filter(":visible");

            if ($filteredItems.length === 0) {
                map_reset();
                $('.noshop').show();
            }
            $('.pagination').show();
        }

        // 페이지네이션 재설정
        setupPagination($filteredItems);

        // 첫 번째 검색 결과 업데이트
        const firstVisible = $filteredItems.first();
        $('#dynamicContent .mid_map_search_item_title').text(firstVisible.data('subject'));
        $('#dynamicContent .mid_map_search_item_addres').text(firstVisible.data('wr_4'));
        $('#dynamicContent .mid_map_search_item_tel').text(firstVisible.data('wr_2'));
    }

    $('#direct, #direct_addres').on('keypress change', function(e){
        if (e.type === 'change' || e.which === 13) handleSearchInput(this);
    });

    $('#map_icon').on('click', function(){
        const val = $('#direct').val();
        if (!val) {
            map_reset();
            $('.pagination').show();
        } else {
            $('.pagination').show();
        }
    });
});

// --- GSAP matchMedia map_view_more height toggle ---
let js_displayHtml = gsap.matchMedia();
js_displayHtml.add("(min-width: 1024px)", () => {
    $(".map_view_more").on("click", function () {
        const $parentBox = $(this).closest(".map_list_div_s");
        const $bf = $parentBox.find(".map_div_bf");
        const $af = $parentBox.find(".map_div_af");
        const $map_view_more = $parentBox.find(".map_view_more");
        const current = $(this).attr("data-value");

        if (current === "open") {
            $(this).attr("data-value", "close");
            $parentBox.css("height", "19vw");
            $bf.css("opacity", "1");
            $af.css("opacity", "0");
            $map_view_more.css("top", "10%");
        } else {
            $(this).attr("data-value", "open");
            $parentBox.css("height", "5vw");
            $bf.css("opacity", "0");
            $af.css("opacity", "1");
            $map_view_more.css("top", "35%");
        }
    });
});
js_displayHtml.add("(max-width: 599px)", () => {
    $(".map_view_more").on("click", function () {
        const $parentBox = $(this).closest(".map_list_div_s");
        const $bf = $parentBox.find(".map_div_bf");
        const $af = $parentBox.find(".map_div_af");
        const $map_view_more = $parentBox.find(".map_view_more");
        const current = $(this).attr("data-value");

        if (current === "open") {
            $(this).attr("data-value", "close");
            $parentBox.css("height", "100vw");
            $bf.css("opacity", "1");
            $af.css("opacity", "0");
            $map_view_more.css("top", "10%");
        } else {
            $(this).attr("data-value", "open");
            $parentBox.css("height", "11vw");
            $bf.css("opacity", "0");
            $af.css("opacity", "1");
            $map_view_more.css("top", "35%");
        }
    });
});

// --- window load 이벤트 ---
$(window).on('load', function () {
    $('.mid_map_search_top > div').on('click', function () {
        $('.mid_map_search_top > div').removeClass('on2').addClass('off2');
        $(this).addClass('on2').removeClass('off2');

        if ($('.mid_map_search_direct').hasClass('on2')) {
            $('.direct').addClass('show').removeClass('hide');
        } else {
            $('.direct').addClass('hide').removeClass('show');
        }

        if ($('.mid_map_search_location').hasClass('off2')) {
            $('.direct_addres').addClass('hide').removeClass('show');
        } else {
            $('.direct_addres').addClass('show').removeClass('hide');
        }
    });
});

// --- Kakao Map 초기화 ---
var mapContainer = document.getElementById('map'), 
    mapOption = { center: new kakao.maps.LatLng(36.5, 127.5), level: 13 };
var map = new kakao.maps.Map(mapContainer, mapOption);
var infowindow = new kakao.maps.InfoWindow({ zIndex: 1 });
var geocoder = new kakao.maps.services.Geocoder();

var positions = [];
array.forEach(function(a){
    positions.push({ title: a.wr_subject, address: a.wr_2, city: a.wr_2 });
});

var positions2 = [];
var bounds = new kakao.maps.LatLngBounds();

positions.forEach(function(position) {
    var posiObj = { title:'', x:'', y:'', address:'', city:'', marker:null };

    geocoder.addressSearch(position.address, function(result, status) {
        if (!result) return;

        posiObj.y = result[0].y;
        posiObj.x = result[0].x;
        posiObj.title = position.title;
        posiObj.address = position.address;
        posiObj.city = position.city;

        if (status === kakao.maps.services.Status.OK) {
            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

            var imageSrc = '/images/04_con01_02.png',
                imageSize = new kakao.maps.Size(50, 60),
                imageOption = { offset: new kakao.maps.Point(27, 69) };
            var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption);

            var marker = new kakao.maps.Marker({ map: map, position: coords, image: markerImage });
            marker.setMap(map);
            posiObj.marker = marker;

            positions2.push(posiObj);
            bounds.extend(coords);

            kakao.maps.event.addListener(marker, "click", function() {
                infowindow.close();
                infowindow.setContent('<div class="markerdesc" style="padding:5px;font-size:12px;">' + position.title + "</div>");
                infowindow.open(map, marker);
            });

            setBounds();
            map_reset();
        }
    });
});

function map_reset(){ map.setLevel(13); }

function markerMove(placeName){
    const filtered = positions2.filter(a => a.title.indexOf(placeName) > -1 || a.city.indexOf(placeName) > -1);
    if (filtered.length > 0) {
        const loc = new kakao.maps.LatLng(filtered[0].y, filtered[0].x);
        map.setLevel(5);
        map.setCenter(loc);
        infowindow.close();
        infowindow.setContent('<div class="markerdesc" style="padding:5px;font-size:12px;">' + filtered[0].title + "</div>");
        infowindow.open(map, filtered[0].marker);
    } else { map_reset(); }
}

function markerMovebyaddress(placeName){
    const filtered = positions2.filter(a => a.address.indexOf(placeName) > -1);
    if (filtered.length > 0) {
        const loc = new kakao.maps.LatLng(filtered[0].y, filtered[0].x);
        map.setCenter(loc);
        infowindow.close();
        infowindow.setContent('<div class="markerdesc" style="padding:5px;font-size:12px;">' + filtered[0].title + "</div>");
        infowindow.open(map, filtered[0].marker);
    } else { map_reset(); }
}

function setBounds(){ map.setBounds(bounds); }
