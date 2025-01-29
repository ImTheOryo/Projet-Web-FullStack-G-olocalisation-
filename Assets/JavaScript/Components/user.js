import {createOrModifyUser, verifyUser} from "../Services/user.js";
import {showToast} from "./Shared/toast.js";
import {handleComponent, handleDisplaySellPoint} from "./sell_point.js";

export const handleLogIn = () => {
        const logInBtn = document.querySelector("#log-in-button")
        logInBtn.addEventListener('click', async() => {
            let isValidUser
            const userForm = document.querySelector("#user-form")
            if (!userForm.checkValidity()){
                userForm.reportValidity()
                return false
            }
            isValidUser = await verifyUser(userForm)

            if (isValidUser['auth'] === true){
                showToast('Connexion réussie', 'bg-success')
                location.replace('index.php?component=map');

            } else {
                showToast('Une erreur est survenue', 'bg-danger')
            }
        })
    }



    export const handleUser = async () => {
        let info = null, id = null
        const component = 'user'
        const URL = new URLSearchParams(window.location.search)
        let action = URL.get('action')

        action === 'modify' ? id = URL.get('id') : null

        if (action === 'modify') {
            info = await handleComponent(component, action, id)
            displayUser(info['infos'][0])
        }


        const cancelBtn = document.querySelector("#cancel")
        cancelBtn.addEventListener('click', async() => {
            window.location.replace('index.php?component=users');
        })

        const createOrModifyBtn = document.querySelector("#send-btn")
        createOrModifyBtn.addEventListener('click', async() => {
            handleUserForm(action, id)
        })
    }

    export const handleUserForm = async (action, id = null) => {
        const form = document.querySelector('#userForm')
        if (!form.checkValidity()){
            form.reportValidity()
            return false
        }
        action === 'modify' ? action = 'modification' : null

        const result = await createOrModifyUser(action, id, form)
        if (result['success']){
            switch (action){
                case 'create':
                    form.reset()
                    showToast(`L'utilisateur a été crée`, 'bg-success')
                    break
                case 'modification':
                    await handleUser()
                    showToast(`L'utilisateur a été modifier`, 'bg-success')
                    break
            }
        }
        if (result['errors']){
            showToast(result['errors'], 'bg-danger')
        }

    }

    export const displayUser = (info) => {
        const form = document.querySelector("#userForm")
        form.elements['username'].value = info['username']
        form.elements['mail'].value = info['mail']
        form.elements['password'].required = false
        form.elements['password-confirm'].required = false
        if (info['enabled'] === 0){
            form.elements['enabled'].checked = false
        }
        form.elements['send-btn'].innerHTML = 'Modifier'

    }