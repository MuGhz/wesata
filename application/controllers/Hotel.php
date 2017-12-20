<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hotel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Hotel_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'hotel/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'hotel/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'hotel/index.html';
            $config['first_url'] = base_url() . 'hotel/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Hotel_model->total_rows($q);
        $hotel = $this->Hotel_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'hotel_data' => $hotel,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('hotel/hotel_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Hotel_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_hotel' => $row->id_hotel,
		'latitude' => $row->latitude,
		'longitude' => $row->longitude,
		'namahotel' => $row->namahotel,
	    );
            $this->load->view('hotel/hotel_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hotel'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('hotel/create_action'),
	    'id_hotel' => set_value('id_hotel'),
	    'latitude' => set_value('latitude'),
	    'longitude' => set_value('longitude'),
	    'namahotel' => set_value('namahotel'),
	);
        $this->load->view('hotel/hotel_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'latitude' => $this->input->post('latitude',TRUE),
		'longitude' => $this->input->post('longitude',TRUE),
		'namahotel' => $this->input->post('namahotel',TRUE),
	    );

            $this->Hotel_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('hotel'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Hotel_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('hotel/update_action'),
		'id_hotel' => set_value('id_hotel', $row->id_hotel),
		'latitude' => set_value('latitude', $row->latitude),
		'longitude' => set_value('longitude', $row->longitude),
		'namahotel' => set_value('namahotel', $row->namahotel),
	    );
            $this->load->view('hotel/hotel_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hotel'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_hotel', TRUE));
        } else {
            $data = array(
		'latitude' => $this->input->post('latitude',TRUE),
		'longitude' => $this->input->post('longitude',TRUE),
		'namahotel' => $this->input->post('namahotel',TRUE),
	    );

            $this->Hotel_model->update($this->input->post('id_hotel', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('hotel'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Hotel_model->get_by_id($id);

        if ($row) {
            $this->Hotel_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hotel'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hotel'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
	$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
	$this->form_validation->set_rules('namahotel', 'namahotel', 'trim|required');

	$this->form_validation->set_rules('id_hotel', 'id_hotel', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "hotel.xls";
        $judul = "hotel";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Latitude");
	xlsWriteLabel($tablehead, $kolomhead++, "Longitude");
	xlsWriteLabel($tablehead, $kolomhead++, "Namahotel");

	foreach ($this->Hotel_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->latitude);
	    xlsWriteLabel($tablebody, $kolombody++, $data->longitude);
	    xlsWriteLabel($tablebody, $kolombody++, $data->namahotel);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Hotel.php */
/* Location: ./application/controllers/Hotel.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-19 15:54:55 */
/* http://harviacode.com */