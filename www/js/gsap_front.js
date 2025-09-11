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
                        trigger: ".main",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".main_text", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div_02_s",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".con01_div_03", {
                    xPercent: -75,
                    scale: 1.2,
                    duration: 1,
                }, '< 30%').from(".con01_div_01", {
                    xPercent: 30,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_02", {
                    xPercent: 30,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
            
                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con02_right_div",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con02_left_div > div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con02_right_div > div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con03_content",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con03_01_div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_02_div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con04_div",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con04_text_absol > div", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con05_div_02",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con05_div_01", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc07 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".video_content",
                        toggleActions: "play none none none",
                    },
                })
                tc07.to(".video_rltv", {
                    width: "90%",
                    height: "35vw",
                    duration: 1.5,
                }, '< 30%')

                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".con06_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_img_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con06_div_04", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con06_div_05_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_05_02 > div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

            });
            gsap_displayHtml.add("(max-width: 599px)", () => {

                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".main",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".main_text", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".con01_div_01", {
                    yPercent: 30,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_03", {
                    yPercent: 30,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_02_s > p", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')
            
                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con02_swiper_div_m",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con02_left_div > div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con02_right_div > div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con04",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con03_01_div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_02_div", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con04_right",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con04_text_absol > div", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con05_div_02",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con05_div_01", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".con06_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc09 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_04_m",
                        toggleActions: "play none none none",
                    },
                })
                tc09.from(".con06_img_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con06_div_04", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con06_div_05_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_05_02 > div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

            });
        });
    });
});
