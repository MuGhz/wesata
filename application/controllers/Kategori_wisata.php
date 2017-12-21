<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_wisata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_wisata_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kategori_wisata/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kategori_wisata/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kategori_wisata/index.html';
            $config['first_url'] = base_url() . 'kategori_wisata/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kategori_wisata_model->total_rows($q);
        $kategori_wisata = $this->Kategori_wisata_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kategori_wisata_data' => $kategori_wisata,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('kategori_wisata/kategori_wisata_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kategori_wisata_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_wisata' => $row->id_wisata,
		'id_kategori' => $row->id_kategori,
	    );
            $this->load->view('kategori_wisata/kategori_wisata_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_wisata'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kategori_wisata/create_action'),
	    'id_wisata' => set_value('id_wisata'),
	    'id_kategori' => set_value('id_kategori'),
	);
        $this->load->view('kategori_wisata/kategori_wisata_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'id_wisata' => $this->input->post('id_wisata',TRUE),
            'id_kategori' => $this->input->post('id_kategori',TRUE),                
	    );

            $this->Kategori_wisata_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kategori_wisata'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kategori_wisata_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kategori_wisata/update_action'),
		'id_wisata' => set_value('id_wisata', $row->id_wisata),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
	    );
            $this->load->view('kategori_wisata/kategori_wisata_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_wisata'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_wisata', TRUE));
        } else {
            $data = array(
	    );

            $this->Kategori_wisata_model->update($this->input->post('id_wisata', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kategori_wisata'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kategori_wisata_model->get_by_id($id);

        if ($row) {
            $this->Kategori_wisata_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kategori_wisata'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_wisata'));
        }
    }

    public function _rules() 
    {

	$this->form_validation->set_rules('id_wisata', 'id_wisata', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kategori_wisata.xls";
        $judul = "kategori_wisata";
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

	foreach ($this->Kategori_wisata_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Kategori_wisata.php */
/* Location: ./application/controllers/Kategori_wisata.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-19 15:54:56 */
/* http://harviacode.com */