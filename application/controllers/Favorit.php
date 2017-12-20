<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favorit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Favorit_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'favorit/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'favorit/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'favorit/index.html';
            $config['first_url'] = base_url() . 'favorit/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Favorit_model->total_rows($q);
        $favorit = $this->Favorit_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'favorit_data' => $favorit,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('favorit/favorit_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Favorit_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user' => $row->id_user,
		'id_wisata' => $row->id_wisata,
	    );
            $this->load->view('favorit/favorit_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('favorit'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('favorit/create_action'),
	    'id_user' => set_value('id_user'),
	    'id_wisata' => set_value('id_wisata'),
	);
        $this->load->view('favorit/favorit_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
	    );

            $this->Favorit_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('favorit'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Favorit_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('favorit/update_action'),
		'id_user' => set_value('id_user', $row->id_user),
		'id_wisata' => set_value('id_wisata', $row->id_wisata),
	    );
            $this->load->view('favorit/favorit_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('favorit'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
	    );

            $this->Favorit_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('favorit'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Favorit_model->get_by_id($id);

        if ($row) {
            $this->Favorit_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('favorit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('favorit'));
        }
    }

    public function _rules() 
    {

	$this->form_validation->set_rules('id_user', 'id_user', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "favorit.xls";
        $judul = "favorit";
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

	foreach ($this->Favorit_model->get_all() as $data) {
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

/* End of file Favorit.php */
/* Location: ./application/controllers/Favorit.php */