<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kordinat_wisata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Wisata_model');
        $this->load->library('form_validation');
    }

    function index()
    {
        $wisata = $this->Wisata_model->get_all();
    	$data = array('wisata_data' => $wisata);
    	$this->load->view('wisata/kordinat_wisata_form', $data);
    }

    function create()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namawisata', 'Nama wisata', 'required');
            $this->form_validation->set_rules('latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('longitude', 'Longitude', 'required');
            $this->form_validation->set_rules('biayawisata', 'Biaya Wisata', 'required');
            $this->form_validation->set_rules('keterangan', 'Keterangan Wisata', 'required');

            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                    $namawisata = $this->input->post('namawisata');
                    $namawisata = $this->input->post('latitude');
                    $namawisata = $this->input->post('longitude');
                    $namawisata = $this->input->post('biayawisata');
                    $namawisata = $this->input->post('keterangan');
                    $data = array(
                    'latitude' => $this->input->post('latitude',TRUE),
                    'longitude' => $this->input->post('longitude',TRUE),
                    'namawisata' => $this->input->post('namawisata',TRUE),
                    'biayawisata' => $this->input->post('biayawisata',TRUE),
                    'keterangan' => $this->input->post('keterangan',TRUE),
                    );

                    $this->Wisata_model->insert($data);
                    $status = 'success';
                    $msg = 'data berhasil disimpan';
                    
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

    function hapusmarker(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->Wisata_model->delete($this->input->post('id_wisata'));
            $status = 'success';
            $msg = 'data berhasil dihapus';
            
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function viewmarker(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $status = 'success';
            $msg = 'data ditemukan';
            $datawisata = $this->Wisata_model->get_by_id($this->input->post('id_wisata'));
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'datawisata'=>$datawisata)));
        }
    }
}
?>