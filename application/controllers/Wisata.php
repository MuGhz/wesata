<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wisata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Wisata_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'wisata/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'wisata/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'wisata/index.html';
            $config['first_url'] = base_url() . 'wisata/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Wisata_model->total_rows($q);
        $wisata = $this->Wisata_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'wisata_data' => $wisata,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('wisata/wisata_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Wisata_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_wisata' => $row->id_wisata,
		'latitude' => $row->latitude,
		'longitude' => $row->longitude,
		'namawisata' => $row->namawisata,
		'biayawisata' => $row->biayawisata,
		'keterangan' => $row->keterangan,
	    );
            $this->load->view('wisata/wisata_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wisata'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('wisata/create_action'),
	    'id_wisata' => set_value('id_wisata'),
	    'latitude' => set_value('latitude'),
	    'longitude' => set_value('longitude'),
	    'namawisata' => set_value('namawisata'),
	    'biayawisata' => set_value('biayawisata'),
	    'keterangan' => set_value('keterangan'),
	);
        $this->load->view('wisata/wisata_form', $data);
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
		'namawisata' => $this->input->post('namawisata',TRUE),
		'biayawisata' => $this->input->post('biayawisata',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Wisata_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('wisata'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Wisata_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('wisata/update_action'),
		'id_wisata' => set_value('id_wisata', $row->id_wisata),
		'latitude' => set_value('latitude', $row->latitude),
		'longitude' => set_value('longitude', $row->longitude),
		'namawisata' => set_value('namawisata', $row->namawisata),
		'biayawisata' => set_value('biayawisata', $row->biayawisata),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->load->view('wisata/wisata_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wisata'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_wisata', TRUE));
        } else {
            $data = array(
		'latitude' => $this->input->post('latitude',TRUE),
		'longitude' => $this->input->post('longitude',TRUE),
		'namawisata' => $this->input->post('namawisata',TRUE),
		'biayawisata' => $this->input->post('biayawisata',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Wisata_model->update($this->input->post('id_wisata', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('wisata'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Wisata_model->get_by_id($id);

        if ($row) {
            $this->Wisata_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('wisata'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('wisata'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
	$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');
	$this->form_validation->set_rules('namawisata', 'namawisata', 'trim|required');
	$this->form_validation->set_rules('biayawisata', 'biayawisata', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id_wisata', 'id_wisata', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "wisata.xls";
        $judul = "wisata";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Namawisata");
	xlsWriteLabel($tablehead, $kolomhead++, "Biayawisata");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

	foreach ($this->Wisata_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->latitude);
	    xlsWriteLabel($tablebody, $kolombody++, $data->longitude);
	    xlsWriteLabel($tablebody, $kolombody++, $data->namawisata);
	    xlsWriteLabel($tablebody, $kolombody++, $data->biayawisata);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Wisata.php */
/* Location: ./application/controllers/Wisata.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-19 15:54:57 */
/* http://harviacode.com */