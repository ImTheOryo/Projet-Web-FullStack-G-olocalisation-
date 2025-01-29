
    <h1 class="text-center">Informations</h1>
    <form class="mt-3" id="formSellPoint" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du sell point * </label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="" required>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="group_name" class="form-label">Appartenant au groupe</label>
                    <select class="form-select" name="group_name" id="group_name">

                    </select>
                </div>

            </div>

        </div>
        <div class="row mt-3">
            <div class="col-4">
                <div class="mb-3">
                    <label for="siren" class="form-label">Siret / Siren *</label>
                    <input type="text" class="form-control" id="siren"  name="siren" aria-describedby="address" required>
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center">Devanture</h3>
            <div class="col-11">
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="col-1">
                <button class="btn btn-danger" type="button" id="delete-img">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>
            <div class="col-11 d-flex justify-content-center">
                <img src="" style="max-height: 500px; max-width: 500px" id="display-img" alt="devanture" class="d-none">
            </div>

        </div>
        <div class="row">
            <h3 class="text-center">Horaire</h3>
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
                                       <label for="mon-open">Ouverture :</label>
                                       <input type="time" id="mon-open" name="mon-open" required>
                                   </div>

                                    <div>
                                        <label for="mon-close">Fermeture :</label>
                                        <input type="time" id="mon-close" name="mon-close" required>
                                    </div>

                                   <div>
                                       <label for="mon-closed">Ferme</label>
                                       <input type="checkbox" id="mon-closed" name="mon-closed">
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
                                        <label for="tue-open">Ouverture :</label>
                                        <input type="time" id="tue-open" name="tue-open" required>
                                    </div>

                                    <div>
                                        <label for="tue-close">Fermeture :</label>
                                        <input type="time" id="tue-close" name="tue-close" required>
                                    </div>

                                    <div>
                                        <label for="tue-closed">Ferme</label>
                                        <input type="checkbox" id="tue-closed" name="tue-closed">
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
                                        <label for="wen-open">Ouverture :</label>
                                        <input type="time" id="wen-open" name="wen-open" required>
                                    </div>

                                    <div>
                                        <label for="wen-close">Fermeture :</label>
                                        <input type="time" id="wen-close" name="wen-close" required>
                                    </div>

                                    <div>
                                        <label for="wen-closed">Ferme</label>
                                        <input type="checkbox" id="wen-closed" name="wen-closed">
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
                                        <label for="thu-open">Ouverture :</label>
                                        <input type="time" id="thu-open" name="thu-open" required>
                                    </div>

                                    <div>
                                        <label for="thu-close">Fermeture :</label>
                                        <input type="time" id="thu-close" name="thu-close" required>
                                    </div>

                                    <div>
                                        <label for="thu-closed">Ferme</label>
                                        <input type="checkbox" id="thu-closed" name="thu-closed">
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
                            <div class="accordion-body">
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <label for="fry-open">Ouverture :</label>
                                        <input type="time" id="fry-open" name="fry-open" required>
                                    </div>

                                    <div>
                                        <label for="fry-close">Fermeture :</label>
                                        <input type="time" id="fry-close" name="fry-close" required>
                                    </div>

                                    <div>
                                        <label for="fry-closed">Ferme</label>
                                        <input type="checkbox" id="fry-closed" name="fry-closed">
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
                                        <label for="sat-open">Ouverture :</label>
                                        <input type="time" id="sat-open" name="sat-open" required>
                                    </div>

                                    <div>
                                        <label for="sat-close">Fermeture :</label>
                                        <input type="time" id="sat-close" name="sat-close" required>
                                    </div>

                                    <div>
                                        <label for="sat-closed">Ferme</label>
                                        <input type="checkbox" id="sat-closed" name="sat-closed">
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
                                        <label for="sun-open">Ouverture :</label>
                                        <input type="time" id="sun-open" name="sun-open" required>
                                    </div>

                                    <div>
                                        <label for="sun-close">Fermeture :</label>
                                        <input type="time" id="sun-close" name="sun-close" required>
                                    </div>

                                    <div>
                                        <label for="sun-closed">Ferme</label>
                                        <input type="checkbox" id="sun-closed" name="sun-closed">
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
                    <input type="text" class="form-control" id="first_name" name="first-name" aria-describedby="first_name">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="last_name" class="form-label">Nom de famille *</label>
                    <input type="text" class="form-control" id="last_name" name="last-name" aria-describedby="last_name">
                </div>
            </div>
        </div>
        <div class="row">
            <h3 class="text-center mt-3">Adresse</h3>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="mb-3">
                    <input type="text" class="form-control" id="address" name="address" aria-describedby="address">
                </div>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-primary" id="search-address-btn">Search</button>
            </div>
        </div>
        <div class="row">
            <div id="map" class="mb-5" style="width: 100%; height: 500px"></div>
        </div>
        <div class="mb-2 d-flex justify-content-evenly">
            <button type="button" id="cancel" class="btn btn-danger">Annuler</button>
            <button type="button" id="send-btn" class="btn btn-success">Créer</button>
        </div>
    </form>

    <script src="./Assets/JavaScript/Components/Shared/map.js" type="module"></script>
    <script type="module">
        import {handleDisplaySellPoint} from "./Assets/JavaScript/Components/sell_point.js";
        import {showMap} from "./Assets/JavaScript/Components/Shared/map.js";

        document.addEventListener('DOMContentLoaded', async () => {
            const map = showMap(null, null, 6)
            handleDisplaySellPoint(map)
        })
    </script>