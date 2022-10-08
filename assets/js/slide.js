import Splide from "@splidejs/splide";

new Splide( '.splide',{
    type : 'loop',
    speed: 600,
    autoplay: true,
    arrows: true,
    pagination: true,
    easing: 'linear',
    drag: true,
    perPage: 2,
    gap: 30,
    breakpoints: {
        768: {
            arrows: false
        },
        620: {
            perPage: 1,
        },
    }
} ).mount();