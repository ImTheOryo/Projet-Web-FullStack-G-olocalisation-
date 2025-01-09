import {verifyUser} from "../Services/user.js";
import {showToast} from "./Shared/toast.js";

export const handleUser = () => {
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