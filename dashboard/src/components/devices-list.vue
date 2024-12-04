<template>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Device list</h1>
    <p class="mb-4">Your 5 registered buoys</p>

    <br>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Device list</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="devices" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Battery</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
import DataTable from 'datatables.net-dt';
import '../assets/css/datatables.css';
// import '../assets/js/datatables.js';

export default {
    name: "DevicesList",
    props: {},
    data() {
        return {
            devices: []
        }
    },
    computed: {},
    methods: {
        async getDevices() {
            let json = '{"status":"ok","data":[{"id":"56eac8ea-28a8-4c68-a6c0-a3437b60a4bb","name":"Bagnarolaz","info":"{\\"battery\\":0,\\"cpu\\":0,\\"memory\\":0,\\"temp\\":0}"},{"id":"e074385d-aa50-49d8-a59e-9dc02a203b91","name":"Swagbarca","info":"{\\"battery\\":0,\\"cpu\\":0,\\"memory\\":0,\\"temp\\":0}"}]}';
            
            // let res = await fetch('http://localhost:3000/get-devices', {
            //     method: 'GET',
            //     credentials: "same-origin"
            //     // headers: {
            //     //     'Content-Type': 'application/x-www-form-urlencoded'
            //     // },
            //     // body: new URLSearchParams({
            //     //     'userName': 'test@gmail.com',
            //     //     'password': 'Password!',
            //     //     'grant_type': 'password'
            //     // })
            // });

            // res = await res.json();
            let res = JSON.parse(json);

            let data = [];

            res.data.forEach((d, i) => {
                let info = JSON.parse(d.info);
                let battery = info.battery + "%";
                data.push([i+1, d.name, battery]);
            });

            if(res.status == "ok") {
                this.devices = data;
            } else {

            }
        }
    },
    mounted() {
        this.getDevices();
        
        new DataTable('#devices', {
            data: this.devices,
            responsive: true,
            paging: true
        });
    }
}
</script>

<style>
tbody tr:hover {
    background-color: rgba(128, 128, 128, 0.2) !important;
    cursor: pointer;
}
</style>