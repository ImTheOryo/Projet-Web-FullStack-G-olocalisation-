<?php
/**
 * @var array $sellPointsInfos
 */
?>
    <h1 class="text-center">Liste des points de vente</h1>
    <div class="d-flex justify-content-center">
        <div class="spinner-grow text-warning d-none" id="spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-success " type="button" id="btn-create"><a href="index.php?component=sell_point&action=create" style="text-decoration: none; color: white">Create a Sell Point</a></button>
    </div>
    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col"><button type="button" class="btn" id="btn-id" data-sortby="id">ID</button></th>
                <th scope="col"><button type="button" class="btn" id="btn-name" data-sortby="name">Nom</button></th>
                <th scope="col"><button type="button" class="btn" id="btn-group-name" data-sortby="group_name">Groupe</button></th>
                <th scope="col"><button type="button" class="btn" id="btn-director" data-sortby="first_name_director">Directeur</button></th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
    <div id="footer-table" class="row">
        <button id="prev-page" type="button" class="col-1 btn ">|<</button>
        <p class="col-10 text-center" id="page-count">Hello</p>
        <button id="next-page" type="button" class="col-1 btn">>|</button>
    </div>
    <script src="./Assets/JavaScript/Components/sell_points.js" type="module"></script>
    <script type="module">
        import {handleDisplaySellPoints} from "./Assets/JavaScript/Components/sell_points.js"

        document.addEventListener('DOMContentLoaded', async () => {
          handleDisplaySellPoints()
        })
    </script>