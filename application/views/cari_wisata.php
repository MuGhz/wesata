<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-list"></span> Pengaturan</div>
                <div class="panel-body" style="min-height:400px;">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="namawisata">Kata Kunci</label>
                                    <input type="text" class="form-control" name="namawisata" id="namawisata">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="latitude">Lokasi</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="biayawisata">Biaya Wisata</label>
                                    <input type="text" class="form-control" name="biayawisata" id="biayawisata">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea type="text" class="form-control" rows="2" id="keterangan"></textarea>
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
                                echo anchor('wisata', '<span class="glyphicon glyphicon-plus"></span> Tambah Data wisata', 'class="btn btn-info form-control base-background white"');
                            } ?>
                        </div> -->
                        <div class="form-group">
                            <button class="btn btn-info btn-sm base-background white" id="simpandaftarkoordinatwisata"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                            <button class="btn btn-warning btn-sm white" id="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <h2 style="margin-top:0px">Cari Wisata</h2>
        </div>
        <div class="col-md-12 col-sm-12">
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
                                    echo '<button class="btn-danger btn btn-sm white" id="hapusmarkerwisata" data-iddatawisata="'.$wisata->id_wisata.'"><span class="glyphicon-remove glyphicon"></span></button>';
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
        // console.log($wisata_data);
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
    .on('click','#simpandaftarkoordinatwisata',simpan)
    .on('click','#hapusmarkerwisata',deletemarker)
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

    //buat simpan
    function simpan() {
        var datawisata = {'namawisata':$('#namawisata').val(),
        'latitude':$('#latitude').val(),
        'longitude':$('#longitude').val(),
        'biayawisata':$('#biayawisata').val(),
        'keterangan':$('#keterangan').val()};
        // console.log(datawisata);
        $.ajax({
            url : '<?php echo site_url("kordinat_wisata/create") ?>',
            dataType : 'json',
            data : datawisata,
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    clearmap();
                    $('#daftarkoordinatwisata').load('<?php echo current_url()."/ #daftarkoordinatwisata > *" ?>');
                    alert(data.msg);
                    clearmap();
                }else{
                    alert(data.msg);
                }
            }
        })
    }

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
                        $wisata = data.datawisata
                        var myLatLng = {lat: parseFloat(data.datawisata.latitude), lng: parseFloat(data.datawisata.longitude)};
                        // console.log($wisata.latitude);
                        addMarker($wisata.namawisata,myLatLng);
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