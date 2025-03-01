import {showToast} from "./Shared/toast.js";
import {closeModal, showModal} from "./Shared/modal.js";
import {createOrModifySellPoint, getInfo, getGroupName} from "../Services/sell_point.js";
import {addMarker, addPopUp, updateView} from "./Shared/map.js";
import {DAY_OF_THE_WEEK, UPLOADPATH} from "../Config/constant.js";


    export const handleComponent = async (component, action = null, id = null) => {
            let info
            if (action === 'modify'){
                info = await getInfo(component, action, id)
            }
            if (info['errors']){
                showToast(info['errors'], 'bg-danger')
            } else {
                return info
            }
        }

    export const handleDisplaySellPoint = async (map) => {
        const URL = new URLSearchParams(window.location.search)
        let marker = null, id = null, info = []
        let component = URL.get('component')
        let action = URL.get('action')
        const formElement = document.querySelector('#formSellPoint')
        handleGroupName()
        action === 'modify' ? id = URL.get('id') : null
        if (action === 'modify'){
            info = await handleComponent(component, action, id)
            displaySellPoint(formElement, info['infos'][0])
            map = updateView(map, info['infos'][0],16)
            marker = addMarker(map,info['infos'][0])
            addPopUp(marker, info['infos'][0])
        }
        handleSchedule()
        handleAddress(map, marker, info)

        const sendForm = document.querySelector('#send-btn')
        const cancel = document.querySelector('#cancel')
        cancel.addEventListener('click', () => {
            window.location.href = "index.php?component=sell_points"
        })

        sendForm.addEventListener('click', () => {
            handleForm(map)
        })
    }

    export const handleForm = async (map) => {

        const form = document.querySelector('#formSellPoint')
        const URL = new URLSearchParams(window.location.search)
        let action = null
        let id = null

        if (!form.checkValidity()){
            form.reportValidity()
            return false
        }

        action = URL.get("action")
        if (action === 'modify') {
            action = 'modification'
            id = URL.get('id')
        }

        let schedule = []
        for (let i = 0; i < 7; i++) {
            const open = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-open`).value
            const close = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-close`).value
            if (!document.querySelector(`#${DAY_OF_THE_WEEK[i]}-closed`).checked){
                schedule.push({
                    day: `${DAY_OF_THE_WEEK[i]}`,
                    open: `${open}`,
                    close: `${close}`
                })
            } else {
                schedule.push({
                    day: `${DAY_OF_THE_WEEK[i]}`,
                    open: `Ferme`,
                    close: `Ferme`
                })
            }
        }
        schedule = JSON.stringify(schedule)

        const response = await createOrModifySellPoint(form, schedule, action, id)
        if (response['success']){
            switch (action){
                case 'create':
                    handleDisplaySellPoint(map)
                    showToast(`Le sell point a été crée`, 'bg-success')
                    break
                case 'modification':
                    handleDisplaySellPoint(map)
                    showToast(`Le sell point a été modifier`, 'bg-success')
                    break
            }
        }
        if (response['errors']){
            showToast(response['errors'], 'bg-danger')
        }

    }


    export const handleAddress = (map, marker = null, infos = null) => {
        const searchBtn = document.querySelector('#search-address-btn')
        const URL = new URLSearchParams(window.location.search)
        searchBtn.addEventListener('click', async () => {
            const address = document.querySelector('#address').value
            const result = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURI(address)}`)
            if (result.ok){
                const data = await result.json()
                const addresses = []
                for (let i = 0; i < data.features.length; i++ ){
                    addresses.push(`<li class="list-group-item"><a href="#" data-address-id="${data.features[i].properties.id}">${data.features[i].properties.label}</a></li>`)
                }
                const modalMessage = `<div><ul class="list-group text-center mb-1">${addresses.join('')}</ul></div>`
                const modal = showModal('Liste des addresses trouves', modalMessage)
                const addressesLinkElement = document.querySelectorAll('.list-group-item a')
                for (let i = 0; i < addressesLinkElement.length; i++){
                    addressesLinkElement[i].addEventListener('click', (event) => {
                        const clickedAddressId = event.target.getAttribute('data-address-id')
                        const address = data.features.find(feature => feature.properties.id === clickedAddressId)
                        document.querySelector('#address').value = address.properties.label

                        const coordonates =
                            {
                                coordonate_x: address.geometry.coordinates[1],
                                coordonate_y: address.geometry.coordinates[0]
                            }
                        closeModal(modal)
                        marker !== null ? map.removeLayer(marker) : null
                        map = updateView(map, coordonates, 16)
                        marker = addMarker(map,coordonates)
                        if (URL.get('action') === 'modify'){
                            addPopUp(marker, infos['infos'][0])
                        }

                    })
                }
            }

        })
    }
    export const handleSchedule = () => {
        for (let i = 0; i < 7; i++){
            const btnClosedElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-closed`)
            const openElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-open`)
            const closeElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-close`)
            btnClosedElement.addEventListener('click', () => {
                if (btnClosedElement.checked){
                    openElement.required = false
                    openElement.disabled = true
                    openElement.value = ""
                    closeElement.required = false
                    closeElement.disabled = true
                    closeElement.value = ""
                    btnClosedElement.required = true
                } else {
                    openElement.required = true
                    openElement.disabled = false
                    closeElement.required = true
                    closeElement.disabled = false
                    btnClosedElement.required = false
                }
            })
        }
    }

    export const displaySellPoint = (form, info) => {
        const schedule = JSON.parse(info['schedule'])
        const img = document.querySelector('#display-img')
        const groupSelection = document.querySelector(` option[value="${info['id_group']}"]`)
        const modifyBtnElement = document.querySelector('#send-btn')

        groupSelection.selected = true
        for (let i = 0; i < 7; i++){
            const openElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-open`)
            const closeElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-close`)
            const btnClosedElement = document.querySelector(`#${DAY_OF_THE_WEEK[i]}-closed`)


            if (schedule[i]['open'] === "Ferme" && schedule[i]['close'] === "Ferme"){
                openElement.required = false
                openElement.disabled = true
                closeElement.required = false
                closeElement.disabled = true
                btnClosedElement.checked = true
                btnClosedElement.required = true
            } else {
                openElement.value = schedule[i]['open']
                closeElement.value = schedule[i]['close']
            }
        }

        modifyBtnElement.innerHTML = 'Modifier'
        form.elements['name'].value = info['name']
        form.elements['siren'].value = info['siret']
        form.elements['first_name'].value = info['first_name_director']
        form.elements['last_name'].value = info['last_name_director']
        form.elements['address'].value = info['label']
        form.elements['image'].required = false

        img.classList.remove('d-none')
        img.src = UPLOADPATH + info['image']

    }

    export const handleGroupName = async () => {
        const res = await getGroupName()
        const groupNameElement = document.querySelector('#group_name')
        let createOption = document.createElement('option')
        createOption.textContent = 'Aucun'
        createOption.value = "null"
        groupNameElement.appendChild(createOption)

        for (let i = 0; i < res['infos'].length; i++){
            createOption = document.createElement('option')
            createOption.textContent = `${res['infos'][i]['group_name']}`
            createOption.value = `${res['infos'][i]['id']}`
            groupNameElement.appendChild(createOption)
        }
    }