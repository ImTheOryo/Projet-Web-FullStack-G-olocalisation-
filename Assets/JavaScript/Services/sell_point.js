
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