
    <h1 class="text-center">Informations</h1>

    <form id="userForm">
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="mail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="name@example.com" required>
                </div>
                <div class="col-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="col-6">
                    <label for="password-confirm" class="form-label">Confirmation Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" required>
                </div>
            </div>
        </div>
        <div>
            <input class="form-check-input" type="checkbox" value="true" id="enabled" name="enabled" checked>
            <label class="form-check-label" for="enabled">
                Enabled
            </label>
        </div>
        <div class="mb-2 d-flex justify-content-evenly">
            <button type="button" id="cancel" class="btn btn-danger">Annuler</button>
            <button type="button" id="send-btn" class="btn btn-success">Créer</button>
        </div>
    </form>

    <script type="module">
        import {handleUser} from "./Assets/JavaScript/Components/user.js";

        handleUser()
    </script>