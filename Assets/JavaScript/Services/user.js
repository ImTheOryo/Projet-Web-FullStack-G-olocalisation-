
    export const verifyUser = async (userForm) => {
        const data = new FormData(userForm)
        const res = await fetch('index.php?component=login&action=verify', {
            method: "POST",
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        })
        return res.json()
    }

    export const deleteUser = async (id) => {
        let request = `index.php?component=users&action=delete&id=${id}`
        const res = await fetch(request, {
            method: "GET",
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        if (res.status === 200) {
            return await res.json()
        } else {
            return await res.json()
        }
    }

    export const createOrModifyUser = async (action, id = null, form) => {
        let request = `index.php?component=user&action=${action}`
        id !== null ? request += `&id=${id}` : null

        const data = new FormData(form)
        const res = await fetch(request, {
            method: "POST",
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        })
        return res.json()
    }