import Splide from "@splidejs/splide";

// MENU

const toggleMenu = document.querySelector(".toggle-menu");
const menu = document.querySelector(".main-menu");

toggleMenu.addEventListener("click", function () {
  const open = JSON.parse(toggleMenu.getAttribute("aria-expanded"));
  toggleMenu.setAttribute("aria-expanded", !open);
  toggleMenu.classList.toggle("active");
  menu.hidden = !menu.hidden;
  menu.classList.toggle("opened");
  document.body.classList.toggle("noscroll");

  if (!menu.hidden) {
    menu.querySelector("a").focus();
  }
});

// Fonction gérant l'API

const testimonyList = document.querySelector(".splide__list");

async function getTestimonials() {
  let response = await fetch("https://testimonialapi.toolcarton.com/api", {
    headers: { Accept: "application/json" },
  });

  let datas = await response.json();

  console.log(datas);

  datas.forEach((data) => {
    // Gestion de l'image
    const testimonyImg = document.createElement("img");
    testimonyImg.src = data.avatar;

    const testimonyPicture = document.createElement("picture");
    testimonyPicture.className = "testimonial__img";

    testimonyPicture.appendChild(testimonyImg);

    // Gestion des infos du client

    const zoneClient = document.createElement("div");
    zoneClient.className = "testimonial__client";

    const infosClient = document.createElement("div");
    infosClient.className = "testimonial__infos";

    const nameClient = document.createElement("p");
    nameClient.className = "testimonial__infos--name";
    nameClient.textContent = data.name;

    const cityClient = document.createElement("p");
    cityClient.className = "testimonial__infos--city";
    cityClient.textContent = data.location;

    infosClient.appendChild(nameClient);
    infosClient.appendChild(cityClient);

    zoneClient.appendChild(infosClient);
    zoneClient.appendChild(testimonyPicture);

    // Zone quote + création de l'item

    const quote = document.createElement("p");
    quote.className = "testimonial__quote";
    quote.textContent = data.message;

    const item = document.querySelector(".testimonial__item.splide__slide");

    item.appendChild(quote);
    item.appendChild(zoneClient);

    testimonyList.appendChild(item);
  });
}

getTestimonials();

// SLIDER

new Splide(".splide", {
  type: "loop",
  speed: 600,
  autoplay: true,
  arrows: true,
  pagination: true,
  easing: "linear",
  perPage: 2,
  gap: 30,
  breakpoints: {
    768: {
      arrows: false,
    },
    620: {
      perPage: 1,
    },
  },
}).mount();

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
