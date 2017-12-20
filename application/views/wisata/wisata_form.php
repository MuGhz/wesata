<?php 
$this->load->view('template/header-admin');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Wisata <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Latitude <?php echo form_error('latitude') ?></label>
            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="<?php echo $latitude; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Longitude <?php echo form_error('longitude') ?></label>
            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="<?php echo $longitude; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Namawisata <?php echo form_error('namawisata') ?></label>
            <input type="text" class="form-control" name="namawisata" id="namawisata" placeholder="Namawisata" value="<?php echo $namawisata; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Biayawisata <?php echo form_error('biayawisata') ?></label>
            <input type="text" class="form-control" name="biayawisata" id="biayawisata" placeholder="Biayawisata" value="<?php echo $biayawisata; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Keterangan <?php echo form_error('keterangan') ?></label>
            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" />
        </div>
	    <input type="hidden" name="id_wisata" value="<?php echo $id_wisata; ?>" /> 
	    <button type="submit" class="btn btn-primary base-background white"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('wisata') ?>" class="btn btn-default">Cancel</a>
	</form>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>