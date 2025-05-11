<?php

class CreateProfile extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }

    public function index($emit = NULL) {
        $this->load->model('profiles_m');
        // set default message
        $this->data['message'] = $emit;
        $this->data['confirmation'] = null;

        // set default meta title
        $this->data['meta_title'] = 'create_profile';
        $this->data['active'] = 'data-target="create-profile"';
        $this->data['subMenu'] = 'data-target=""';


        $this->data['showroomInfo'] = get_result('godowns', '', ['code', 'name']);
        
        /*echo '<pre>';
        print_r($this->data['showroomInfo']);
        die();*/

        if (isset($_POST['createProfileBtn'])) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|is_unique[users.email]|xss_clean');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|max_length[20]|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[20]|xss_clean');
            $this->form_validation->set_rules('mobile', 'Mobile number', 'trim|required|max_length[15]|is_unique[users.mobile]|xss_clean');
            $this->form_validation->set_rules('privilege', 'Privilege', 'required');

            if ($this->form_validation->run() == FALSE) {
                // call form validation error
                    $msg_array=array(
                        "title"=>"Warning",
                        "emit"=>validation_errors('<p>', '</p>'),
                        "btn"=>true
                    );
                $this->data['confirmation'] = message('warning', $msg_array);
            } else {
                if ($_FILES["image"]["name"]!=null && $_FILES["image"]["name"]!="" ) {
                
                    // set img upload condition
                    $config['upload_path'] = './public/profiles/';
                    $config['allowed_types'] = 'jpeg|jpg|png|gif';
                    $config['max_size'] = '1024';
                    $config['file_name'] = $this->input->post('username');
                    $config['overwrite'] = true;
    
                    // $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->form_validation->set_rules('image', 'Photo', 'callback_handle_upload');
    
                    if ($this->form_validation->run() == FALSE) {
                        // call form validation error
                        $msg_array=array(
                            "title"=>"Warning",
                            "emit"=>validation_errors('<p>', '</p>'),
                            "btn"=>true
                        );
    
                        $this->data['confirmation'] = message('warning',$msg_array );
                    } else {
                        $upload_data = $this->upload->data();
                        $file = $upload_data['file_name'];
                    } 
                    
                } else{
                    
                    $file = 'superadmin.jpg';
                }
                    
                    $insert = array(
                        'opening'   => date('Y-m-d h:i:s'),
                        'name'=>$this->input->post('f_name'),
                        'email'     => $this->input->post('email'),
                        'mobile'    => $this->input->post('mobile'),
                        'username'  => $this->input->post('username'),
                        'password'  => $this->hash($this->input->post('password')),
                        'privilege' => $this->input->post('privilege'),
                        'branch'    => $this->input->post('branch'),
                        'image'     => 'public/profiles/'.$file
                    );
                    
                    /*echo '<pre>';
                    print_r($insert);
                    die();*/
                    $msg_array=array(
                        "title"=>"Success",
                        "emit"=>"New profile successfully created",
                        "btn"=>true
                    );

                    $this->data['confirmation'] = message($this->profiles_m->add($insert), $msg_array);
            }
        }

        // set the views
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/settings/create-profile', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    function handle_upload() {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            if ($this->upload->do_upload('image')) {
                $this->upload->data();
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        } else {
            // throw an error because nothing was uploaded
            $this->form_validation->set_message('handle_upload', "You must upload an valid image!");
            return false;
        }
    }

    public function hash($string) {
        return hash('md5', $string . config_item('encryption_key'));
    }

}
