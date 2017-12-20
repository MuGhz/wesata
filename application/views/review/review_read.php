<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Review Read</h2>
        <table class="table">
	    <tr><td>Id User</td><td><?php echo $id_user; ?></td></tr>
	    <tr><td>Id Wisata</td><td><?php echo $id_wisata; ?></td></tr>
	    <tr><td>Rating</td><td><?php echo $rating; ?></td></tr>
	    <tr><td>Review</td><td><?php echo $review; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('review') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>