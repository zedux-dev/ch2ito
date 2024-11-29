<?php
require 'internal/auth.php';
require 'internal/devices.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pts = explode(" ", $currentuser["displayname"]);

if (count($pts) >= 2) {
    $initials = strtoupper(substr($pts[0], 0, 1) . substr($pts[1], 0, 1));
} else {
    $initials = strtoupper(substr($currentuser["displayname"], 0, 2));
}


$devices_data = getDevices();
$devices_json_data = json_encode($devices_data);
echo $devices_json_data;
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

</head>

<body>
    <div class="main-layout">
        <?php require 'navbar.php'; ?>

        <div class="inner-content">
            <div class="openable-menu sidemenu">
                <div id="home" class="menu-item current" onclick="setTab('home')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                    </svg>
                    Home
                </div>

                <div id="devices" class="menu-item" onclick="setTab('devices')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M176 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40c-35.3 0-64 28.7-64 64l-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0 0 56-40 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l40 0c0 35.3 28.7 64 64 64l0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40 56 0 0 40c0 13.3 10.7 24 24 24s24-10.7 24-24l0-40c35.3 0 64-28.7 64-64l40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0 0-56 40 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0c0-35.3-28.7-64-64-64l0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40-56 0 0-40zM160 128l192 0c17.7 0 32 14.3 32 32l0 192c0 17.7-14.3 32-32 32l-192 0c-17.7 0-32-14.3-32-32l0-192c0-17.7 14.3-32 32-32zm192 32l-192 0 0 192 192 0 0-192z" />
                    </svg>
                    Devices
                </div>

                <div id="records" class="menu-item" onclick="setTab('records')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z" />
                    </svg>
                    Records
                </div>
            </div>

            <div class="content">
                <div id="home-tab" class="home-part page-content ">
                    <h1>Welcome, <?php echo $currentuser["displayname"]; ?></h1>
                </div>

                <div id="devices-tab" class="devices-part page-content show">
                    <h1>Devices</h1>
                    <p>There is a total of 0 devices registered</p>

                    <br>

                    <div id="devices-table"></div>
                </div>

                <div id="settings-tab" class="settings-part page-content">
                    <h1>Settings</h1>

                    <div style="height: 25px;"></div>

                    <div class="field-wrapper">
                        <label>Display name</label>
                        <input id="displayname-edit" type="text" value="<?php echo $currentuser["displayname"]; ?>">
                    </div>

                    <div style="height: 10px;"></div>

                    <div class="field-wrapper">
                        <label>Username</label>
                        <input id="username-edit" type="text" value="<?php echo $currentuser["username"]; ?>">
                    </div>

                    <div style="height: 10px;"></div>

                    <div class="field-wrapper">
                        <label>Password</label>
                        <input id="password-edit" type="password" placeholder="••••••••">
                    </div>

                    <div style="height: 25px;"></div>

                    <button class="btn-submit" onclick="saveEditUser();">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.14.5/sweetalert2.min.js"></script>

    <script>
        let devices_json_data = '<?php echo $devices_json_data; ?>';

        new gridjs.Grid({
            columns: ["#", "Name", "Sensors", "Battery"],
            data: JSON.parse(devices_json_data),
        }).render(document.getElementById("devices-table"));

        setTimeout(() => {
            let rows = document.querySelectorAll('.gridjs-tr');
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    let id = row.querySelector('.gridjs-td[data-column-id="#"]').innerHTML;
                    window.location.href = "/panel/device.php?id=" + id;
                });
            });
        }, 500);

        function setTab(name) {
            let tabs = document.querySelectorAll('.menu-item');
            let tabcontents = document.querySelectorAll('.page-content');
            let tab = document.querySelector('#' + name);
            let tabcontent = document.querySelector('#' + name + '-tab');

            if (tabs != undefined) tabs.forEach(t => {
                t.classList.remove('current');
            });
            if (tabcontents != undefined) tabcontents.forEach(tc => {
                tc.classList.remove('show');
            });

            if (tab != undefined) tab.classList.add('current');
            if (tabcontent != undefined) tabcontent.classList.add('show');

            closePPMenu();
        }

        function logout() {
            document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
            document.cookie = "token_expires=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
            window.location.href = "/panel/login.php";
        }

        function saveEditUser() {
            let username = document.querySelector('#username-edit').value;
            let password = document.querySelector('#password-edit').value;
            let displayname = document.querySelector('#displayname-edit').value;

            if (username == "" || displayname == "") {
                Swal.fire({
                    title: "Fields cannot be empty",
                    text: "Please ensure that all fields are filled in",
                    icon: "error",
                    confirmButtonColor: '#56b3ff'
                });

                return;
            }

            Swal.fire({
                title: "Confirm saving",
                showCancelButton: true,
                confirmButtonText: 'Save',
                confirmButtonColor: '#56b3ff',
                text: "You will be signed out",
                icon: "question"
            }).then(async r => {
                if (r.isConfirmed) {
                    const body = new FormData();
                    body.set("username", username);
                    body.set("displayname", displayname);
                    body.set("password", password);

                    let token = getCookie('token');
                    let token_expires = getCookie('token_expires');

                    let res = await fetch('/ch-api/index.php?cmd=edit-user', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'token_expires': token_expires
                        },
                        body
                    });

                    let rr = await res.text();

                    logout();
                }
            })
        }


        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
</body>

</html>