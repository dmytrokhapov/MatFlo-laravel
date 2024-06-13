<x-public-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #f9f9f9;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 50px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px 0;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #007BFF;
        }

        .btn {
            background-color: #000;
            color: #fff;
            padding: 8px 16px;
            border-radius: 15px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn:hover {
            background-color: #333;
        }

        .transparent-btn {
            background-color: rgba(255, 255, 255, 0.5);
            color: #000;
            border: 2px solid #000;
            border-radius: 15px;
            font-size: 14px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .transparent-btn:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: #333;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: nowrap;
        }

        .map-container {
            flex: 1 1 45%;
            padding: 20px;
        }

        .world-map {
            max-width: 100%;
            height: auto;
        }

        .table-container {
            flex: 1 1 55%;
            padding: 20px;
        }

        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .cta-section {
            text-align: center;
            padding: 50px 20px;
        }

        .cta-section h1 {
            margin-bottom: 30px;
        }

        .cta-buttons .btn {
            background-color: #000;
            color: #fff;
            padding: 8px 16px;
            border-radius: 15px;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .cta-buttons .btn:hover {
            background-color: #333;
        }

        footer {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        footer nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-top: 10px;
        }

        footer nav ul li {
            margin: 0 15px;
        }

        footer nav ul li a {
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
        }

        footer nav ul li a:hover {
            color: #007BFF;
        }

        .verified_info {
            color: green;
        }

        #map {
            top: 0;
            bottom: 0;
            width: 100%;
            height: 500px;
        }

        #marker {
            background-image: url('https://docs.mapbox.com/mapbox-gl-js/assets/washington-monument.jpg');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        #btn-spin {
            font: bold 12px/20px 'Helvetica Neue',
            Arial,
            Helvetica,
            sans-serif;
            background-color: #3386c0;
            color: #fff;
            position: absolute;
            top: 20px;
            left: 50%;
            z-index: 1;
            border: none;
            width: 200px;
            margin-left: -100px;
            display: block;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 3px;
            display: none;
        }

        #btn-spin:hover {
            background-color: #4ea0da;
        }

        @media (max-width: 1200px) {
            .main-content {
                /*flex-direction: column;*/
                flex-wrap: wrap;
            }

            .map-container, .table-container {
                flex: 1 1 100%;
                padding: 10px;
            }
        }

        header, footer {
            background-color: #f3f9ff!important;
        }

        .main-footer {
            margin-left: 0!important;
        }

    </style>
    <header>
        <div class="container">
            <div class="logo-container">
                <img src="{{asset('img/logo.png')}}" alt="MatFlo Logo" class="logo">
                <span class="logo-text">MatFlo</span>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('publish') }}">Products</a></li>
                    <li><a href="{{ route('apikey') }}">Developers</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                </ul>
            </nav>
            @if (Auth::check())
                <a href="{{ route("dashboard") }}" class="login-btn btn">Go to Dashboard</a>
            @else
                <a href="{{ route("login")}}" class="login-btn btn">Log in</a>
            @endif
        </div>
    </header>
    <main>
        <section class="main-content">
            <div class="map-container">
                <div id="map"></div>
                <button id="btn-spin">Pause rotation</button>
            </div>
            <div class="table-container">
                <input type="text" placeholder="Type your search" class="search-bar" id="searchInput">
                <table id="declarationTable">
                    <thead>
                    <tr>
                        <th>Document ID</th>
                        <th>Product Name</th>
                        <th>GWP</th>
                        <th>Location</th>
                        <th>Producer</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($declarations as $declaration)
                    <tr data-detail="{{ $declaration }}">
                        @if ($declaration->status === "Signed")
                            <td><a href='view-batch/{{$declaration->document_id}}' target='_blank'>{{ $declaration->document_id }}</a></td>
                        @else
                            <td><a href='view-publish/{{$declaration->document_id}}' target='_blank'>{{ $declaration->document_id }}</a></td>
                        @endif
                        <td>{{ $declaration->name }}</td>
                        <td>{{ $declaration->gwp }}</td>
                        <td>{{ $declaration->location }}</td>
                        <td>{{ $declaration->producer }}</td>
                        <td>{{ $declaration->published_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <section class="cta-section">
            <h1>Get your document certified and hosted on the blockchain.</h1>
            <div class="cta-buttons">
                <a href="#get-started" class="btn">Get Started</a>
                <a href="#learn-more" class="btn">Learn More</a>
            </div>
        </section>
    </main>

    <script>
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        mapboxgl.accessToken = 'pk.eyJ1IjoibW9oaXRkb3llbjEiLCJhIjoiY2xqd2tmbzZrMGJjbTNkbnZmcXVjcjcxeSJ9.KyeOVUuO1zBUNT55Bh4QFQ';
        const monument = [-97.0353, 38.8895];
        const map = new mapboxgl.Map({
            container: 'map',
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            style: 'mapbox://styles/mapbox/navigation-day-v1',
            projection: 'globe',
            center: monument,
            zoom: 1.2,
        });

        // create the popup
        const popup = new mapboxgl.Popup({offset: 25}).setText(
            'Construction on the Washington Monument began in 1848.'
        );

        // create DOM element for the marker
        const el = document.createElement('div');
        el.id = 'marker';

        var res, features = [], promises = [];

        function showResult(str) {
            // if (str.length==0) {
            //     document.getElementById("livesearch").innerHTML="";
            //     document.getElementById("livesearch").style.border="0px";
            //     return;
            // }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    res = JSON.parse(this.responseText);

                    for (rs of res) {
                        if (rs.location != null) {
                            let promise = fetch('https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(rs.location) + '&format=json&addressdetails=1&polygon_geojson=0&countrycodes=US')
                                .then(response => response.json())
                                .then(data => {
                                    console.log(encodeURIComponent(rs.location), data)
                                    if (data.length > 0) {
                                        // create the marker
                                        features.push({
                                            // feature for Mapbox DC
                                            'type': 'Feature',
                                            'geometry': {
                                                'type': 'Point',
                                                'coordinates': [data[0].lon, data[0].lat]
                                            },
                                            'properties': {
                                                'description':
                                                    '<strong>' + rs.name + '</strong>'
                                            },
                                        })
                                    }

                                })
                                .catch(err => console.error(err));

                            promises.push(promise)
                        }

                    }
                    Promise.all(promises)
                        .then(() => {
                            map.style.stylesheet.layers.forEach(function (layer) {
                                if (layer.type === 'symbol') {
                                    map.removeLayer(layer.id);
                                }
                            });

                            map.addSource('places', {
                                'type': 'geojson',
                                'data': {
                                    'type': 'FeatureCollection',
                                    'features': features
                                }
                            });
                            map.addLayer({
                                'id': 'places',
                                'type': 'circle',
                                'source': 'places',
                                'paint': {
                                    'circle-color': '#4264fb',
                                    'circle-radius': 6,
                                    'circle-stroke-width': 2,
                                    'circle-stroke-color': '#ffffff'
                                }
                            });

                        });

                    spinGlobe();
                    stopLoader();
                }
            }
            xmlhttp.open("GET", "/search?q=" + str, true);
            xmlhttp.send();
            startLoader();
        }

        function filterResult(event, str) {
            if (event.keyCode == 13) {
                showTable();
                return;
            }

            if (str.length == 0) {
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = "0px";
                document.getElementById("livesearch").style.paddingTop = "0";
                document.getElementById("livesearch").style.paddingLeft = "0";
                document.getElementById("livesearch").style.paddingRight = "0";
                document.getElementById("livesearch").style.paddingBottom = "0";
                $("#tbody").html('No Data Available');
                $("#resTable").hide();
                return;
            }
            var innerHtml = '';
            var tblHtml = '';

            for (doc of res) {
                var link;
                if (doc.status == 'Signed') {
                    link = 'view-batch/' + doc.document_id;
                } else {
                    link = 'view-publish/' + doc.document_id;
                }
                console.log(doc)
                if (doc.name.toUpperCase().includes(str.toUpperCase()) || doc.document_id.toUpperCase().includes(str.toUpperCase())) {
                    innerHtml += "<div style='margin-bottom: 5px;'><a href='" + link + "' target='_blank'>" + doc.name + "</a></div>";
                    if (doc.status == 'Signed') {
                        tblHtml += "<tr><td><a href='view-batch/" + doc.document_id + "' target='_blank'>" + doc.document_id + "</a></td><td>" + doc.name + "</td><td>" + (doc.location ?? '') + "</td><td>" + (new Date(doc.created_at).toDateString()) + "</td><td>" + doc.producer.user_name + "</td><td>" + doc.verifier.user_name + "</td><td>" + (new Date(doc.verified_at).toDateString()) + "</td></tr>";
                    } else {
                        tblHtml += "<tr><td><a href='view-publish/" + doc.document_id + "' target='_blank'>" + doc.document_id + "</a></td><td>" + doc.name + "</td><td>" + (doc.location ?? '') + "</td><td>" + (new Date(doc.created_at).toDateString()) + "</td><td>" + doc.producer + "</td><td>" + doc.verifier + "</td><td>" + (new Date(doc.published_at).toDateString()) + "</td></tr>";
                    }

                }

            }


            if (innerHtml === '') {
                innerHtml = "No suggestions";
                $("#tbody").html("No Data Available");
            }
            $("#tbody").html(tblHtml);
            document.getElementById("livesearch").style.paddingTop = "15px";
            document.getElementById("livesearch").style.paddingLeft = "15px";
            document.getElementById("livesearch").style.paddingRight = "15px";
            document.getElementById("livesearch").style.paddingBottom = "10px";

            document.getElementById("livesearch").innerHTML = innerHtml;
            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";

        }

        function hideDropDown() {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            document.getElementById("livesearch").style.paddingTop = "0";
            document.getElementById("livesearch").style.paddingLeft = "0";
            document.getElementById("livesearch").style.paddingRight = "0";
            document.getElementById("livesearch").style.paddingBottom = "0";
        }

        function showTable() {
            $("#resTable").show();
            hideDropDown();
        }

        showResult('');

        // At low zooms, complete a revolution every two minutes.
        const secondsPerRevolution = 120;
        // Above zoom level 5, do not rotate.
        const maxSpinZoom = 5;
        // Rotate at intermediate speeds between zoom levels 3 and 5.
        const slowSpinZoom = 3;

        let userInteracting = false;
        let spinEnabled = true;

        function spinGlobe() {
            const zoom = map.getZoom();
            if (spinEnabled && !userInteracting && zoom < maxSpinZoom) {
                let distancePerSecond = 360 / secondsPerRevolution;
                if (zoom > slowSpinZoom) {
                    // Slow spinning at higher zooms
                    const zoomDif =
                        (maxSpinZoom - zoom) / (maxSpinZoom - slowSpinZoom);
                    distancePerSecond *= zoomDif;
                }
                const center = map.getCenter();
                center.lng -= distancePerSecond;
                // Smoothly animate the map over one second.
                // When this animation is complete, it calls a 'moveend' event.
                map.easeTo({center, duration: 1000, easing: (n) => n});
            }
        }

        // Pause spinning on interaction
        map.on('mousedown', () => {
            userInteracting = true;
        });

        // Restart spinning the globe when interaction is complete
        map.on('mouseup', () => {
            userInteracting = false;
            spinGlobe();
        });

        // These events account for cases where the mouse has moved
        // off the map, so 'mouseup' will not be fired.
        map.on('dragend', () => {
            userInteracting = false;
            spinGlobe();
        });
        map.on('pitchend', () => {
            userInteracting = false;
            spinGlobe();
        });
        map.on('rotateend', () => {
            userInteracting = false;
            spinGlobe();
        });

        // When animation is complete, start spinning if there is no ongoing interaction
        map.on('moveend', () => {
            spinGlobe();
        });

        document.getElementById('btn-spin').addEventListener('click', (e) => {
            spinEnabled = !spinEnabled;
            if (spinEnabled) {
                spinGlobe();
                e.target.innerHTML = 'Pause rotation';
            } else {
                map.stop(); // Immediately end ongoing animation
                e.target.innerHTML = 'Start rotation';
            }
        });

        $(document).ready(function(){
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#declarationTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

    </script>
</x-public-layout>
