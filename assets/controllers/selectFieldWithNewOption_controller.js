import { Controller } from 'stimulus'

export default class extends Controller {
    static targets = [
        'selectBlock',
        'selectElt',
        'inputBlock',
        'inputElt',
        'displaySelectBtn'
    ]

    initialize() {
        this.inputBlockElt = this.inputBlockTarget
        this.inputFieldElt = this.inputEltTarget
        this.selectBlockElt = this.selectBlockTarget
        this.selectFieldElt = this.selectEltTarget
        this.displaySelectBtn = this.displaySelectBtnTarget
    }

    connect() {
        if (this.selectFieldElt.options.length === 0) {
            this.displayNewOptionField()
            this.disableDisplaySelectBtn()
        } else if (this.selectFieldElt.value === '') {
            this.displayNewOptionField()
        } else {
            this.displaySelectField()
        }
    }

    checkOptionSelected() {
        if (this.selectFieldElt.value === '') {
            this.displayNewOptionField()
        }
    }

    displayNewOptionField() {
        this.selectBlockElt.classList.add('d-none')
        this.inputBlockElt.classList.remove('d-none')
    }

    displaySelectField() {
        this.selectBlockElt.classList.remove('d-none')
        this.inputBlockElt.classList.add('d-none')
        this.inputFieldElt.value = ''
    }

    disableDisplaySelectBtn() {
        this.displaySelectBtn.disabled = true
        this.displaySelectBtn.title = 'Veuillez créer une catégorie'
        this.displaySelectBtn.style.pointerEvents = 'auto'
        this.displaySelectBtn.style.cursor = 'not-allowed'
    }
}
