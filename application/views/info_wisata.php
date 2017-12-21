<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px"><?php echo $namawisata ?></h2>

        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary ">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-info-sign"></span> Informasi Wisata</div>
                 <div class="panel-body" style="min-height:200px;">
                    <div class="col-md-12 col-sm-12">
                        <br>
                	<p><b>ID Wisata : </b><?php echo $id_wisata ?></p>
                	<p><b>Longitude : </b><?php echo $longitude ?></p>
                	<p><b>Latitude : </b><?php echo $latitude ?></p>
                	<p><b>Biaya : </b><?php echo $biayawisata ?></p>
                	<p><b>Kategori : </b><?php echo $kategori ?></p>
                	<p><b>Keterangan : </b><?php echo $keterangan ?></p>
                    <div class="col-md-12 col-sm-12">
                    <?php 
                    if ($this->session->userdata('username') !== NULL) {
                        if(!$favorit) {
                             echo anchor(site_url('cari_wisata/favorit/'.$id_wisata),'<span class="glyphicon glyphicon-heart"></span>Favorit', 'class="btn btn-primary base-background white"');
                        }
                        else {
                            echo anchor(site_url('cari_wisata/unfavorit/'.$id_wisata),'<span class="glyphicon glyphicon-heart"></span>Unfavorit', 'class="btn btn-danger white"');
                        }
                    }

                    ?>
                </div>
            </div>
            </div></div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary ">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-globe"></span> Peta</div>
                <div class="panel-body" style="height:400px;" id="map-canvas">
                </div>
            </div>
        </div>
</div>
</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBosE8LmFLSBAWaziP98H3Zbfm62sFBpXU&callback=initMap&v=3&libraries=places"
    async defer></script>
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var map;
      var infowindow;

      function initMap() {
        var pyrmont = {lat: <?php echo $latitude ?>, lng: <?php echo $longitude ?>};

        map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: pyrmont,
          zoom: 15
        });

         if ('<?php echo $kategori ?>' !== 'Tidak memiliki Kategori') {
            var marker = new google.maps.Marker({
                position: pyrmont,
                icon: icons['<?php echo $kategori ?>'].icon,
                map: map,
                title : '<?php echo $namawisata ?>'
            });
        }
        else{
            var marker = new google.maps.Marker({
                position: pyrmont,
                // icon: icons[wisata.id_kategori].icon,
                map: map,
                title : '<?php echo $namawisata ?>'
            });
        }

        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: 500,
          type: ['lodging']
        }, callback);
      }

      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });


       
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
          infowindow.open(map, this);
        });
      }

    var iconBase = "<?=base_url();?>assets/";
    var icons = {
      'Alam': {
        icon: iconBase + 'waterfall.png'
      },
      'Desa': {
        icon: iconBase + 'mill.png'
      },
      'Kota': {
        icon: iconBase + 'village.png'
      }
    };
    </script>
<?php 
$this->load->view('template/footer-admin');
?>