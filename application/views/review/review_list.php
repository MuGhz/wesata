<?php 
$this->load->view('template/header-admin');
?>
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <h2 style="margin-top:0px">Review List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('review/create'),'Create', 'class="btn btn-primary base-background white"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('review/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('review'); ?>" class="btn btn-default base-background white">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary base-background white" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id User</th>
		<th>Id Wisata</th>
		<th>Rating</th>
		<th>Review</th>
		<th>Action</th>
            </tr><?php
            foreach ($review_data as $review)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $review->id_user ?></td>
			<td><?php echo $review->id_wisata ?></td>
			<td><?php echo $review->rating ?></td>
			<td><?php echo $review->review ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('review/read/'.$review->id_review),'Read'); 
				echo ' | '; 
				echo anchor(site_url('review/update/'.$review->id_review),'Update'); 
				echo ' | '; 
				echo anchor(site_url('review/delete/'.$review->id_review),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary base-background white">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('review/excel'), 'Excel', 'class="btn btn-primary base-background white"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</div>
</div>
 <?php 
$this->load->view('template/footer-admin');
?>