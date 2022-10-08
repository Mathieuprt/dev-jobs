
// Filtres pour les offres

document.getElementById('searchbar').addEventListener('keyup', filterList);
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
}



