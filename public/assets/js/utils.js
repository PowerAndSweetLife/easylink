function _stopPropagation(e) {
    console.log(e);
    console.log(e.stopPropagation());
}


function openDetailModal(e, link) {
    e.preventDefault();
    const detailModal = document.querySelector("#detail-lists-modal")
    let modal = bootstrap.Modal.getOrCreateInstance(detailModal);
    
    setModalLoader()

    const url = link.getAttribute('href');
    axios.get(url)
        .then(response => {
            detailModal.querySelector('.modal-content').innerHTML = response.data
        })
    modal.show();
}
function setModalLoader() {
    const detailModalContent = document.querySelector("#detail-lists-modal .modal-content")
    const modalLoading = document.querySelector("#modal-detail-loading-template").content.cloneNode(true).querySelector('.modal-loading-template');
    //packageModalContent.innerHTML = null;
    detailModalContent.append(modalLoading);
}

function showEvent(elem) {
    const eventModal = document.querySelector("#event-date-modal")
    const eventModalContent = eventModal.querySelector(".modal-body")
    let modal = bootstrap.Modal.getOrCreateInstance(eventModal);
    modal.show()

    const target = elem.dataset.target
    eventModalContent.innerHTML = null
    eventModalContent.append(document.querySelector(target).content.cloneNode(true).querySelector('table'))
}

