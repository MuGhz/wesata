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
                	<p><b>ID Wisata : </b><?php echo $id_wisata ?></p>
                	<p><b>Longitude : </b><?php echo $longitude ?></p>
                	<p><b>Latitude : </b><?php echo $latitude ?></p>
                	<p><b>Biaya : </b><?php echo $biayawisata ?></p>
                	<p><b>Kategori : </b><?php echo $kategori ?></p>
                	<p><b>Keterangan : </b><?php echo $keterangan ?></p>
            </div>
        </div>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>