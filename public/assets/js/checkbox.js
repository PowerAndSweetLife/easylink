const checkAll = document.querySelector("#check-all")
const checkedCount = document.querySelector("#checked-count")
const formForCheckbox = document.querySelector('#form-for-checkbox')

let checked = 0;

let totalCBM = 0;

if(checkAll !== null) {
    const checkItems = document.querySelectorAll('.check-item')
    checkAll.addEventListener('change', (e) => {
        const isChecked = e.currentTarget.checked
        if(isChecked) {
            checked = checkItems.length
        } else {
            checked = 0
        }

        toggleCheckAll(checkItems, isChecked)
        toggleForm()
    })

    checkItems.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            if(checkbox.checked) {
                checked++
                if(checked === checkItems.length) {
                    checkAll.checked = true
                }
                if(checkbox.dataset.cbm) {
                    totalCBM += Number(checkbox.dataset.cbm)
                }
            } else {
                checked--
                checkAll.checked = false
                
                if(checkbox.dataset.cbm) {
                    totalCBM -= Number(checkbox.dataset.cbm)
                }
            }
            checkedCount.innerText = checked
            toggleForm()
        })
    })

}

function toggleCheckAll(checkboxes, isChecked) {
    checkedCount.innerText = checked
    checkboxes.forEach((checkbox) => {
        checkbox.checked = isChecked
        if(checkbox.dataset.cbm) {
            if(isChecked) {
                totalCBM += Number(checkbox.dataset.cbm)
            }
        }
    });
    if(!isChecked) {
        totalCBM = 0;
    }
}

function toggleForm() {
    if(checked > 0) {
        formForCheckbox.classList.remove('d-none')
    } else {
        formForCheckbox.classList.add('d-none')
    }

    let inputWrapper = formForCheckbox.querySelector('.input-wrapper')
    if(inputWrapper === null)
    {
        inputWrapper = document.createElement('div')
        inputWrapper.classList.add('input-wrapper')
        inputWrapper.classList.add('d-none')
        formForCheckbox.prepend(inputWrapper) 
    }
    else
    {
        inputWrapper.innerHTML = ""
    }

    document.querySelectorAll('.check-item:checked').forEach(checkbox => {
        inputWrapper.append(checkbox.cloneNode(true))
    })

    const totalCbmNode = document.querySelector('#total-cbm-to-container')
    if(totalCbmNode) {
        totalCbmNode.innerText = totalCBM + " m³"
    }

}