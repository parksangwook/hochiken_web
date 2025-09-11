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
                }, '<')
                
                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".con01_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_06_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_07_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_08_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_absol", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_04 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                var counter01 = { var: 0 };
                var ta01 = document.getElementById('con02_ct')
            
                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con02_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".con02_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con02_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con02_text_rltv > p:nth-of-type(1)", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').to(counter01, {
                    var: 103239210,
                    duration:1.5,
                    opacity: 0,
                    ease: "circ.out",
                    onUpdate: function() {
                        ta01.innerHTML = numberWithCommas(Math.ceil(counter01.var));
                    },
                },'<').from(".con02_02_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con03_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con03_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_text_rtlv", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_04", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con05_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con05_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_01_div", {
                    rotate: -180,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_04_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_right_div > p", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con05_02_div", {
                    scale: 0,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con05_05_div", {
                    scale: 0,
                    opacity: 0,
                    duration: 1,
                }, '<')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con06_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con06_01_div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_02_div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_03 > .con06_box > div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc07 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_05",
                        toggleActions: "play none none none",
                    },
                })
                tc07.from(".con06_div_04 > .con06_box > div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con06_scr_absol", {
                    opacity: 0,
                }, '< 90%')

                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".con06_div_05 > .con06_box > div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con06_scr_absol2", {
                    opacity: 0,
                }, '< 90%')

                const tc09 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc09.from(".con07_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_bar_01", {
                    height: "0vw",
                    duration: 1,
                }, '<').from(".con07_bar_02", {
                    height: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_bar_04", {
                    height: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_bar_07", {
                    height: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_bar_06", {
                    height: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_bar_05", {
                    height: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_bar_03", {
                    height: "0vw",
                    duration: 2,
                }, '<').from(".con07_text_02", {
                    opacity: 0,
                    duration: 1,
                }, '<50%').from(".con07_text_01", {
                    opacity: 0,
                    duration: 1,
                }, '<50%').from(".con07_div_03_04_absol_01", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_02", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_03", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_04", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_12_div", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con07_10_div", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_11_div", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con07_01_img", {
                    scale: 0,
                    duration: 1,
                }, '<').from(".con07_02_img", {
                    scale: 0,
                    duration: 1,
                }, '<').to(".con07_nv_rltv > p", {
                    scale: 1,
                    opacity: 1,
                    duration: 0.2,
                }, '<90%').from(".con07_nv_rltv > p", {
                    onComplete: function() {
                        document.querySelectorAll(".con07_nv_rltv > p").forEach(function(img) {
                            img.classList.add("animate-blk");
                        });
                    }
                }, '< 100%')

                let scroll_con08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con08",
                        start: "0%",
                        end: "500%",
                        scrub: 1,
                        pin: true,
                        toggleActions: "play none none none",
                    },
                    defaults: { duration: 1, ease: "power1.out" },
                });
                
                scroll_con08.to(".con08_right_div", {
                    margin: "-82% 0% 0% 0%",
                },"<40%").to(".con08_move_img", {
                    top: "90%",
                },"<")

                const tc10 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con09_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc10.from(".con09_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con09_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con09_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                let scroll_con09 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con09",
                        start: "10%",
                        end: "500%",
                        scrub: 1,
                        pin: true,
                        toggleActions: "play none none none",
                    },
                    defaults: { duration: 1, ease: "power1.out" },
                });
                
                scroll_con09.to(".con09_div_04 > div", {
                    top: "0%",
                    opacity: 1,
                    stagger: 4,
                },"<40%")
                scroll_con09.to({}, { duration: 10 });

                const tc11 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con10_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc11.from(".con10_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_arrow_absol", {
                    yPercent: 150,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_08_div", {
                    xPercent: -150,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con10_text_absol", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc12 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con11_right_div",
                        toggleActions: "play none none none",
                    },
                })
                tc12.from(".con11_left_div > div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con11_swiper", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc13 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con12_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc13.from(".con12_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con12_div_02 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc14 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con13_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc14.from(".con13_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con13_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con13_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                var counter02 = { var: 0 };
                var ta02 = document.getElementById('con14_ct')

                const tc15 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con14_swiper",
                        toggleActions: "play none none none",
                    },
                })
                tc15.from(".con14_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_03_div", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_ct_absol", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 50%').to(counter02, {
                    var: 86,
                    duration:1.5,
                    opacity: 0,
                    ease: "circ.out",
                    onUpdate: function() {
                        ta02.innerHTML = numberWithCommas(Math.ceil(counter02.var));
                    },
                },'<').from(".con14_blk_rltv", {
                    opacity: 0,
                    duration: 1,
                }, '< 70%')

                const tc16 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con15_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc16.from(".con15_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con15_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con15_01_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc17 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".formWrap_div",
                        toggleActions: "play none none none",
                    },
                })
                tc17.from(".form_title_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".form_title_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".form_left_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".form_right_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".form_index_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con16_02_div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
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
                }, '<')
                
                const tc01 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con01_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc01.from(".con01_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_06_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_07_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_08_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con01_absol", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con01_div_04 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                var counter01 = { var: 0 };
                var ta01 = document.getElementById('con02_ct')
            
                const tc02 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con02_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc02.from(".con02_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con02_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con02_text_rltv > p:nth-of-type(1)", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').to(counter01, {
                    var: 103239210,
                    duration:1.5,
                    opacity: 0,
                    ease: "circ.out",
                    onUpdate: function() {
                        ta01.innerHTML = numberWithCommas(Math.ceil(counter01.var));
                    },
                },'<').from(".con02_02_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc03 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con03_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc03.from(".con03_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_text_rtlv", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con03_div_04", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc04 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con05_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc04.from(".con05_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_01_div", {
                    rotate: -180,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_04_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con05_right_div > p", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con05_02_div", {
                    scale: 0,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con05_05_div", {
                    scale: 0,
                    opacity: 0,
                    duration: 1,
                }, '<')

                const tc05 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc05.from(".con06_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc06 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_m_02",
                        toggleActions: "play none none none",
                    },
                })
                tc06.from(".con06_01_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_02_div", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con06_div_03 > .con06_box > div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc07 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con06_div_05",
                        toggleActions: "play none none none",
                    },
                })
                tc07.from(".con06_div_04 > .con06_box > div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con06_scr_absol", {
                    opacity: 0,
                }, '< 90%')

                const tc08 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07",
                        toggleActions: "play none none none",
                    },
                })
                tc08.from(".con06_div_05 > .con06_box > div", {
                    xPercent: -50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con06_scr_absol2", {
                    opacity: 0,
                }, '< 90%')

                const tc09 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con07_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc09.from(".con07_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con07_right_m_01", {
                    width: "0vw",
                    duration: 1,
                }, '<').from(".con07_right_m_04", {
                    width: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_right_m_02", {
                    width: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_right_m_05", {
                    width: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_right_m_03", {
                    width: "0vw",
                    duration: 2,
                }, '<10%').from(".con07_right_bar_m > p", {
                    opacity: 0,
                    duration: 1,
                }, '<50%').from(".con07_div_03_04_absol_01", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_02", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_03", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_div_03_04_absol_04", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_12_div", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con07_10_div", {
                    opacity: 0,
                    duration: 1,
                }, '<30%').from(".con07_11_div", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con07_nv_absol", {
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con07_01_img", {
                    scale: 0,
                    duration: 1,
                }, '<').from(".con07_02_img", {
                    scale: 0,
                    duration: 1,
                }, '<').to(".con07_nv_rltv > p", {
                    scale: 1,
                    opacity: 1,
                    duration: 0.2,
                }, '<90%').from(".con07_nv_rltv > p", {
                    onComplete: function() {
                        document.querySelectorAll(".con07_nv_rltv > p").forEach(function(img) {
                            img.classList.add("animate-blk");
                        });
                    }
                }, '< 100%')

                const tc11_m = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con08_div_m_02",
                        toggleActions: "play none none none",
                    },
                })
                tc11_m.from(".con08_div_m_01 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con08_text_row", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%').from(".con08_div_m_02 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc10 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con09_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc10.from(".con09_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con09_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con09_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc11 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con10_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc11.from(".con10_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_arrow_absol", {
                    yPercent: 150,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_08_div", {
                    xPercent: -150,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con10_text_absol", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con10_09_div", {
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                const tc12 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con11_right_div",
                        toggleActions: "play none none none",
                    },
                })
                tc12.from(".con11_left_div > div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%').from(".con11_swiper", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc13 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con12_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc13.from(".con12_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con12_div_02 > p", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                    stagger: 0.2,
                }, '< 30%')

                const tc14 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con13_div_04",
                        toggleActions: "play none none none",
                    },
                })
                tc14.from(".con13_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con13_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con13_div_03", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

                var counter02 = { var: 0 };
                var ta02 = document.getElementById('con14_ct')

                const tc15 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con14_swiper",
                        toggleActions: "play none none none",
                    },
                })
                tc15.from(".con14_ct_absol", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 50%').to(counter02, {
                    var: 86,
                    duration:1.5,
                    opacity: 0,
                    ease: "circ.out",
                    onUpdate: function() {
                        ta02.innerHTML = numberWithCommas(Math.ceil(counter02.var));
                    },
                },'<').from(".con14_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_03_div", {
                    yPercent: 20,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con14_blk_rltv", {
                    opacity: 0,
                    duration: 1,
                }, '< 70%')

                const tc16 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".con15_div_03",
                        toggleActions: "play none none none",
                    },
                })
                tc16.from(".con15_div_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con15_div_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".con15_01_div", {
                    opacity: 0.3,
                    duration: 1,
                }, '< 30%')

                const tc17 = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".formWrap_div",
                        toggleActions: "play none none none",
                    },
                })
                tc17.from(".form_title_01", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".form_title_02", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%').from(".form_left_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".form_right_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".form_index_left", {
                    yPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '<').from(".con16_02_div", {
                    xPercent: 50,
                    opacity: 0,
                    duration: 1,
                }, '< 30%')

            });
        });
    });
});
