<x-public-layout>

    <style type="text/css">
        .verified_info{
            color: green;
        }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; height: 500px; }
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
            font:
                bold 12px/20px 'Helvetica Neue',
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

    </style>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="bg-title workflow-card-header" style="padding-top: 20px">
                <h3 class="page-title">Matflo Explorer</h3>
                <br />
                <h5>Explore your documents!</h5>
                <p>
                    Check your document's detail. Enter the document ID number or name.
                </p>
            </div>
            <br />
            <!-- .row -->
            <div class="row">
                <div class="col-md-8">
                    <div class="white-box">
                        <div style="display: flex; gap: 5px;">
                            <input type="text" style="max-width: 500px;" class="form-control" size="30" placeholder="Search Documents" onkeyup="filterResult(event, this.value)" >
                            <button class="btn btn-primary" onclick="showTable()">Search</button>
                        </div>    
                        <div id="livesearch" style="max-width: 500px; border-radius: 5px; position: fixed; background-color: white;" ></div>
                        <div style="margin-top: 20px;">
                            <div class="table-responsive" id="resTable" style="display:none;">
                                <table class="table product-overview">
                                    <thead>
                                        <tr>
                                            <th>Document ID</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Created At</th>
                                            <th>Producer</th>
                                            <th>Verifier</th>
                                            <th>Signed / Published at</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="map"></div>
                    <button id="btn-spin">Pause rotation</button>
                </div>
            </div>
        </div>
      </section>

      <!-- <script type="text/javascript" src="{{asset('js/app/batch-details.js')}}"></script> -->
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
        const popup = new mapboxgl.Popup({ offset: 25 }).setText(
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
            var xmlhttp=new XMLHttpRequest();
            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    res = JSON.parse(this.responseText);
                    
                    for(rs of res) {
                        if(rs.location != null) {
                            let promise = fetch('https://nominatim.openstreetmap.org/search?q='+encodeURIComponent(rs.location)+'&format=json&addressdetails=1&polygon_geojson=0&countrycodes=US')
                            .then(response => response.json())
                            .then(data => {
                                console.log(encodeURIComponent(rs.location), data)
                                if(data.length > 0) {
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
                                                '<strong>'+rs.name+'</strong>'
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
                        map.style.stylesheet.layers.forEach(function(layer) {
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
            xmlhttp.open("GET","/search?q="+str, true);
            xmlhttp.send();
            startLoader();
        }

        function filterResult(event, str) {
            if(event.keyCode == 13) {
                showTable();
                return;
            }
                
            if (str.length==0) {
                document.getElementById("livesearch").innerHTML="";
                document.getElementById("livesearch").style.border="0px";
                document.getElementById("livesearch").style.paddingTop="0";
                document.getElementById("livesearch").style.paddingLeft="0";
                document.getElementById("livesearch").style.paddingRight="0";
                document.getElementById("livesearch").style.paddingBottom="0";
                $("#tbody").html('No Data Available');
                $("#resTable").hide();
                return;
            }
            var innerHtml = '';
            var tblHtml = '';
            
            for(doc of res) {
                var link;
                if(doc.status == 'Signed') {
                    link = 'view-batch/'+doc.document_id;
                } else {
                    link = 'view-publish/'+doc.document_id;
                }
                console.log(doc)
                if(doc.name.toUpperCase().includes(str.toUpperCase()) || doc.document_id.toUpperCase().includes(str.toUpperCase())){
                    innerHtml += "<div style='margin-bottom: 5px;'><a href='"+link+"' target='_blank'>"+doc.name+"</a></div>";
                    if(doc.status == 'Signed') {
                        tblHtml += "<tr><td><a href='view-batch/"+doc.document_id+"' target='_blank'>"+doc.document_id+"</a></td><td>"+doc.name+"</td><td>"+(doc.location ?? '')+"</td><td>"+(new Date(doc.created_at).toDateString())+"</td><td>"+doc.producer.user_name+"</td><td>"+doc.verifier.user_name+"</td><td>"+(new Date(doc.verified_at).toDateString())+"</td></tr>";
                    } else {
                        tblHtml += "<tr><td><a href='view-publish/"+doc.document_id+"' target='_blank'>"+doc.document_id+"</a></td><td>"+doc.name+"</td><td>"+(doc.location ?? '')+"</td><td>"+(new Date(doc.created_at).toDateString())+"</td><td>"+doc.producer+"</td><td>"+doc.verifier+"</td><td>"+(new Date(doc.published_at).toDateString())+"</td></tr>";
                    }
                    
                }

            }

            
            if(innerHtml === '') {
                innerHtml = "No suggestions";
                $("#tbody").html("No Data Available");
            }
            $("#tbody").html(tblHtml);
            document.getElementById("livesearch").style.paddingTop="15px";
            document.getElementById("livesearch").style.paddingLeft="15px";
            document.getElementById("livesearch").style.paddingRight="15px";
            document.getElementById("livesearch").style.paddingBottom="10px";

            document.getElementById("livesearch").innerHTML = innerHtml;
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
            
        }

        function hideDropDown() {
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            document.getElementById("livesearch").style.paddingTop="0";
            document.getElementById("livesearch").style.paddingLeft="0";
            document.getElementById("livesearch").style.paddingRight="0";
            document.getElementById("livesearch").style.paddingBottom="0";
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
                map.easeTo({ center, duration: 1000, easing: (n) => n });
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

    </script>
</x-public-layout>

