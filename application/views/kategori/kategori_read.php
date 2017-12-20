<?php 
$this->load->view('template/header-admin');
?>	<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Kategori Read</h2>
        <table class="table">
	    <tr><td>Kategori</td><td><?php echo $kategori; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kategori') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
</div>
</div>
</div>
 <?php 
$this->load->view('template/footer-admin');
?>