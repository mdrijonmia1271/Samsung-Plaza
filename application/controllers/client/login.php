<?php

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('admin');
        $this->load->library('session');

        $this->data['meta_title'] = 'Client Panel';
    }

    public function index()
    {
        $this->checkLogin();

        $this->load->view('client/login-layout', $this->data);
    }

    public function loginValidity()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (isset($_POST['login']) && !empty($username) && !empty($password)) {

            $password = hashPassword($this->input->post('password'));

            $info = get_row('parties', ['mobile' => $username, 'password' => $password, 'type' => 'client', 'status' => 'active', 'trash' => 0]);

            if (!empty($info)) {

                $data = [
                    'id'           => $info->id,
                    'party_code'   => $info->code,
                    'name'         => $info->name,
                    'mobile'       => $info->mobile,
                    'address'      => $info->address,
                    'godown_code'  => $info->godown_code,
                    'privilege'    => 'client',
                    'login_status' => true,
                    'login_period' => date('Y-m-d H:i:s a'),
                ];

                $this->session->set_userdata($data);

                $this->session->set_flashdata('success', 'Login successful.');
                redirect('client/dashboard', 'refresh');
            }
        }

        $this->session->set_flashdata('error', 'Invalid username and password.');
        redirect('client/login', 'refresh');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('client/login', 'refresh');
    }

    public function checkLogin()
    {
        $privilege   = $this->session->userdata('privilege');
        $loginStatus = $this->session->userdata('login_status');

        if ($privilege == 'client' && $loginStatus == true) {
            redirect('client/dashboard', 'refresh');
        }
    }
}
