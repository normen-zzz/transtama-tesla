<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <!-- show map leaflet  -->
                <div class="col-md-12">
                    <div class="card card-flush h-md-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Vehicle</span>
                                <span class="text-muted mt-1 fw-bold fs-7">List Vehicle</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div id="map" style="height: 500px;"></div>
                        </div>
                    </div>


                </div>
                <!--end::Row-->

                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->


    <script>
        var map = L.map('map').setView([-6.2088, 106.8456], 10);
        // show layer in jakarta 
        var layer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            attribution: 'Transtama Logistics | © Google Maps',
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);



        // Change marker icon with car icon
        var carIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/744/744465.png',
            iconSize: [50, 50],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });


        var locations = <?= $listVehicle ?>;

        for (var i = 0; i < locations.length; i++) {
            marker = new L.marker([locations[i]['Latitude'], locations[i]['Longitude']])
                .bindPopup(`
                    <table class="table table-sm">
                        <tr><td><strong>No. Polisi:</strong></td><td>${locations[i]['Nopol']}</td></tr>
                        <tr><td><strong>Status:</strong></td><td>${locations[i]['Status'] ? 'Online' : 'Offline'}</td></tr>
                        <tr><td><strong>Latitude:</strong></td><td>${locations[i]['Latitude']}</td></tr>
                        <tr><td><strong>Longitude:</strong></td><td>${locations[i]['Longitude']}</td></tr>
                    </table>
                    <div class="text-center mt-2">
                        <a href="https://maps.google.com/?q=${locations[i]['Latitude']},${locations[i]['Longitude']}&query_place_id=${locations[i]['Nopol']}" target="_blank" class="btn btn-danger btn-sm">
                            Open with Google Maps
                        </a>
                    </div>
                `)
                .addTo(map)
                .openPopup();
            marker.setIcon(carIcon);
            // Add marker to map



        }
    </script>