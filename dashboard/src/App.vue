<template>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <img src="./assets/img/logo-h-w.svg" class="nav-logo">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li :class="['nav-item mt-2 mb-4', page == 'home' ? 'active' : '']">
                <a class="nav-link" @click="page = 'home'">
                    <i class="fa-solid fa-house"></i>
                    <span>Home</span>
                </a>
            </li>

            <!-- Heading -->
            <div class="sidebar-heading">
                Devices
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li :class="['nav-item', page == 'devices-list' ? 'active' : '']">
                <a class="nav-link collapsed" @click="page = 'devices-list'">
                    <i class="fa-solid fa-list"></i>
                    <span>Device list</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li :class="['nav-item', page == 'new-device' ? 'active' : '']">
                <a class="nav-link collapsed" @click="page = 'new-device'">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add device</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
            <i class="fa fa-x"></i>
        </button>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline text-gray-600 small">{{ user.name }}</span>
                                <div class="img-profile rounded-circle bg-gradient-primary">
                                    DN
                                </div>
                            </a>
                            
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout" data-toggle="modal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <DevicesList v-if="page == 'devices-list'" />
                    <Home v-if="page == 'home'" />
                    <NewDevice v-if="page == 'new-device'" />
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>An Enactus Uniud project. This website does not use tracking cookies.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
import './assets/js/bootstrap.js';
import './assets/js/fontawesome.js';
import './assets/js/admin.js';
import './assets/css/fontawesome.css';
import Home from './components/home.vue';
import DevicesList from './components/devices-list.vue';
import NewDevice from './components/new-device.vue';

export default {
    name: "App",
    props: {},
    data() {
        return {
            page: 'home',
            user: {
                name: '',
                initals: ''
            }
        }
    },
    components: {
        Home,
        DevicesList,
        NewDevice
    },
    computed: {},
    methods: {
        
    },
    mounted() {
        let dropdowns = document.querySelectorAll('.dropdown-toggle');
        
        dropdowns.forEach(dd => {
            dd.addEventListener('click', () => {
                let menu = document.querySelector('.' + dd.id);
                if (menu) {
                    menu.classList.toggle('show');
                }
            });
        });

        document.body.addEventListener('click', (e) => {
            dropdowns.forEach(dd => {
                if(e.target != dd && !dd.contains(e.target)) {
                    let menu = document.querySelector('.' + dd.id);
                    menu.classList.remove('show');
                }
            });
        });

        let hamburger = document.querySelector('#sidebarToggleTop');

        hamburger.addEventListener('click', () => {
            document.querySelector('#wrapper > .navbar-nav').classList.toggle('show');
            hamburger.classList.toggle('show');
        });
    }
}
</script>

<style scoped>
</style>