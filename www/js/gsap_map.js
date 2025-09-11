document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');

    const promises = Array.from(images).map((img) => {
        return new Promise((resolve) => {
        if (img.complete) {
            resolve(); // 이미지가 이미 로드된 경우
        } else {
            img.addEventListener('load', resolve);
            img.addEventListener('error', resolve); // 오류도 로딩 완료로 처리
        }
        });
    });

    Promise.all(promises).then(() => {
        // 모든 이미지 로드 후 실행
        $(document).ready(function() {
            let gsap_displayHtml = gsap.matchMedia();

            gsap_displayHtml.add("(min-width: 1024px)", () => {

                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".map_section",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".map_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".map_icon", {
                    rotate: -90,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
            
            });
            gsap_displayHtml.add("(max-width: 599px)", () => {

                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".map_section",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".map_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".map_icon", {
                    rotate: -90,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
                
            });
        });
    });
});
