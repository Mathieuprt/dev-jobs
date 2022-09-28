
let inputOffer = document.getElementById('searchbar_offers').value
    inputOffer=inputOffer.toLowerCase();
let x = document.getElementsByClassName('grid__item--offres');

inputOffer.addEventListener('onkeyup', function() {
    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(inputOffer)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="flex";
        }
    }
})

