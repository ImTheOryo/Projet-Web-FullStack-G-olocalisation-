

export const getInfo = async (component, action = null, id = null) => {
        let request = `index.php?component=${component}`
        action !== null ? request += `&action=${action}` : null;
        id !== null ? request += `&id=${id}` : null;
        const res = await fetch (request, {
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

    export const deleteSellPoint = async (id) => {
        let request = `index.php?component=sell_points&action=delete&id=${id}`
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

    export const createOrModifySellPoint = async (form, schedule, action, id = null) => {

        let request = `index.php?component=sell_point&action=${action}`
        id !== null ? request += `&id=${id}` : null
        let data =  new FormData(form)
        data.append('schedule', schedule)
        const res = await fetch(request, {
            method: "POST",
            headers:{
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        })
        if (res.status === 200) {
            return await res.json()
        } else {
            return await res.json()
        }
    }

    export const getGroupName = async () => {
        let request = `index.php?component=sell_point&action=group`

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