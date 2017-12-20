<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Review_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'review/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'review/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'review/index.html';
            $config['first_url'] = base_url() . 'review/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Review_model->total_rows($q);
        $review = $this->Review_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'review_data' => $review,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('review/review_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Review_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_review' => $row->id_review,
		'id_user' => $row->id_user,
		'id_wisata' => $row->id_wisata,
		'rating' => $row->rating,
		'review' => $row->review,
	    );
            $this->load->view('review/review_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('review'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('review/create_action'),
	    'id_review' => set_value('id_review'),
	    'id_user' => set_value('id_user'),
	    'id_wisata' => set_value('id_wisata'),
	    'rating' => set_value('rating'),
	    'review' => set_value('review'),
	);
        $this->load->view('review/review_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_user' => $this->input->post('id_user',TRUE),
		'id_wisata' => $this->input->post('id_wisata',TRUE),
		'rating' => $this->input->post('rating',TRUE),
		'review' => $this->input->post('review',TRUE),
	    );

            $this->Review_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('review'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Review_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('review/update_action'),
		'id_review' => set_value('id_review', $row->id_review),
		'id_user' => set_value('id_user', $row->id_user),
		'id_wisata' => set_value('id_wisata', $row->id_wisata),
		'rating' => set_value('rating', $row->rating),
		'review' => set_value('review', $row->review),
	    );
            $this->load->view('review/review_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('review'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_review', TRUE));
        } else {
            $data = array(
		'id_user' => $this->input->post('id_user',TRUE),
		'id_wisata' => $this->input->post('id_wisata',TRUE),
		'rating' => $this->input->post('rating',TRUE),
		'review' => $this->input->post('review',TRUE),
	    );

            $this->Review_model->update($this->input->post('id_review', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('review'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Review_model->get_by_id($id);

        if ($row) {
            $this->Review_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('review'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('review'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_user', 'id user', 'trim|required');
	$this->form_validation->set_rules('id_wisata', 'id wisata', 'trim|required');
	$this->form_validation->set_rules('rating', 'rating', 'trim|required');
	$this->form_validation->set_rules('review', 'review', 'trim|required');

	$this->form_validation->set_rules('id_review', 'id_review', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "review.xls";
        $judul = "review";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id User");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Wisata");
	xlsWriteLabel($tablehead, $kolomhead++, "Rating");
	xlsWriteLabel($tablehead, $kolomhead++, "Review");

	foreach ($this->Review_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_user);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_wisata);
	    xlsWriteNumber($tablebody, $kolombody++, $data->rating);
	    xlsWriteLabel($tablebody, $kolombody++, $data->review);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Review.php */
/* Location: ./application/controllers/Review.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-12-19 15:54:56 */
/* http://harviacode.com */