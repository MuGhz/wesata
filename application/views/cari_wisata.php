<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h2 style="margin-top:0px">Cari Wisata</h2>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-list"></span> Pencarian</div>
                <div class="panel-body" style="min-height:400px;">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="namawisata">Kata Kunci</label>
                                    <input type="text" class="form-control" name="namawisata" id="namawisata">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <?php 

                                    if ($kategori_data) {
                                        // $no = 1;
                                        foreach ($kategori_data as $datakategori) {
                                            echo "<div class='checkbox'><label><input type='checkbox' name='kategori[]' value='".$datakategori->id_kategori."''>".$datakategori->kategori."</label></div>";
                                            // $no++;
                                        }
                                        // echo '</select>';
                                    }
                                    ?>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="datawisata">Data wisata</label>
                            <?php if (! $wisata_data) {
                                echo '<select name="id_wisata" id="id_wisata" class="form-control">';
                                foreach ($wisata_data as $datawisata) {
                                    echo "<option value='".$datawisata->id_wisata."'>".$datawisata->namawisata."</option>";
                                }
                                echo '</select>';
                            }else{
                                echo anchor('wisata', '<span class="glyphicon glyphicon-plus"></span> Tambah Kategori wisata', 'class="btn btn-info form-control base-background white"');
                            } ?>
                        </div> -->
                        <div class="form-group">
                            <button class="btn btn-info btn-sm base-background white" id="cariwisata" type="submit"><span class="glyphicon glyphicon-search"></span> Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 col-sm-8">
            <div class="panel panel-primary ">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-globe"></span> Peta</div>
                <div class="panel-body" style="height:400px;" id="map-canvas">
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-th-list"></span> Daftar Pencarian Data wisata</div>
                <div class="panel-body" style="min-height:400px">
                    <table class="table">
                        <th>No</th>
                        <th>Data wisata</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th></th>
                        <tbody id="daftarkoordinatwisata">
                            <?php
                            if ($wisata_data) {
                                $no = 1;
                                foreach ($wisata_data as $wisata) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo $no++;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $wisata->namawisata;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $wisata->latitude."</br>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $wisata->longitude."</br>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo '<button class="btn-info btn btn-sm base-background white" id="viewmarkerwisata" data-iddatawisata="'.$wisata->id_wisata.'"><span class="glyphicon-globe glyphicon"></span> View marker</button> ';
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBosE8LmFLSBAWaziP98H3Zbfm62sFBpXU&callback=initMap&v=3&libraries=geometry"
    async defer></script>
<script>
    var map;
    var markers = [];
    var infoWindow;

    function initMap() {
        // console.log($wisata_data);
        var mapOptions = {
        zoom: 12,
        // Center disemarang
        center: new google.maps.LatLng(-6.998550616332137, 110.41481362190098)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        infoWindow = new google.maps.InfoWindow({map: map});
        // Add a listener for the click event
        // google.maps.event.addListener(map, 'rightclick', addLatLng);
        // google.maps.event.addListener(map, "rightclick", function(event) {
        //   var lat = event.latLng.lat();
        //   var lng = event.latLng.lng();
        //   $('#latitude').val(lat);
        //   $('#longitude').val(lng);
        //   // alert(lat +" dan "+lng);

        // });
        var pos = {
              lat: -6.361227310772651,
              lng: 106.82789605110884
            };
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('My Location');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        var wisata_data = <?php echo json_encode($wisata_data); ?>;
        // console.log(wisata_data);
        for (index = 0; index < wisata_data.length; ++index) {
            var myLatLng = {lat: parseFloat(wisata_data[index].latitude), lng: parseFloat(wisata_data[index].longitude)};
            // console.log(pos.lat);
            // console.log(pos.lng);
            // console.log(myLatLng.lat);
            // $dist = distance(pos.lat,pos.lng,myLatLng.lat,myLatLng.lng);
            $objA = new google.maps.LatLng(pos.lat,pos.lng);
            $objB = new google.maps.LatLng(myLatLng.lat,myLatLng.lng);
            $dist = google.maps.geometry.spherical.computeDistanceBetween($objA, $objB) /1000;
            console.log($dist + " km");
            addMarker(wisata_data[index],myLatLng, $dist);
        }
        // foreach ($wisata_data as $wisata) {
        //     // var myLatLng = {lat: parseFloat($wisata->latitude), lng: parseFloat($wisata->longitude)};
        //     // addMarker($wisata->namawisata,myLatLng);
        //     console.log($wisata);
        // }

        
    }
    /**
     * Handles click events on a map, and adds a new point to the marker.
     * @param {google.maps.MouseEvent} event
     */
    function addLatLng(event) {
        var marker = new google.maps.Marker({
        position: event.latLng,
        title: 'Simple GIS',
        map: map
        });
        markers.push(marker);
    }

    // google.maps.event.addDomListener(window, 'load', initMap);

    $(document).on('click','#hapusmarkerwisata',deletemarker)
    .on('click','#viewmarkerwisata',viewmarker);

    //membersihkan peta dari marker
    function clearmap(){
        $('#biayawisata').val('');
        $('#namawisata').val('');
        $('#keterangan').val('');
        $('#latitude').val('');
        $('#longitude').val('');
        setMapOnAll(null);
    }
    //buat hapus marker
    function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
      markers = [];
    }

    // //buat simpan
    // function simpan() {
    //     var datawisata = {'namawisata':$('#namawisata').val(),
    //     'latitude':$('#latitude').val(),
    //     'longitude':$('#longitude').val(),
    //     'biayawisata':$('#biayawisata').val(),
    //     'keterangan':$('#keterangan').val()};
    //     // console.log(datawisata);
    //     $.ajax({
    //         url : '<?php echo site_url("kordinat_wisata/create") ?>',
    //         dataType : 'json',
    //         data : datawisata,
    //         type : 'POST',
    //         success : function(data,status){
    //             if (data.status!='error') {
    //                 clearmap();
    //                 $('#daftarkoordinatwisata').load('<?php echo current_url()."/ #daftarkoordinatwisata > *" ?>');
    //                 alert(data.msg);
    //                 clearmap();
    //             }else{
    //                 alert(data.msg);
    //             }
    //         }
    //     })
    // }

    function viewmarker(){
        var id = $(this).data('iddatawisata');
        var datawisata = {'id_wisata':id};
        // console.log(datawisata);
        $.ajax({
            url : '<?php echo site_url("kordinat_wisata/viewmarker") ?>',
            data : datawisata,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    clearmap();
                    //load marker
                        var myLatLng = {lat: parseFloat(data.datawisata.latitude), lng: parseFloat(data.datawisata.longitude)};
                        var pos = {
                          lat: -6.361227310772651,
                          lng: 106.82789605110884
                        };
                        if (navigator.geolocation) {
                          navigator.geolocation.getCurrentPosition(function(position) {
                            pos = {
                              lat: position.coords.latitude,
                              lng: position.coords.longitude
                            };

                            infoWindow.setPosition(pos);
                            infoWindow.setContent('My Location');
                          }, function() {
                            handleLocationError(true, infoWindow, map.getCenter());
                          });
                        } else {
                              // Browser doesn't support Geolocation
                              handleLocationError(false, infoWindow, map.getCenter());
                        }

                        $wisata = data.datawisata;
                        // $dist = distance(pos.lat,pos.lng,myLatLng.lat,myLatLng.lng);
                        $objA = new google.maps.LatLng(pos.lat,pos.lng);
                        $objB = new google.maps.LatLng(myLatLng.lat,myLatLng.lng);
                        $dist = google.maps.geometry.spherical.computeDistanceBetween($objA, $objB) /1000;
                        // console.log($wisata.latitude);
                        addMarker($wisata,myLatLng,$dist);
                        map.setCenter(myLatLng);
                        return false;
                    //end load marker
                }else{
                    alert(data.msg);
                }
            }
        })
    }

    function deletemarker(){
        var id = $(this).data('iddatawisata');
        var datawisata = {'id_wisata':id};
        // console.log(datawisata);
        $.ajax({
            url : '<?php echo site_url("kordinat_wisata/hapusmarker") ?>',
            data : datawisata,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                     $('#daftarkoordinatwisata').load('<?php echo current_url()."/ #daftarkoordinatwisata > *" ?>');
                    clearmap();
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    // Menampilkan marker lokasi jembatan
    function addMarker(wisata,location,dist) {
        console.log(dist + "kkm");

        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">'+ wisata.namawisata+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Latitude : </b>' + wisata.latitude +'</p>'+
            '<p><b>Longitude : </b>' + wisata.longitude +'</p>'+
            '<p><b>Biaya : </b>' + wisata.biayawisata +'</p>'+
            '<p><b>Jarak : </b>' + dist +' km</p>'+
            '<p><b>More info : </b>' + '<a href="cari_wisata/info/' + wisata.id_wisata + '">'+
            wisata.namawisata +'</a></p>'+
            '</div>'+ '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        if (wisata.id_kategori) {
            var marker = new google.maps.Marker({
                position: location,
                icon: icons[wisata.id_kategori].icon,
                map: map,
                title : wisata.namawisata
            });
        }
        else{
            var marker = new google.maps.Marker({
                position: location,
                // icon: icons[wisata.id_kategori].icon,
                map: map,
                title : wisata.namawisata
            });
        }
        

        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });

        markers.push(marker);
    }

    //menghitung jarak dari dua titik
    function distance(lat1, lon1, lat2, lon2) {
          var radlat1 = Math.PI * lat1/180
        var radlat2 = Math.PI * lat2/180
        var theta = lon1-lon2
        var radtheta = Math.PI * theta/180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180/Math.PI
        dist = dist * 60 * 1.1515
        dist = dist * 1.609344 
        return dist
    }

    var iconBase = "<?=base_url();?>assets/";
    var icons = {
      1: {
        icon: iconBase + 'waterfall.png'
      },
      2: {
        icon: iconBase + 'mill.png'
      },
      3: {
        icon: iconBase + 'village.png'
      }
    };
</script>
<?php 
$this->load->view('template/footer-admin');
?>