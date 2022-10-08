// Fonction gérant l'API

const testimonyList = document.querySelector('.splide__list');

async function getTestimonials(){
    let response = await fetch('https://testimonialapi.toolcarton.com/api',{
        headers: {'Accept': "application/json"},

    })

    let datas = await response.json();


    datas.forEach((data) => {
        // Gestion de l'image
        const testimonyImg = document.createElement('img')
        testimonyImg.src = data.avatar

        const testimonyPicture = document.createElement('picture')
        testimonyPicture.className = 'testimonial__img'

        testimonyPicture.appendChild(testimonyImg)

        // Gestion des infos du client

        const zoneClient = document.createElement('div')
        zoneClient.className = 'testimonial__client'

        const infosClient = document.createElement('div')
        infosClient.className ='testimonial__infos'

        const nameClient = document.createElement('p')
        nameClient.className = 'testimonial__infos--name'
        nameClient.textContent = data.name

        const cityClient = document.createElement('p')
        cityClient.className = 'testimonial__infos--city'
        cityClient.textContent = data.location

        infosClient.appendChild(nameClient)
        infosClient.appendChild(cityClient)

        zoneClient.appendChild(infosClient)
        zoneClient.appendChild(testimonyPicture)

        // Zone quote + création de l'item

        const quote = document.createElement('p')
        quote.className = 'testimonial__quote'
        quote.textContent = data.message

        const item = document.createElement('li')
        item.className = 'splide__slide testimonial__item'

        item.appendChild(quote)
        item.appendChild(zoneClient)

        testimonyList.appendChild(item)

    })
}

getTestimonials();