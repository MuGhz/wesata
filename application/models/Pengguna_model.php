<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengguna_model extends CI_Model
{

    public $table = 'pengguna';
    public $id = 'id_user';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_user', $q);
	$this->db->or_like('username', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('nama', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_user', $q);
	$this->db->or_like('username', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('nama', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    //register user sama kaya create
    public function register_user($user){
        $this->db->insert($this->table, $user);
    }

    
    public function login_user($username,$pass){
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->where('username',$username);
      $this->db->where('password',$pass);
     
      if($query=$this->db->get())
      {

          return $query->row_array();
      }
      else{
        return false;
      }

    }

    public function username_check($username){
     
      $this->db->select('*');
      $this->db->from($this->table);
      $this->db->where('username',$username);
      $query=$this->db->get();
     
      if($query->num_rows()>0){
        return false;
      }else{
        return true;
      }
     
    }

    public function get_favorit($id_user){
      $this->db->select('id_wisata');
      $this->db->from('favorit');
      $this->db->where('id_user',$id_user);
      $query=$this->db->get()->result();
      console.log($query);
      $this->db->select('*');
      $this->db->from("wisata");
      foreach ($query as $row) {
        $this->db->where('id_wisata',$row->id_wisata);
      }
      return $this->db->get()->result();
      
    }

}

/* End of file Pengguna_model.php */
