
const wrapper = document.querySelector("#wrapper")
const sidebarMobile = document.querySelector("#sidebar-mobile")
document.querySelector('#toggle-sidebar-desktop')?.addEventListener('click', () => {
    wrapper.classList.toggle('with-sidebar-sm')
})
document.querySelector('#toggle-sidebar-mobile')?.addEventListener('click', () => {
    sidebarMobile.classList.toggle('show')
})

// document.querySelectorAll('.content .form').forEach( element => {
//     element.style.overflowY = 'hidden'
//     element.addEventListener('pointerdown', (e) => {
//         e.preventDefault();
//         element.style.overflowY = 'auto'
//     })
//     element.addEventListener('pointerup', (e) => {
//         e.preventDefault();
//         element.style.overflowY = 'hidden'
//     })
//     element.addEventListener('mouseover', (e) => {
//         e.preventDefault();
//         element.style.overflowY = 'auto'
//     })
//     element.addEventListener('mouseleave', (e) => {
//         e.preventDefault();
//         element.style.overflowY = 'hidden'
//     })
// })

document.querySelectorAll('input[type=password]').forEach((input, key) => {
    const passwordWrapper = document.createElement('div')
    const passwordCheckbox = document.createElement('input')
    const passwordEye = document.createElement('label')
    const passwordFeedback = input.nextElementSibling

    passwordEye.setAttribute('for', `password-${key}`)
    passwordEye.setAttribute('class', 'toggle-password')
    if(input.classList.contains('form-control-lg')) {
        passwordEye.classList.add('toggle-password-lg')
    }
    passwordEye.innerHTML = '<i class="fa-regular fa-eye"></i>'
    passwordCheckbox.setAttribute('class', 'd-none')
    passwordCheckbox.setAttribute('id', `password-${key}`)
    passwordCheckbox.setAttribute('type', 'checkbox')
    passwordWrapper.classList.add('position-relative')

    passwordCheckbox.addEventListener('change', e => {
        if(e.currentTarget.checked) {
            input.setAttribute('type', 'text')
            passwordEye.innerHTML = '<i class="fa-regular fa-eye-slash"></i>'
        } else {
            input.setAttribute('type', 'password')
            passwordEye.innerHTML = '<i class="fa-regular fa-eye"></i>'
        }
        e.currentTarget.nextElementSibling.focus()
    })

    const inputPasswordParentNode = input.parentNode
    passwordWrapper.append(passwordEye)
    passwordWrapper.append(passwordCheckbox)
    passwordWrapper.append(input)
    if(passwordFeedback) {
        passwordWrapper.append(passwordFeedback)
        passwordEye.classList.add('with-feedback')
    }
    inputPasswordParentNode.append(passwordWrapper)
})

let timeout = setTimeout(() => {
    clearTimeout()
    const requestFeedback = document.querySelector('.request-feedback')
    if(requestFeedback) {
        requestFeedback.classList.add('hide')
    }
}, 5000);

