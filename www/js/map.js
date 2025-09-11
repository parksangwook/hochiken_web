//$(window).on('load', function () {
//    // map start
//    $('.mid_map_search_top > div').on('click', function () {
//        $('.mid_map_search_top > div').removeClass('on2').addClass('off2');
//        $(this).addClass('on2').removeClass('off2');
//
//        if ($('.mid_map_search_direct').hasClass('on2')) {
//            $('.direct').addClass('show').removeClass('hide');
//        } else {
//            $('.direct').addClass('hide').removeClass('show');
//        }
//
//        if ($('.mid_map_search_location').hasClass('off2')) {
//            $('.direct_addres').addClass('hide').removeClass('show');
//        } else {
//            $('.direct_addres').addClass('show').removeClass('hide');
//        }
//    });
//    // map end
//});
//
//// map - start
//var mapContainer = document.getElementById('map'), 
//    mapOption = {
//        center: new kakao.maps.LatLng(36.5, 127.5),
//        level: 13
//    };
//var map = new kakao.maps.Map(mapContainer, mapOption);
//var infowindow = new kakao.maps.InfoWindow({ zIndex: 1 });
//var geocoder = new kakao.maps.services.Geocoder();
//
//var positions = [];
//array.forEach(function(a){
//    positions.push({
//        title: a.wr_subject,
//        address: a.wr_2,
//        city: a.wr_2
//    });
//});
//
//var positions2 = [];
//var bounds = new kakao.maps.LatLngBounds();
//
//positions.forEach(function (position) {
//    var posiObj = { title:'', x:'', y:'', address:'', city:'', marker:null };
//
//    geocoder.addressSearch(position.address, function(result, status) {
//        if (!result) return;
//
//        posiObj.y = result[0].y;
//        posiObj.x = result[0].x;
//        posiObj.title = position.title;
//        posiObj.address = position.address;
//        posiObj.city = position.city;
//
//        if (status === kakao.maps.services.Status.OK) {
//            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
//
//            var imageSrc = '/images/04_con01_02.png',
//                imageSize = new kakao.maps.Size(50, 60),
//                imageOption = { offset: new kakao.maps.Point(27, 69) };
//            var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption);
//
//            var marker = new kakao.maps.Marker({
//                map: map,
//                position: coords,
//                image: markerImage
//            });
//            marker.setMap(map);
//            posiObj.marker = marker;
//
//            positions2.push(posiObj);
//            bounds.extend(coords);
//
//            kakao.maps.event.addListener(marker, "click", function() {
//                infowindow.close();
//                infowindow.setContent(
//                    '<div class="markerdesc" style="padding:5px;font-size:12px;">' + position.title + "</div>"
//                );
//                infowindow.open(map, marker);
//            });
//
//            setBounds();
//            map_reset();
//        }
//    });
//});
//
//function map_reset(){
//    map.setLevel(13);
//}
//
//function markerMove(placeName) {
//    var filtered = positions2.filter(a => a.title.indexOf(placeName) > -1 || a.city.indexOf(placeName) > -1);
//    if (filtered.length > 0) {
//        var loc = new kakao.maps.LatLng(filtered[0].y, filtered[0].x);
//        map.setLevel(5);
//        map.setCenter(loc);
//
//        infowindow.close();
//        infowindow.setContent('<div class="markerdesc" style="padding:5px;font-size:12px;">' + filtered[0].title + "</div>");
//        infowindow.open(map, filtered[0].marker);
//    } else {
//        map_reset();
//    }
//}
//
//function markerMovebyaddress(placeName) {
//    var filtered = positions2.filter(a => a.address.indexOf(placeName) > -1);
//    if (filtered.length > 0) {
//        var loc = new kakao.maps.LatLng(filtered[0].y, filtered[0].x);
//        map.setCenter(loc);
//
//        infowindow.close();
//        infowindow.setContent('<div class="markerdesc" style="padding:5px;font-size:12px;">' + filtered[0].title + "</div>");
//        infowindow.open(map, filtered[0].marker);
//    } else {
//        map_reset();
//    }
//}
//
//function setBounds() {
//    map.setBounds(bounds);
//}
//
//// 검색 관련 이벤트
//function handleSearchInput(inputElem) {
//    var val = $(inputElem).val();
//    if (val == '' || val == null) {
//        // 전체 검색
//        $('.mid_map_search_item').show();
//        $('.noshop').hide();
//        map_reset();
//        $('.pagination').show();
//    } else {
//        // 검색어 있는 경우
//        markerMove(val);
//        $('.store').hide();
//        $('.noshop').hide();
//        $('.store').get().forEach(function(a){
//            if ($(a).attr('class').indexOf(val) > -1) $(a).show();
//        });
//        if ($('.store:visible').length == 0) {
//            map_reset();
//            $('.noshop').show();
//        }
//        $('.pagination').hide();
//    }
//
//    // 첫 번째 검색 결과 내용 업데이트
//    var firstVisible = $('.map_list_div .mid_map_search_item:visible:first');
//    $('#dynamicContent .mid_map_search_item_title').text(firstVisible.data('subject'));
//    $('#dynamicContent .mid_map_search_item_addres').text(firstVisible.data('wr_4'));
//    $('#dynamicContent .mid_map_search_item_tel').text(firstVisible.data('wr_2'));
//}
//
//$('#direct').on('keypress change', function(e) {
//    if (e.type === 'change' || e.which === 13) handleSearchInput(this);
//});
//
//$('#direct_addres').on('keypress change', function(e) {
//    if (e.type === 'change' || e.which === 13) handleSearchInput(this);
//});
//
//$('#map_icon').on('click', function() {
//    var val = $('#direct').val();
//    if (val == '' || val == null) {
//        map_reset();
//        $('.pagination').show();
//    } else {
//        $('.pagination').hide();
//    }
//});
//// map - end
