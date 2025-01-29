
    <h1 class="text-center">Liste des utilisateurs</h1>
    <div class="d-flex justify-content-center">
        <div class="spinner-grow text-warning d-none" id="spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-success " type="button" id="btn-create"><a href="index.php?component=user&action=create" style="text-decoration: none; color: white">Create a new User</a></button>
    </div>
    <table class="table" id="table">
        <thead>
        <tr>
            <th scope="col"><button type="button" class="btn" id="btn-id" data-sortby="id">ID</button></th>
            <th scope="col"><button type="button" class="btn" id="btn-name" data-sortby="username">Username</button></th>
            <th scope="col"><button type="button" class="btn" id="btn-group-name" data-sortby="enabled">Mail</button></th>
            <th scope="col"><button type="button" class="btn" id="btn-group-name" data-sortby="enabled">Actif</button></th>
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
    <script  src="./Assets/JavaScript/Components/users.js" type="module"></script>
    <script type="module">

        import {handleDisplayUsers} from "./Assets/JavaScript/Components/users.js";

        document.addEventListener('DOMContentLoaded', async () => {
            handleDisplayUsers()
        })
    </script>