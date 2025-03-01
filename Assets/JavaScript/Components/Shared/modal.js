
    export const showModal = (title, message) => {
        const modal = new bootstrap.Modal('.modal')
        const modalTitle = document.querySelector('#modal-title')
        const modalBody = document.querySelector('#modal-body')
        modalTitle.innerHTML = ""
        modalTitle.innerHTML = title
        modalBody.innerHTML = ""
        modalBody.innerHTML = message
        modal.show()
        return modal
    }

    export const closeModal = (modal) => {
        modal.hide()
    }