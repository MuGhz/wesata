<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h2 style="margin-top:0px">Koordinat Hotel</h2>
        </div>
        <div class="col-md-8 col-sm-8">
            <div class="panel panel-primary ">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-globe"></span> Peta</div>
                <div class="panel-body" style="height:300px;" id="map-canvas">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-list"></span> Daftar Koordinat</div>
                <div class="panel-body" style="min-height:300px;">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="namahotel">Nama Hotel</label>
                                    <input type="text" class="form-control" name="namahotel" id="namahotel">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-sm base-background white" id="simpandaftarkoordinathotel"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                            <button class="btn btn-warning btn-sm white" id="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-th-list"></span> Daftar Koordinat marker Data Hotel</div>
                <div class="panel-body" style="min-height:400px">
                    <table class="table">
                        <th>No</th>
                        <th>Data Hotel</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th></th>
                        <tbody id="daftarkoordinathotel">
                            <?php
                            if ($hotel_data) {
                                $no = 1;
                                foreach ($hotel_data as $hotel) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo $no++;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $hotel->namahotel;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $hotel->latitude."</br>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo $hotel->longitude."</br>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo '<button class="btn-info btn btn-sm base-background white" id="viewmarkerhotel" data-iddatahotel="'.$hotel->id_hotel.'"><span class="glyphicon-globe glyphicon"></span> View marker</button> ';
                                    echo '<button class="btn-danger btn btn-sm white" id="hapusmarkerhotel" data-iddatahotel="'.$hotel->id_hotel.'"><span class="glyphicon-remove glyphicon"></span></button>';
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBosE8LmFLSBAWaziP98H3Zbfm62sFBpXU&callback=initMap"
    async defer></script>
<script>
    var map;
    var markers = [];

    function initMap() {
        // console.log($hotel_data);
        var mapOptions = {
        zoom: 12,
        // Center disemarang
        center: new google.maps.LatLng(-6.998550616332137, 110.41481362190098)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        // Add a listener for the click event
        google.maps.event.addListener(map, 'rightclick', addLatLng);
        google.maps.event.addListener(map, "rightclick", function(event) {
          var lat = event.latLng.lat();
          var lng = event.latLng.lng();
          $('#latitude').val(lat);
          $('#longitude').val(lng);
          // alert(lat +" dan "+lng);

        });
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

    $(document).on('click','#reset',clearmap)
    .on('click','#simpandaftarkoordinathotel',simpan)
    .on('click','#hapusmarkerhotel',deletemarker)
    .on('click','#viewmarkerhotel',viewmarker);

    //membersihkan peta dari marker
    function clearmap(){
        $('#namahotel').val('');
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

    //buat simpan
    function simpan() {
        var datahotel = {'namahotel':$('#namahotel').val(),
        'latitude':$('#latitude').val(),
        'longitude':$('#longitude').val()};
        // console.log(datahotel);
        $.ajax({
            url : '<?php echo site_url("kordinat_hotel/create") ?>',
            dataType : 'json',
            data : datahotel,
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    clearmap();
                    $('#daftarkoordinathotel').load('<?php echo current_url()."/ #daftarkoordinathotel > *" ?>');
                    alert(data.msg);
                    clearmap();
                }else{
                    alert(data.msg);
                }
            }
        })
    }

    function viewmarker(){
        var id = $(this).data('iddatahotel');
        var datahotel = {'id_hotel':id};
        // console.log(datahotel);
        $.ajax({
            url : '<?php echo site_url("kordinat_hotel/viewmarker") ?>',
            data : datahotel,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    clearmap();
                    //load marker
                        $hotel = data.datahotel
                        var myLatLng = {lat: parseFloat(data.datahotel.latitude), lng: parseFloat(data.datahotel.longitude)};
                        // console.log($hotel.latitude);
                        addMarker($hotel.namahotel,myLatLng);
                        return false;
                    //end load marker
                }else{
                    alert(data.msg);
                }
            }
        })
    }

    function deletemarker(){
        var id = $(this).data('iddatahotel');
        var datahotel = {'id_hotel':id};
        // console.log(datahotel);
        $.ajax({
            url : '<?php echo site_url("kordinat_hotel/hapusmarker") ?>',
            data : datahotel,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    alert(data.msg);
                     $('#daftarkoordinathotel').load('<?php echo current_url()."/ #daftarkoordinathotel > *" ?>');
                    clearmap();
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    // Menampilkan marker lokasi jembatan
    function addMarker(nama,location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title : nama
        });
        markers.push(marker);
    }
</script>
<?php 
$this->load->view('template/footer-admin');
?>