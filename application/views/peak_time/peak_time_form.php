<?php 
$this->load->view('template/header-admin');
?>
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Peak_time <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Wisata <?php echo form_error('id_wisata') ?></label>
            <input type="text" class="form-control" name="id_wisata" id="id_wisata" placeholder="Id Wisata" value="<?php echo $id_wisata; ?>" />
        </div>
	    <div class="form-group">
            <label for="time">Start Time <?php echo form_error('start_time') ?></label>
            <input type="text" class="form-control" name="start_time" id="start_time" placeholder="Start Time" value="<?php echo $start_time; ?>" />
        </div>
	    <div class="form-group">
            <label for="time">End Time <?php echo form_error('end_time') ?></label>
            <input type="text" class="form-control" name="end_time" id="end_time" placeholder="End Time" value="<?php echo $end_time; ?>" />
        </div>
	    <input type="hidden" name="" value="<?php echo $id_wisata; ?>" /> 
	    <button type="submit" class="btn btn-primar base-background white"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('peak_time') ?>" class="btn btn-default">Cancel</a>
	</form>
</div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>