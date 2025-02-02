    import {getAllInfos, getCount} from "../Services/sell_points.js";
    import {showToast} from "./Shared/toast.js";
    import {deleteSellPoint} from "../Services/sell_point.js";

    export const handleSellPoints = async (component) => {
        const getAllInfosSellPoints = await getAllInfos(component)
        if (getAllInfosSellPoints['errors']){
            showToast(getAllInfosSellPoints['message'],'bg-danger')
        } else {
           return getAllInfosSellPoints
        }

    }

    export const handleDisplaySellPoints = async () => {
        const spinner = document.querySelector('#spinner')
        const tbody = document.querySelector('#table tbody')
        const limit = 15
        const component = "sell_points"
        const nextBtn = document.querySelector('#next-page')
        const prevBtn = document.querySelector('#prev-page')
        const pageCountElement = document.querySelector('#page-count')
        const sortByElements = document.querySelectorAll('#table thead tr th button')
        let maxPage = await getCount(component)
        let page = 1
        let sortBy
        maxPage = Math.ceil(maxPage['infos'][0]['sellPointsCount'] / limit)

        displaySellPoints(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)


        sortByElements.forEach(sortByElements => {
            sortByElements.addEventListener('click', async (event) => {
                sortBy = event.target.getAttribute('data-sortby')
                displaySellPoints(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)
            })
        })

        nextBtn.addEventListener('click',async () => {
            if (page < maxPage){
                page ++
                displaySellPoints(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage )
            }
        })

        prevBtn.addEventListener('click',async () => {
            if (page  > 1){
                page --
                displaySellPoints(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)
            }
        })


    }

    export const displaySellPoints = async (component, spinner, tbody, page, limit, sortBy = null, pageCountElement, maxPage) => {
        spinner.classList.remove('d-none')
        const data = await getAllInfos(component, page, limit, sortBy)
        const componentAction = component.slice(0, component.length -1)
        tbody.innerHTML = ""
        for (let i = 0; i < data['infos'].length; i++){
            tbody.innerHTML += `<tr>
              <th>${data['infos'][i]['id']}</th>
              <td>${data['infos'][i]['name']}</td>
              <td>${data['infos'][i]['group_name'] === null ? 'Aucun' : data['infos'][i]['group_name']}</td>
              <td>${data['infos'][i]['first_name_director']} ${data['infos'][i]['last_name_director']}</td>
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

                if (window.confirm(`Voulez-vous vraiment supprimer ${data['infos'][place]['name']} ?`)){
                    const reset = await deleteSellPoint(id)
                    if (reset['success']){
                        showToast('Le sell point a ete supprime', 'bg-success')
                        await displaySellPoints(component, spinner, tbody, page, limit, sortBy, pageCountElement, maxPage)

                    } else {
                        showToast(`Une erreur est survenue : ${reset['errors']}`, 'bg-danger')
                    }
                }
            })
        })
        pageCountElement.innerHTML = ""
        pageCountElement.innerHTML = `${page}/${maxPage}`
        spinner.classList.add('d-none')
    }