<?php 
$this->load->view('template/header-admin');
?>
	<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Peak_time Read</h2>
        <table class="table">
	    <tr><td>Id Wisata</td><td><?php echo $id_wisata; ?></td></tr>
	    <tr><td>Start Time</td><td><?php echo $start_time; ?></td></tr>
	    <tr><td>End Time</td><td><?php echo $end_time; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('peak_time') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>