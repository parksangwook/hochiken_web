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
                
                const tc_main = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".main",
                        toggleActions: "play none none none",
                    },
                })
                tc_main.from(".main_div", {
                    opacity: 0.8,
                    duration: 1,
                }, '< 30%').to(".main_div", {
                    scale: 1,
                }, '<').from(".main_pagination_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
                
                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div_02",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".con01_01_div", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con01_div_01 > p", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con01_div_02_left_div > p", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".menu_border",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".menu_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".menu_button_div > div", {
                    yPercent: 30,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con03_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con03_div_01 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_02 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_03 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_09_div", {
                    yPercent: 150,
                    duration: 1,
                }, '< 30%').from(".con03_10_div", {
                    y: -200,
                    opacity: 0,
                    duration: 1,
                    ease: "bounce.out"
                }, '< 30%').from(".con03_11_div", {
                    y: -200,
                    opacity: 0,
                    duration: 1,
                    ease: "bounce.out"
                }, '<')

                let typeSplit_con04_01 = new SplitType('.con04_text > p', {
                    types: 'chars',
                    tagName: 'span'
                })
                
                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con04_div_01",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con04_text > p .char", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.02,
                }, '< 30%')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con05_div", {
                    xPercent: 250,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_context",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con06_title", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_context_s", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc07 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc07.from(".con07_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_02_div", {
                    rotate: 180,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
                
            
                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".form_right",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".form_left_div_s", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".form > div", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')
            });
            gsap_displayHtml.add("(max-width: 599px)", () => {

                const tc_main = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".main",
                        toggleActions: "play none none none",
                    },
                })
                tc_main.from(".main_div", {
                    opacity: 0.8,
                    duration: 1,
                }, '< 30%').to(".main_div", {
                    scale: 1,
                }, '<').from(".main_pagination_div_m", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div_02",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".con01_01_div", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con01_div_01 > p", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con01_div_02_left_div > p", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".menu_border",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".menu_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".menu_button_div > div", {
                    yPercent: 30,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con03_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con03_div_01 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_02 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_03 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_09_div", {
                    yPercent: 150,
                    duration: 1,
                }, '< 30%').from(".con03_10_div", {
                    y: -200,
                    opacity: 0,
                    duration: 1,
                    ease: "bounce.out"
                }, '< 30%').from(".con03_11_div", {
                    y: -200,
                    opacity: 0,
                    duration: 1,
                    ease: "bounce.out"
                }, '<')

                let typeSplit_con04_01 = new SplitType('.con04_text > p', {
                    types: 'chars',
                    tagName: 'span'
                })
                
                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con04_div_01",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con04_text > p .char", {
                    opacity: 0.3,
                    duration: 1,
                    stagger: 0.02,
                }, '< 30%')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con05_div_01",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con05_text > p", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con05_text_row", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_right",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con06_title", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_context_s", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc07 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc07.from(".con07_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_02_div", {
                    rotate: 180,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')
                
            
                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".form_right",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".form_left_div_s", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".form > div", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')
                
            });
        });
    });
});
