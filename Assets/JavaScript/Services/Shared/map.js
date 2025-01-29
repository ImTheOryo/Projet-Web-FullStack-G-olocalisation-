
    export const getGeoJson = async () => {
        let request = `index.php?component=map&action=getGeoJson`
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