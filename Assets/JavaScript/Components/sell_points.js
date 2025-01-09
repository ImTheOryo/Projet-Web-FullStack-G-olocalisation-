    import {getAllInfosSP} from "../Services/sell_points.js";
    import {showToast} from "./Shared/toast.js";

    export const handleSellPoints = async (component) => {
        const getAllInfosSellPoints = await getAllInfosSP(component)
        if (getAllInfosSellPoints['errors'] === true){
            showToast(getAllInfosSellPoints['message'],'bg-danger')
        } else {
           return getAllInfosSellPoints
        }

    }

    export const displaySellPoints = async (component, spinner, tbody, page, limit, sortBy = null) => {
        spinner.classList.remove('d-none')
        const data = await getAllInfosSP(component, page, limit, sortBy)
        const componentAction = component.slice(0, component.length -1)
        tbody.innerHTML = ""
        for (let i = 0; i < data['infos'].length; i++){
            tbody.innerHTML += `<tr>
              <th>${data['infos'][i]['id']}</th>
              <td>${data['infos'][i]['name']}</td>
              <td>${data['infos'][i]['group_name']}</td>
              <td>${data['infos'][i]['first_name_director']} ${data['infos'][i]['last_name_director']}</td>
              <td>
                    <a href="index.php?component=${componentAction}&action=modify&id=${data['infos'][i]['id']}" class="me-3"><i class="fa-solid fa-user-pen"></i></a>
                    <a href="index.php?component=${componentAction}&action=delete&id=${data['infos'][i]['id']}"><i class="fa-solid fa-trash-can" style="color: red"></i></a>
            </td>
            </tr>`
        }
        spinner.classList.add('d-none')
    }