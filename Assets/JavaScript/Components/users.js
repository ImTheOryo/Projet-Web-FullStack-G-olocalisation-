
    import {getAllInfos, getCount} from "../Services/sell_points.js";
    import {showToast} from "./Shared/toast.js";
    import {deleteUser} from "../Services/user.js";

    export const handleDisplayUsers = async () => {
        const spinner = document.querySelector('#spinner')
        const tbody = document.querySelector('#table tbody')
        const limit = 15
        const component = "users"
        const nextBtn = document.querySelector('#next-page')
        const prevBtn = document.querySelector('#prev-page')
        const pageCountElement = document.querySelector('#page-count')
        const sortByElements = document.querySelectorAll('#table thead tr th button')
        let maxPage = await getCount(component)
        let page = 1
        let sortBy
        maxPage = Math.ceil(maxPage['infos'][0]['usersCount'] / limit)

        displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)


        sortByElements.forEach(sortByElements => {
            sortByElements.addEventListener('click', async (event) => {
                sortBy = event.target.getAttribute('data-sortby')
                displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)
            })
        })

        nextBtn.addEventListener('click',async () => {
            if (page < maxPage){
                page ++
                displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage )
            }
        })

        prevBtn.addEventListener('click',async () => {
            if (page  > 1){
                page --
                displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)
            }
        })


    }

    export const displayUsers = async (component, spinner, tbody, page, limit, sortBy = null, pageCountElement, maxPage) => {
        spinner.classList.remove('d-none')
        const data = await getAllInfos(component, page, limit, sortBy)
        const componentAction = component.slice(0, component.length -1)
        tbody.innerHTML = ""
        for (let i = 0; i < data['infos'].length; i++){
            tbody.innerHTML += `<tr>
                  <th>${data['infos'][i]['id']}</th>
                  <td>${data['infos'][i]['username']}</td>
                  <td>${data['infos'][i]['mail']}</td>
                  <td>${data['infos'][i]['enabled'] === 1 ? '<i class="fa-solid fa-user-check" style="color: green"></i>' : '<i class="fa-solid fa-user-xmark" style="color: red"></i>'}</td>
                  <td>
                        <a href="index.php?component=${componentAction}&action=modify&id=${data['infos'][i]['id']}" class="me-3"><i class="fa-solid fa-user-pen"></i></a>
                        <button type="button" data-id="${data['infos'][i]['id']}" data-place="${i}" class="btn btn-delete" style="cursor: pointer;"><i class="fa-solid fa-trash-can" style="color: red;  pointer-events: none;"></i></button>
                </td>
                </tr>`
        }
        const deleteBtnElements = document.querySelectorAll('.btn-delete')
        deleteBtnElements.forEach(deleteBtnElement => {
            deleteBtnElement.addEventListener('click', async (event) => {
                const id = event.target.getAttribute('data-id')
                const place = event.target.getAttribute('data-place')

                if (window.confirm(`Voulez-vous vraiment supprimer ${data['infos'][place]['username']} ?`)){
                    const reset = await deleteUser(id)
                    if (reset['success']){
                        showToast('Le user a ete supprime', 'bg-success')
                        await displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)

                    } else {
                        showToast(`Une erreur est survenue : ${reset['errors']}`, 'bg-danger')
                        await displayUsers(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)
                    }
                }
            })
        })
        pageCountElement.innerHTML = ""
        pageCountElement.innerHTML = `${page}/${maxPage}`
        spinner.classList.add('d-none')
    }