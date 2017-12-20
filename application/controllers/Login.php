<?php
class Login extends CI_Controller {
 
public function __construct(){
 
    parent::__construct();
  	$this->load->helper('url');
  	$this->load->model('Pengguna_model');
    $this->load->library('session');
 
}

public function index()
{
$this->load->view("register");
}

public function register_user(){

      $user=array(
      'username'=>$this->input->post('username'),
      'password'=>md5($this->input->post('password')),
      'nama'=>$this->input->post('nama'));
       print_r($user);

  $username_check=$this->Pengguna_model->username_check($user['username']);

if($username_check){
  $this->Pengguna_model->register_user($user);
  $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
  redirect('login/login_view');

}
else{

  $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
  redirect('login');


}

}

public function login_view(){
 
$this->load->view("login.php");
 
}

function login_user(){
  $user_login=array(
 
  'username'=>$this->input->post('username'),
  'password'=>md5($this->input->post('password'))
 
    );
 
    $data=$this->Pengguna_model->login_user($user_login['username'],$user_login['password']);
      if($data)
      {
        $this->session->set_userdata('username',$data['username']);
        $this->session->set_userdata('nama',$data['nama']);
        $this->session->set_userdata('id_user',$data['id_user']);
 
        $this->load->view('user_profile.php');
 
      }
      else{
        $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        $this->load->view("login.php");
      }
 
 
}

function user_profile(){
 
$this->load->view('user_profile.php');
 
}

public function user_logout(){
 
  $this->session->sess_destroy();
  redirect('login/login_view', 'refresh');
}



}
?>
