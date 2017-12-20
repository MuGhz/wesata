<?php 
$this->load->view('template/header-admin');
?>
	<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Kategori_wisata <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <input type="hidden" name="id_wisata" value="<?php echo $id_wisata; ?>" /> 
	    <button type="submit" class="btn btn-primary base-background white"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kategori_wisata') ?>" class="btn btn-default">Cancel</a>
	</form>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>