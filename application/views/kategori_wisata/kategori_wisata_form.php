<?php 
$this->load->view('template/header-admin');
?>
	<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Kategori_wisata <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
        <div class="form-group">
            <label for="varchar">ID_Wisata <?php echo form_error('id_wisata') ?></label>
            <input type="text" class="form-control" name="id_wisata" id="id_wisata" placeholder="ID Wisata" value="<?php echo $id_wisata; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">ID_Kategori <?php echo form_error('id_kategori') ?></label>
            <input type="text" class="form-control" name="id_kategori" id="id_kategori" placeholder="ID Kategori" value="<?php echo $id_kategori; ?>" />
        </div>
	    <button type="submit" class="btn btn-primary base-background white"><?php echo $button ?></button> 

	    <a href="<?php echo site_url('kategori_wisata') ?>" class="btn btn-default">Cancel</a>
	</form>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>