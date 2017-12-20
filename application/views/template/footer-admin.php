<!--footer admin-->
 <div class="col-md-12 text-center">
 <?php 
	 if ($this->session->userdata('username') !== NULL) {
?>
	<a href="<?php echo base_url('login/user_logout');?>" >  <button type="button" class="btn btn-primary base-background white">Logout</button></a>
<?php
	}
?>
</div>
  </div>

</div>

</div>
  </body>
</html>