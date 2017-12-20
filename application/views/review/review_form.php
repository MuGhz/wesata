<?php 
$this->load->view('template/header-admin');
?>
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Review <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
    	    <div class="form-group">
                <label for="int">Id User <?php echo form_error('id_user') ?></label>
                <input type="text" class="form-control" name="id_user" id="id_user" placeholder="Id User" value="<?php echo $id_user; ?>" />
            </div>
    	    <div class="form-group">
                <label for="int">Id Wisata <?php echo form_error('id_wisata') ?></label>
                <input type="text" class="form-control" name="id_wisata" id="id_wisata" placeholder="Id Wisata" value="<?php echo $id_wisata; ?>" />
            </div>
    	    <div class="form-group">
                <label for="int">Rating <?php echo form_error('rating') ?></label>
                <input type="text" class="form-control" name="rating" id="rating" placeholder="Rating" value="<?php echo $rating; ?>" />
            </div>
    	    <div class="form-group">
                <label for="varchar">Review <?php echo form_error('review') ?></label>
                <input type="text" class="form-control" name="review" id="review" placeholder="Review" value="<?php echo $review; ?>" />
            </div>
    	    <input type="hidden" name="id_review" value="<?php echo $id_review; ?>" /> 
    	    <button type="submit" class="btn btn-primary base-background white"><?php echo $button ?></button> 
    	    <a href="<?php echo site_url('review') ?>" class="btn btn-default">Cancel</a>
	   </form>
    </div>
</div>
</div>
<?php 
$this->load->view('template/footer-admin');
?>