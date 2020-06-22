<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->db->get_where('tb_users', ['email' => $email])->row_array();
            //kalo user ada
            if ($user) {
                //kalo user aktif
                if ($user['is_active'] == 1) {
                    //cek password
                    if (password_verify($password, $user['password'])) {
                        $data = [
                            'email' => $user['email'],
                            'role_id' => $user['role_ide']
                        ];
                        $this->session->set_userdata($data);
                        if ($user['role_id'] == 1) {
                            redirect('proposal');
                        }
                        if ($user['role_id'] == 2) {
                            redirect('dosen');
                        }
                        if ($user['role_id'] == 3) {
                            redirect('dosenterpilih');
                        }
                        if ($user['role_id'] == 4) {
                            redirect('kaprodi');
                        } else {
                            redirect('viewer');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong Password!</div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> This email has not been activated!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registered!</div>');
                redirect('auth');
            }
        }
    }
    

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
