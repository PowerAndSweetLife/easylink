let bookingPackageListUpdated = false;
let detailListUpdated = false;

function chooseContainer(e, form) {
    e.preventDefault();
    const bookingModal = document.querySelector("#booking-modal")
    let modal = bootstrap.Modal.getOrCreateInstance(bookingModal);
    modal.show();

    bookingModal.querySelector('form.modal-content').setAttribute("action", form.getAttribute('action'));
    
    if(form.getAttribute('id') === 'form-for-checkbox'){
        bookingModal.querySelector('#append-booking-form').innerHTML = "";
        bookingModal.querySelector('#append-booking-form').append((form.querySelector('.input-wrapper')).cloneNode(true))
    }else {
        bookingModal.querySelector('#append-booking-form').innerHTML = form.innerHTML
    }
}

/**
 * Active/Desactive le boutton de soummission de formulaire
 */
function toggleButtonAddToContainer(checkbox) {
    const btnSubmit = document.querySelector('#btn-submit-adding-to-container');
    const checkboxes = document.querySelectorAll('.check-container-available')
    checkboxes.forEach(elem => {
        // if(elem.checked) {
        //     hasSelected = true
        // }
        if(elem !== checkbox){
            elem.checked = false;
        }
    })
    

    if(checkbox.checked) {
        btnSubmit.removeAttribute('disabled')
    }else {
        btnSubmit.setAttribute('disabled', '')
    }
}

document.querySelector("#detail-lists-modal")?.addEventListener('hidden.bs.modal', event => {
    if(detailListUpdated) {
        location.reload()
    }
})

function removeFromDetailList(e, form) {
    e.preventDefault()
    setModalLoader()
    detailListUpdated = true;
    axios.post(form.getAttribute('action'), new FormData(form), {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        document.querySelector("#detail-lists-modal .modal-content").innerHTML = response.data
    })
}