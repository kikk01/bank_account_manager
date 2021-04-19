import { Controller } from 'stimulus'

export default class extends Controller {
    static targets = [
        'selectBlock',
        'selectElt',
        'newInputBlock',
        'newInputElt',
        'switchFieldBtn'
    ]

    initialize() {
        this.newInputBlockElt = this.newInputBlockTarget
        this.newInputFieldElt = this.newInputEltTarget
        this.selectBlockElt = this.selectBlockTarget
        this.selectFieldElt = this.selectEltTarget
        this.switchFieldBtn = this.switchFieldBtnTarget
    }

    connect() {
        console.log(this.selectFieldElt.options.length)
        if (this.selectFieldElt.options.length === 1) {
            this.displayNewInputBlock()
            this.disableDisplaySelectBtn()
        } else {
            this.displaySelectBlock()
        }
    }

    switchField() {
        this.selectBlockElt.classList.contains('d-none') ?
            this.displaySelectBlock() : this.displayNewInputBlock()
    }

    displayNewInputBlock() {
        this.selectBlockElt.classList.add('d-none')
        this.newInputBlockElt.classList.remove('d-none')
        this.switchFieldBtn.textContent = 'Sélectionner une catégorie'
    }

    displaySelectBlock() {
        this.selectBlockElt.classList.remove('d-none')
        this.newInputBlockElt.classList.add('d-none')
        this.newInputFieldElt.value = ''
        this.switchFieldBtn.textContent = 'Nouvelle catégorie'

    }

    disableDisplaySelectBtn() {
        this.switchFieldBtn.disabled = true
        this.switchFieldBtn.title = 'Veuillez créer une catégorie'
        this.switchFieldBtn.style.pointerEvents = 'auto'
        this.switchFieldBtn.style.cursor = 'not-allowed'
    }
}
