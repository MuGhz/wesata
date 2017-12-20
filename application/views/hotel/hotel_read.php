<?php 
$this->load->view('template/header-admin');
?>
	<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Hotel Read</h2>
        <table class="table">
	    <tr><td>Latitude</td><td><?php echo $latitude; ?></td></tr>
	    <tr><td>Longitude</td><td><?php echo $longitude; ?></td></tr>
	    <tr><td>Namahotel</td><td><?php echo $namahotel; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('hotel') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
</div>
</div>
</div>
 <?php 
$this->load->view('template/footer-admin');
?>