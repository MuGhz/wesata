  <?php 
$this->load->view('template/header-admin');
?>


  <div class="col-md-4">
 
      <table class="table table-bordered table-striped">
 
 
        <tr>
          <th colspan="2"><h4 class="text-center">User Info</h3></th>
 
        </tr>
          <tr>
            <td>User Name</td>
            <td><?php echo $this->session->userdata('username'); ?></td>
          </tr>
          <tr>
            <td>Nama</td>
            <td><?php echo $this->session->userdata('nama');  ?></td>
          </tr>
          <tr>
            </table>
 
 
    </div>
<?php 
$this->load->view('template/footer-admin');
?>