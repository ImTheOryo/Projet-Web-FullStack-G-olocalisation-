
    export const getAllInfos = async (componentName, page = null, limit = null, sortBy = null) => {
        let request = `index.php?component=${componentName}&action=need_infos`
        if (page !== null){
            request += `&page=${page}`
        }
        if (limit !== null){
            request += `&limit=${limit}`
        }
        if (sortBy !== null){
            request += `&sortBy=${sortBy}`
        }
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

    export const getCount = async (componentName) => {
        let request = `index.php?component=${componentName}&action=count`

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



