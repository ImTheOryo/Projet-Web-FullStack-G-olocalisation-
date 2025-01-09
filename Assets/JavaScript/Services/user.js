
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