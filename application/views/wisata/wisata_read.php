<?php 
$this->load->view('template/header-admin');
?>  <div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Wisata Read</h2>
        <table class="table">
	    <tr><td>Latitude</td><td><?php echo $latitude; ?></td></tr>
	    <tr><td>Longitude</td><td><?php echo $longitude; ?></td></tr>
	    <tr><td>Namawisata</td><td><?php echo $namawisata; ?></td></tr>
	    <tr><td>Biayawisata</td><td><?php echo $biayawisata; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('wisata') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>