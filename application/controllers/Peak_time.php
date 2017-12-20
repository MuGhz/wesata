<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Peak_time extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Peak_time_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'peak_time/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'peak_time/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'peak_time/index.html';
            $config['first_url'] = base_url() . 'peak_time/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Peak_time_model->total_rows($q);
        $peak_time = $this->Peak_time_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'peak_time_data' => $peak_time,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('peak_time/peak_time_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Peak_time_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_wisata' => $row->id_wisata,
		'start_time' => $row->start_time,
		'end_time' => $row->end_time,
	    );
            $this->load->view('peak_time/peak_time_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peak_time'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('peak_time/create_action'),
	    'id_wisata' => set_value('id_wisata'),
	    'start_time' => set_value('start_time'),
	    'end_time' => set_value('end_time'),
	);
        $this->load->view('peak_time/peak_time_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_wisata' => $this->input->post('id_wisata',TRUE),
		'start_time' => $this->input->post('start_time',TRUE),
		'end_time' => $this->input->post('end_time',TRUE),
	    );

            $this->Peak_time_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('peak_time'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Peak_time_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('peak_time/update_action'),
		'id_wisata' => set_value('id_wisata', $row->id_wisata),
		'start_time' => set_value('start_time', $row->start_time),
		'end_time' => set_value('end_time', $row->end_time),
	    );
            $this->load->view('peak_time/peak_time_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peak_time'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('', TRUE));
        } else {
            $data = array(
		'id_wisata' => $this->input->post('id_wisata',TRUE),
		'start_time' => $this->input->post('start_time',TRUE),
		'end_time' => $this->input->post('end_time',TRUE),
	    );

            $this->Peak_time_model->update($this->input->post('', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('peak_time'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Peak_time_model->get_by_id($id);

        if ($row) {
            $this->Peak_time_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('peak_time'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('peak_time'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_wisata', 'id wisata', 'trim|required');
	$this->form_validation->set_rules('start_time', 'start time', 'trim|required');
	$this->form_validation->set_rules('end_time', 'end time', 'trim|required');

	$this->form_validation->set_rules('', '', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "peak_time.xls";
        $judul = "peak_time";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id Wisata");
	xlsWriteLabel($tablehead, $kolomhead++, "Start Time");
	xlsWriteLabel($tablehead, $kolomhead++, "End Time");

	foreach ($this->Peak_time_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_wisata);
	    xlsWriteLabel($tablebody, $kolombody++, $data->start_time);
	    xlsWriteLabel($tablebody, $kolombody++, $data->end_time);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Peak_time.php */
/* Location: ./application/controllers/Peak_time.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-19 15:54:56 */
/* http://harviacode.com */