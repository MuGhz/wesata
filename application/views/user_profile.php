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

    <!-- <div class="col-md-12 col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading base-background white"><span class="glyphicon glyphicon-th-list"></span> Daftar Koordinat marker Data wisata</div>
                <div class="panel-body" style="min-height:400px">
                    <table class="table">
                        <th>No</th>
                        <th>Data wisata</th>
                        <th>Biaya</th>
                        <tbody id="daftarfavorit">
                            <?php
                            if ($wisata_data) {
                                $no = 1;
                                foreach ($wisata_data as $wisata) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo $no++;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $wisata->namawisata;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $wisata->biaya."</br>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                             ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
<?php 
$this->load->view('template/footer-admin');
?>