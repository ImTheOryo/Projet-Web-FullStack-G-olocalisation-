    <form class="mt-5" id="user-form">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="button" class="btn btn-primary" name="log-in-button" id="log-in-button">Log In</button>
    </form>
    <script src="./Assets/JavaScript/Services/user.js" type="module"></script>
    <script type="module">

        import {handleUser} from "./Assets/JavaScript/Components/user.js";

        document.addEventListener("DOMContentLoaded", () => {
            handleUser()
        })
    </script>