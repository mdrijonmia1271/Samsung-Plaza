<?php

class Editpass extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }
    
    public function index($id=null) {
        $this->data['meta_title'] = 'edit_profile';
        $this->data['active'] = 'data-target="edit-profile"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        $where = array('id' => $id);
   
        if($this->input->post("update")){

            $msg_array=array(
                "title"=>"success",
                "emit"=>"Profile Updated Successfully",
                "btn"=>true
            );

            $this->data['confirmation'] = message($this->passUpdate($where),$msg_array);
        }

        $this->data['profile']=$this->action->read("users", $where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/settings/editpass', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function passUpdate($where){
    	$pass = $this->input->post('password');
	    $data = array(
	        'password' => $this->hash($pass)
	    ); 
            return $this->action->update('users', $data, $where);
    }
    
    function handle_upload() {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {

                $img = "./".$_POST['img_url'];
                if (is_file($img)) {
                    unlink($img);
                }

                $config['upload_path']   = './public/profiles/';
                $config['allowed_types'] = 'jpeg|jpg|png|gif';
                $config['max_size']      = '1024';
                $config['file_name']     = $this->input->post('username');
                $config['overwrite']     = true;

                // $this->load->library('upload', $config);
                $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                
                return true;
            } else {
                // possibly do some clean up ... then throw an error
                $msg_array=array(
                    "title"=>"Warning",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                );
                $this->data['confirmation']=message('warning',$msg_array);
                return false;
            }
        }
    }
	
	public function hash($string) {
        return hash('md5', $string . config_item('encryption_key'));
    }


}

