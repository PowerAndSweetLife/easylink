<script>

    const regexpForNumber = new RegExp(/[\d.]/)
    const regexpForInteger = new RegExp(/[\d]/)
    const ignoredKeysForInput = [
        'Enter', 
        'Backspace', 
        'Tab', 
        'Shift', 
        'CapsLock', 
        'AltGGraph', 
        'Delete',
        'ArrowLeft',
        'ArrowRight'
    ]
    const regexpForEmail = new RegExp(/[\w\d\-]+@[\w\-]+\.[a-z]+/i)

    document.querySelectorAll('.number-only').forEach( input => {
        input.addEventListener('keydown', (e) => {
            const key = e.key
            if(!ignoredKeysForInput.includes(key) && regexpForNumber.exec(key) === null) {
                e.preventDefault()
            }

        })
    })
    document.querySelectorAll('.integer-only').forEach( input => {
        input.addEventListener('keydown', (e) => {
            const key = e.key
            if(!ignoredKeysForInput.includes(key) && regexpForInteger.exec(key) === null) {
                e.preventDefault()
            }

        })
    })

    document.querySelectorAll('.js-form').forEach( form => {
        form.addEventListener('submit', (e) => {
            // e.preventDefault();
            let errors = [];
            document.querySelectorAll('.is-invalid').forEach(input => {
                input.classList.remove('is-invalid')
            })
            document.querySelectorAll('.invalid-feedback').forEach(span => {
                span.remove()
            })
            document.querySelectorAll('label.with-feedback').forEach(label => {
                label.classList.remove('with-feedback')
            })
            form.querySelectorAll('[data-rules]').forEach( field => {
                const rules = field.dataset.rules.split(',')
                const validator = new FormValidator(rules);
                if(!validator.validated(field)) {
                    errors.push({
                        "message" : validator.getError(),
                        "field" : field
                    })
                }
            }) 

            if(errors.length > 0) {
                e.preventDefault()
                for(const e of errors) {
                    e.field.classList.add('is-invalid')
                    const spanInvalidFeedback = document.createElement('span')
                    spanInvalidFeedback.classList.add('invalid-feedback')
                    spanInvalidFeedback.innerText = e.message
                    if(e.field.dataset.autocomplete === undefined) {
                        const eyeIconLabel = e.field.parentNode.querySelector('label.toggle-password')
                        if(eyeIconLabel) {
                            eyeIconLabel.classList.add('with-feedback')
                        }
                        e.field.parentNode.append(spanInvalidFeedback);
                    } else {
                        e.field.parentNode.classList.add('is-invalid')
                        e.field.parentNode.parentNode.append(spanInvalidFeedback);
                    }
                }
                errors[0].field.focus()
            } else {
                const btnSubmit = document.querySelector('.btn-submit')
                if(btnSubmit) {
                    btnSubmit.setAttribute('disabled', "")
                    btnSubmit.querySelector('span:last-child').innerHTML = `<span class="loader"><svg viewBox="25 25 50 50"><circle r="20" cy="50" cx="50"></circle></svg></span>`
                }
            }

            
        })            
    })

    const inputDimension = document.querySelector('#input-dimension')
    const sumAllVolume = document.querySelector("#sum-all-volume")
    let numberOfInputDimension = document.querySelectorAll('.input-dimension-item').length

    document.querySelector("#remove-dimension")?.addEventListener('click', () => {
        if(numberOfInputDimension > 1) {
            inputDimension.querySelector('.input-dimension-item:last-child').remove()
            numberOfInputDimension--
        }
        sumAllVolumes()
    })
    document.querySelector("#add-dimension")?.addEventListener('click', () => {
        numberOfInputDimension++;
        const dimensionFields = [
            new InputDimension('{{ __("Count") }}', null, ['dimension-js'], true, 1),
            new InputDimension('{{ __("Length") }}', "cm", ['dimension-js'], true),
            new InputDimension('{{ __("Width") }}', "cm", ['dimension-js'], true),
            new InputDimension('{{ __("Height") }}', "cm", ['dimension-js'], true),
            new InputDimension('{{ __("Unit weight") }}', "kg", []),
            new InputDimension('{{ __("Volume") }}', null, ['total-volume-item'], true)
        ] 
        const itemFloating = document.createElement('div')
        itemFloating.classList.add('input-dimension-item')
        itemFloating.classList.add('mt-2')

        for(const input of dimensionFields)
        {
            
            const formFloating = document.createElement('div')
            const inputFloating = document.createElement('input')
            const labelFloating = document.createElement('label')
            let classes = ['form-control number-only']
            for(let _class of input.classes) {
                classes.push(_class)
            }

            inputFloating.setAttribute('class', classes.join(' '))
            inputFloating.setAttribute('placeholder', '1')
            inputFloating.setAttribute('type', 'text')
            inputFloating.setAttribute('name', `dimensions[${numberOfInputDimension}][]`)
            if(input.default) {
                inputFloating.value = input.default
            }

            labelFloating.setAttribute('class', 'fs-12')
            labelFloating.innerText = input.label

            formFloating.classList.add('form-floating')
            formFloating.append(inputFloating)
            formFloating.append(labelFloating)

            itemFloating.append(formFloating)
        }
        inputDimension.append(itemFloating)

        document.querySelectorAll('.dimension-js').forEach(item => {
            item.addEventListener('keyup', () => calculDimension(item))
        })
    })

    document.querySelectorAll('.btn-with-confirm').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            Swal.fire({
                title: `{{ __('Are you sure ?') }}`,
                text: `{!! __("You won't be able to revert this !") !!}`,
                icon: 'question',
                width: '24rem',
                showCancelButton: true,
                confirmButtonColor: '#e17055',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: `{{ __('Continue') }}`,
                cancelButtonText: `{{ __('Cancel') }}`,
            }).then((result) => {
                if (result.isConfirmed) {
                    button.parentElement.submit()
                }
            })
        })
    })

    let lang = "{{ user('app_lang') }}"
    try{
        if(lang === 'fr') {
            flatpickr.localize(flatpickr.l10ns.fr);
        } else {
            flatpickr.localize(flatpickr.l10ns.default);
        }
        flatpickr(".date-input", {
            altInput: true,
            altFormat: "j F Y",
            altInputClass: "form-control real-date",
        });
    }catch(e) {

    }

    document.querySelectorAll('.dimension-js').forEach(item => {
        item.addEventListener('keyup', () => calculDimension(item))
    })

    function calculDimension(item) {
        const parent = item.parentNode.parentNode
        let dimensions = parent.querySelectorAll('.dimension-js')
        let count = parseFloat(dimensions[0].value)
        let length = parseFloat(dimensions[1].value)
        let width = parseFloat(dimensions[2].value)
        let height = parseFloat(dimensions[3].value)
        
        let volume = count * length * width * height * Math.pow(10, -6)

        parent.querySelectorAll('.total-volume-item').forEach(item => {
            if(!Number.isNaN(volume)) {
                item.value = volume.toFixed(2) + " m³"
            } else {
                item.value = null
            }
        })

        sumAllVolumes()
        
    }

    function sumAllVolumes() {
        let sumVolume = 0
        document.querySelectorAll('.total-volume-item').forEach(item => {
            let value = parseFloat(item.value)
            if(Number.isNaN(value)) {
                value = 0
            }
            sumVolume += value
            if(sumVolume > 0) {
                sumAllVolume.classList.remove('d-none')
                sumAllVolume.querySelector('strong').innerHTML = sumVolume.toFixed(2) + " m³"
            } else {
                sumAllVolume.classList.add('d-none')
            }
        })
    }

    /**
     *  Classes
     * */
    class FormValidator {
        constructor(rules) {
            this.rules = rules
            this.error = null
        }
        validated(field) {
            const passwordFields = ["password", "confirm-password", "new-password"]
            for(const r of this.rules) {
                switch (r) {
                    case 'required':
                        let value = field.value.trim()
                        if(passwordFields.includes(field.getAttribute('name'))) {
                            value = field.value
                        }
                        if(value === '') {
                            this.error = "{{ __('validation.required') }}"
                        }
                        break;
                    case 'confirm-password':
                        let toCompare = null
                        if (field.getAttribute('name') === 'password') {
                            toCompare = document.querySelector('input[name=confirm-password]')
                        } else if (field.getAttribute('name') === 'confirm-password') {
                            toCompare = document.querySelector('input[name=password]')
                        }
                        if(toCompare && toCompare.value !== '' && toCompare.value !== field.value) {
                            this.error = "{{ __('The two passwords are different') }}"
                        }
                        break;
                    case 'email':
                        if(regexpForEmail.exec(field.value) === null) {
                            this.error = "{{ __('validation.email') }}"
                        }
                        break;
                    default:
                        break;
                }
                if(this.error) {
                    return false;
                }
            }
            return true;
        }
        getError() {
            return this.error
        }
    }

    class InputDimension {

        constructor(label, unit = null, classes = [], listener = false, _default = null) {
            this.classes = classes
            this.label = label
            if(unit) {
                this.label += `(${unit})`
            }
            this.listener = listener
            this.default = _default
        }
    }
    
</script>