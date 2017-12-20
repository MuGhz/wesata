<?php 
$this->load->view('template/header-admin');
?>
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-success">
                  <div class="panel-heading">
                      <h3 class="panel-title">Registration</h3>
                  </div>
                  <div class="panel-body">

                  <?php
                  $error_msg=$this->session->flashdata('error_msg');
                  if($error_msg){
                    echo $error_msg;
                  }
                   ?>

                      <form role="form" method="post" action="<?php echo base_url('login/register_user'); ?>">
                          <fieldset>
                              <div class="form-group">
                                  <input class="form-control" placeholder="Name" name="nama" type="text" autofocus>
                              </div>

                              <div class="form-group">
                                  <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                              </div>
                              <div class="form-group">
                                  <input class="form-control" placeholder="Password" name="password" type="password" value="">
                              </div>
                              <input class="btn btn-lg btn-success btn-block base-background white" type="submit" value="Register" name="register" >
                          </fieldset>
                      </form>
                      <center><b>Already registered ?</b> <br></b><a href="<?php echo base_url('login/login_view'); ?>">Login here</a></center><!--for centered text-->
                  </div>
              </div>
        </div>
<?php 
$this->load->view('template/footer-admin');
?>