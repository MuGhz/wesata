<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kordinat_hotel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Hotel_model');
        $this->load->library('form_validation');
    }

    function index()
    {
        $hotel = $this->Hotel_model->get_all();
    	$data = array('hotel_data' => $hotel);
    	$this->load->view('hotel/kordinat_hotel_form', $data);
    }

    function create()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namahotel', 'Nama Hotel', 'required');
            $this->form_validation->set_rules('latitude', 'Latitude', 'required');
            $this->form_validation->set_rules('longitude', 'Longitude', 'required');

            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                    $namawisata = $this->input->post('namahotel');
                    $namawisata = $this->input->post('latitude');
                    $namawisata = $this->input->post('longitude');
                    $data = array(
                    'latitude' => $this->input->post('latitude',TRUE),
                    'longitude' => $this->input->post('longitude',TRUE),
                    'namahotel' => $this->input->post('namahotel',TRUE)
                    );

                    $this->Hotel_model->insert($data);
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
            $this->Hotel_model->delete($this->input->post('id_hotel'));
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
            $datahotel = $this->Hotel_model->get_by_id($this->input->post('id_hotel'));
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'datahotel'=>$datahotel)));
        }
    }
}
?>