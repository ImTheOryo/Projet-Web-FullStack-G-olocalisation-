
    export const    showToast = (message, color) => {
        const toastMessageElement = document.querySelector('#toast')
        const toastBody = toastMessageElement.querySelector('.toast-body')
        const toastMessage = new bootstrap.Toast(toastMessageElement, {delay : 10000})
        toastBody.innerHTML = ""
        toastBody.innerHTML = message
        if (toastMessageElement.classList.contains("text-bg-success")){
            toastMessageElement.classList.remove("text-bg-success")
        }
        if (toastMessageElement.classList.contains("text-bg-danger")){
            toastMessageElement.classList.remove("text-bg-danger")
        }
        toastMessageElement.classList.add(`text-${color}`)

        toastMessage.show()
    }