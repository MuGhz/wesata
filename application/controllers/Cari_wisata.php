<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Cari_wisata extends CI_Controller{
 
    public function __construct(){
        parent::__construct();
        //Codeigniter : Write Less Do More
        $this->load->model('Wisata_model');
        $this->load->model('Kategori_model');
        $this->load->model('Kategori_wisata_model');
    }
 
    function index(){
    	$wisata = $this->Wisata_model->get_all();
    	$kategori = $this->Kategori_model->get_all();
    	$dataWisata = '';
    	$dataKat = array();;
    	if (isset($_GET['kategori']) || !empty($_GET['kategori']))
		{
		    $dataKat = $_GET['kategori'];
	    	// var_dump($dataKat);
	    	$wisata_kategori = $this->Kategori_wisata_model->get_by_data($dataKat);
	    	// var_dump($wisata_kategori);
		}
		if (isset($_GET['namawisata']) || !empty($_GET['namawisata']))
		{
		    $dataWisata = $_GET['namawisata'];
	    	// var_dump($dataWisata);
		}

    	$wisata_search = $this->Wisata_model->get_search_data($dataWisata, $dataKat);
    	// var_dump($wisata_search);
    	$wisata = $wisata_search;
    	$data = array('wisata_data' => $wisata, 'kategori_data' => $kategori);
        $this->load->view('cari_wisata', $data);
    }

    public function info($id) 
    {
        $row = $this->Wisata_model->get_by_id($id);
        if ($row) {
            // var_dump($row);
	    	$kategori_data = $this->Kategori_model->get_by_id($row->id_kategori);
	    	if(!isset($kategori_data->kategori)){
	    		$kategori= 'Tidak memiliki Kategori';
	    	}  
	    	else {
	    		$kategori = $kategori_data->kategori;
	    	}
	    	// var_dump($kategori_data);
	    	$data = array(
				'id_wisata' => $row->id_wisata,
				'latitude' => $row->latitude,
				'longitude' => $row->longitude,
				'namawisata' => $row->namawisata,
				'biayawisata' => $row->biayawisata,
				'keterangan' => $row->keterangan,
				'kategori' => $kategori
	    	);

            $this->load->view('info_wisata', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cari_wisata'));
        }
    }
 
}