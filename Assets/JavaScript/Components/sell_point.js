import {showToast} from "./Shared/toast.js";
import {getInfo} from "../Services/sell_point.js";

    export const handleSellPoint = async (component, action = null, id = null) => {
            let info
            if (action === 'modify'){
                 info = await getInfo(component, action, id)
            }
            if (info['errors']){
                showToast(info['message'], 'bg-danger')
            } else {
                return info
            }
        }

    export const displaySellPoint = (form, info) => {
        form.innerHTML = ""
        const schedule = JSON.parse(info['schedule'])
        form.innerHTML = `
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du sell point * </label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" value="${info['name']}">
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="group_name" class="form-label">Appartenant au groupe</label>
                    <input type="text" class="form-control" id="group_name" aria-describedby="group_name" value="${info['group_name']}">
                </div>
            </div>
            <div class="col-1 text-center">
                <button class="btn btn-success" type="button">Add</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <div class="mb-3">
                    <label for="address" class="form-label">Siret / Siren *</label>
                    <input type="text" class="form-control" id="address" aria-describedby="address" value="${info['siret']}">
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center">Horaire</h3>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <div class="accordion" id="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                               Lundi
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                               <div class="d-flex justify-content-around">
                                   <div>
                                       <label for="mon_open">Ouverture :</label>
                                       <input type="time" value="${schedule[0]['open']}">
                                   </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                Mardi
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                Mercredi
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                Jeudi
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                Vendredi
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                                Samedi
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                Dimanche
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse hide" data-bs-parent="#accordionExample">
                            <div class="accordion-body" >
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="mon_open">Ouverture :</label>
                                        <input type="time">
                                    </div>

                                    <div>
                                        <label for="mon_open">Fermeture :</label>
                                        <input type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center">Directeur</h3>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="first_name" class="form-label">Prenom *</label>
                    <input type="text" class="form-control" id="first_name" aria-describedby="first_name" value="${info['first_name_director']}">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="last_name" class="form-label">Nom de famille *</label>
                    <input type="text" class="form-control" id="last_name" aria-describedby="last_name" value="${info['last_name_director']}">
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center mt-3">Adresse</h3>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="mb-3">
                    <input type="text" class="form-control" id="address" aria-describedby="address" value="${info['label']}">
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-primary">Search</button>
            </div>
        </div>
        <div class="row">
            <div id="map" class="mb-5" style="width: 100%; height: 500px"></div>
        </div>
        `
    }