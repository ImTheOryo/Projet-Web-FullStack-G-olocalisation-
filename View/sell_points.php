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
        import {displaySellPoints} from "./Assets/JavaScript/Components/sell_points.js";
        import {getCount} from "./Assets/JavaScript/Services/sell_points.js";

        document.addEventListener('DOMContentLoaded', async () => {
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

        })
    </script>