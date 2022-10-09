import Splide from "@splidejs/splide";


// MENU


const toggleMenu = document.querySelector('.toggle-menu');
const menu = document.querySelector('.main-menu');

toggleMenu.addEventListener('click', function () {
    const open = JSON.parse(toggleMenu.getAttribute('aria-expanded'));
    toggleMenu.setAttribute('aria-expanded', !open);
    toggleMenu.classList.toggle('active');
    menu.hidden = !menu.hidden;
    menu.classList.toggle('opened')
    document.body.classList.toggle('noscroll');

    if (!menu.hidden) {
        menu.querySelector('a').focus();
    }
});


// SLIDER

new Splide( '.splide',{
    type : 'loop',
    speed: 600,
    autoplay: true,
    arrows: true,
    pagination: true,
    easing: 'linear',
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


// FILTRE

 /*document.getElementById('searchbar').addEventListener('keyup', filterList);
function filterList(){
    const searchInput = document.getElementById('searchbar')
    const filter = searchInput.value.toLowerCase()

    const items = document.querySelectorAll('.grid__item')

    items.forEach((item)=>{
        let text = item.textContent

        if (text.toLowerCase().includes(filter.toLowerCase())){
            item.style.display = ''
        }
        else {
            item.style.display = 'none'
        }
    })
} */




