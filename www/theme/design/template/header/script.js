// 팝업 js start
$(document).ready(function(){
      $(".hd_pops_con p a").attr('target', '_blank');
    
//    $(document).on('click', '.hd_pops_con p a', function() {
//      $(".hd_pops_con").attr('target', '_blank');
//    });
    
    const userAgent = navigator.userAgent.toLowerCase();
    const isTablet = /(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(userAgent);

    window.mobileCheck = function() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    if(mobileCheck()){
        for(var i=0;i<$('#hd_pop > div').get().length;i++){
            $($('#hd_pop > div').get()[$('#hd_pop > div').get().length-1]).css('z-index',1111111111+i)
            $($('#hd_pop > div').get()[i]).css('transform', 'translateY('+(i+1)*12+'%)')
            if($('#hd_pop > div:nth-of-type('+(i+1)+') > div:has(iframe)').length < 1){
                $('#hd_pop > div > div > p').get()[i].innerHTML =$('#hd_pop > div > div > p').get()[i].innerHTML.replace(/ /g, '');
            }else{
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('width','100%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('height','50vw')
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('z-index',11111111111)
            }
        }
    }else if(isTablet){
        for(var i=0;i<$('#hd_pop > div').get().length;i++){
            $($('#hd_pop > div').get()[$('#hd_pop > div').get().length-1]).css('z-index',1111111111+i)
            $($('#hd_pop > div').get()[i]).css('transform', 'translateY('+(i+1)*12+'%)')
            console.log("i : " + i);
            if($('#hd_pop > div:nth-of-type('+(i+1)+') > div:has(iframe)').length < 1){
                
                // 선택자를 직접 사용하여 해당 인덱스의 p 요소에 접근
                var targetParagraph = $('#hd_pop > div > div > p').eq(i);
                
                if (targetParagraph.length > 0) {
                    $('#hd_pop > div > div > p').get()[i].innerHTML =$('#hd_pop > div > div > p').get()[i].innerHTML.replace(/ /g, '');
                } else {
                    console.error("Element not found at index " + i);
                }
            }else{
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('width','71%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('width','100%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('height','37vw')
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('z-index',1111111111)
            }
        }
        $('#hd_pop > div').css({
            'margin': '0 auto',
            'top': '5%',
            'border-radius': '22px', // 팝업 radius
            'overflow': 'hidden'
        });

        $('#hd_pop').css({
            'width': '100%',
            'height': '100vh',
            'position': 'absolute',
            'top': '3%'
        });

        $('.hd_pops_con').css({
            'width': '100%',
            'height': 'auto'
        });

        $('.hd_pops_footer').css({
            'font-size': '2.6vw'
        });
    }
})
// 팝업 js end


// 팝업 js start
$(document).ready(function(){
    const userAgent = navigator.userAgent.toLowerCase();
    const isTablet = /(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(userAgent);

    window.mobileCheck = function() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    if(mobileCheck()){
        for(var i=0;i<$('#hd_pop > div').get().length;i++){
            $($('#hd_pop > div').get()[$('#hd_pop > div').get().length-1]).css('z-index',1111111111+i)
            $($('#hd_pop > div').get()[i]).css('transform', 'translateY('+(i+1)*12+'%)')
            if($('#hd_pop > div:nth-of-type('+(i+1)+') > div:has(iframe)').length < 1){
                $('#hd_pop > div > div > p').get()[i].innerHTML =$('#hd_pop > div > div > p').get()[i].innerHTML.replace(/ /g, '');
            }else{
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('width','100%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('height','50vw')
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('z-index',11111111111)
            }
        }
    }else if(isTablet){
        for(var i=0;i<$('#hd_pop > div').get().length;i++){
            $($('#hd_pop > div').get()[$('#hd_pop > div').get().length-1]).css('z-index',1111111111+i)
            $($('#hd_pop > div').get()[i]).css('transform', 'translateY('+(i+1)*12+'%)')
            if($('#hd_pop > div:nth-of-type('+(i+1)+') > div:has(iframe)').length < 1){
                $('#hd_pop > div > div > p').get()[i].innerHTML =$('#hd_pop > div > div > p').get()[i].innerHTML.replace(/ /g, '');
            }else{
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('width','71%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('width','100%')
                $('#hd_pop > div:nth-of-type('+(i+1)+')> .hd_pops_con> iframe').css('height','37vw')
                $('#hd_pop > div:nth-of-type('+(i+1)+')').css('z-index',11111111111)
            }
        }
        $('#hd_pop > div').css({
            'margin': '0 auto',
            'top': '5%',
            'border-radius': '22px', // 팝업 radius
            'overflow': 'hidden'
        });

        $('#hd_pop').css({
            'width': '100%',
            'height': '100vh',
            'position': 'absolute',
            'top': '3%'
        });

        $('.hd_pops_con').css({
            'width': '100%',
            'height': 'auto'
        });

        $('.hd_pops_footer').css({
            'font-size': '2.6vw'
        });
    }
})
// 팝업 js end