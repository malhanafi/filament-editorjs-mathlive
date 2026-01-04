export default class MathBlock {
    static get toolbox() {
        return {
            title: 'Math',
            icon: '∑',
        }
    }

    constructor({ data }) {
        this.data = data || { latex: '' }
        this.wrapper = null
        this.mathField = null
    }

    render() {
        if (!this.wrapper) {
            this.wrapper = document.createElement('div')

            this.wrapper.contentEditable = false

            this.mathField = document.createElement('math-field')
            this.mathField.id = 'mathfield-' + Math.random().toString(36).substr(2, 9);
            this.mathField.value = this.data.latex || ''
            this.mathField.style.width = '100%'

            this.wrapper.appendChild(this.mathField)
        }

        return this.wrapper
    }

    save() {
        return {
            latex: this.mathField.value,
        }
    }
}
