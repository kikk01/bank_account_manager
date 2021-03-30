import { jsonFetch} from './Component/jsonFetch'
import Routing from './Component/routing'

const collapseList = document.getElementsByClassName('collapse');

collapseList.forEach(function(collapseElement) {
    const movementId = collapseElement.id.substring(2);
    collapseElement.addEventListener('shown.bs.collapse', () =>
        jsonFetch(Routing.generate('movement_category_add_ajax', {id: movementId}))
            .then(response => {
                collapseElement.childNodes[1].innerHTML = response
            })
            .catch(error => {
                collapseElement.childNodes[1].innerHTML =
                    "Erreur : Le formulaire n'a pas pu être chargé. Veuillez recharger la page et essayer à nouveau ou contactez un administrateur."
            })
    )
})
