<?php
    if(isset($_COOKIE["token"])) {
        header('Location: /panel/dashboard.php');
        exit;
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="main-content">
        <div class="big-wrapper">
            <div class="login-form">
                <h3>Data dashboard</h3>

                <div class="field-wrapper">
                    <label>Username</label>
                    <input id="username" type="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                </div>

                <div style="height: 10px;"></div>

                <div class="field-wrapper">
                    <label>Password</label>
                    <input id="password" type="password">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>
                </div>

                <div style="height: 25px;"></div>

                <button class="btn-submit" onclick="login();">Login</button>
            </div>

            <div class="img-side">
                <img src="assets/img/logo-w.svg" alt="Chito logo">
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.min.js"></script>
    <script>
        async function login() {
            let username = document.querySelector("#username").value;
            let password = document.querySelector("#password").value;

            if(username == "" || password == "") {
                return;
            }

            const body = new FormData();
            body.set("username", username);
            body.set("password", password);

            let res = await fetch('/ch-auth/index.php?cmd=login', {
                method: 'POST',
                body
            });

            res = await res.json();

            if(res.status == "error" && res.code == "wrongcredentials") {
                Swal.fire({
                    title: "Wrong credentials",
                    text: "Please check and try again",
                    icon: "error",
                    confirmButtonColor: '#56b3ff'
                });
            }

            if(res.status == "success") {
                const today = new Date();
                today.setUTCDate(today.getUTCDate() + 1);
                const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'UTC', timeZoneName: 'short' };
                const formattedDate = today.toLocaleString('en-US', options).replace('GMT', 'UTC');

                document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "token_expires=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                document.cookie = "token=" + res.token + "; expiration=" + res.expire + ";";
                document.cookie = "token_expires=" + res.expire + ";";

                let rr = await fetch('/ch-api/index.php?cmd=get-user', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + res.token,
                        'token_expires': res.expire
                    }
                });

                rr = await rr.json();

                window.location.href = "/panel/dashboard.php"
            }
        }
    </script>
</body>
</html>