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
        if (this.wrapper) return this.wrapper

        this.wrapper = document.createElement('div')
        this.wrapper.contentEditable = false

        this.mathField = document.createElement('math-field')
        this.mathField.value = this.data.latex || ''
        this.mathField.style.width = '100%'

        this.mathField.addEventListener('input', () => {
            this.data.latex = this.mathField.value
        })

        this.wrapper.appendChild(this.mathField)
        return this.wrapper
    }

    save() {
        try {
            // Finalize MathLive internal buffer
            this.mathField?.executeCommand?.('commit')
        } catch (e) {
        }

        return {
            latex: this.mathField?.value,
        }
    }
}
