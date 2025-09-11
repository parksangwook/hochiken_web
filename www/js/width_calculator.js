document.addEventListener('DOMContentLoaded', function () {
    const cssRules = [];

    const images = document.querySelectorAll('img');
    const promises = Array.from(images).map((img) => {
        return new Promise((resolve) => {
            if (img.complete) resolve();
            else {
                img.addEventListener('load', resolve);
                img.addEventListener('error', resolve);
            }
        });
    });

    Promise.all(promises).then(() => {
        console.log('모든 이미지 로드 완료!');

        // (1) 섹션 안에 직접 위치한 이미지 처리
        $('section:not(#map_section) > img').each(function () {
            const $img = $(this);
            const className = $img.attr('class');
            const naturalWidth = $img.prop('naturalWidth');
            const htmlWidth = $('html').width();
            const imageWidth = htmlWidth * naturalWidth / 2020;
            const parentsWidth = $img.parent().width();
            const percent = (imageWidth / parentsWidth) * 100;

            // 이미지에 계산된 width 적용
            $img.css('width', percent + '%');

            // CSS 코드로 저장
            if (className) {
                cssRules.push(`.${className} {\n  width: ${percent.toFixed(2)}%;\n}`);
            }
        });

        // (2) 섹션 내 div 포함 이미지 처리
        $('section:not(#map_section) div').each(function () {
            const $div = $(this);
            const $img = $div.children('img');

            if (
                $img.length === 1 &&
                $div.children('video:visible').length === 0 &&
                $div.children('p:visible').length === 0 &&
                $div.children('iframe:visible').length === 0
            ) {
                const className = $img.attr('class');
                const naturalWidth = $img.prop('naturalWidth');
                const htmlWidth = $('html').width();
                const windowWidth = 1905;
                const imageWidth = htmlWidth * naturalWidth / windowWidth;
                const parentsWidth = $div.parent().width();
                const percent = (imageWidth / parentsWidth) * 100;

                // div에 적용되는 스타일
                if ($div.css('display') !== 'flex') {
                    $div.css({
                        'display': 'flex',
                        'justify-content': 'center',
                        'align-items': 'center',
                        'width': percent + '%'
                    });
                }

                // 이미지에 reveal 클래스를 가진 경우
                if ($img.hasClass('reveal')) {
                    const vwPercent = (imageWidth / htmlWidth) * 98.8;
                    $img.css('width', vwPercent + 'vw');
                    $div.css('overflow', 'hidden');
                } else {
                    $img.css('width', '100%');
                }

                // 공통적으로 div에 overflow: hidden 적용
                $div.css('overflow', 'hidden');

                // CSS 코드로 저장
                if (className) {
                    cssRules.push(`.${className} {\n  width: ${percent.toFixed(2)}%;\n}`);
                }
            }
        });

        // (3) CSS 코드 출력
        setTimeout(function () {
            // if (cssRules.length) {
            //     console.log('CSS 코드 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓');
            //     console.log(cssRules.join('\n\n'));
            //     console.log('↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑');
            // } else {
            //     console.log('생성된 CSS 코드가 없습니다.');
            // }
        }, 500);
    });
});