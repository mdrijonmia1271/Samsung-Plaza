<?php

class Material extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }

  public function index() {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;



        if($this->input->post('add_mats')){

            if ($this->input->post('mats_code') !='') {

                $temp =str_replace(' ','_',strtolower(trim($this->input->post('mats_code'))));
            }
            else{

                $temp = str_replace(' ','_',strtolower(trim($this->input->post('mats_name'))));
            }
            $exists_data = array('code' =>$temp,'trash' =>0);

            if ($this->action->exists('materials',$exists_data)) {

                $msg_array = array(
                        "title" =>"warning",
                        "emit"  =>"Material Already Exists",
                        "btn"   => true
                        );

                $this->data['confirmation'] = message("warning",$msg_array);
                $this->session->set_flashdata('confirmation',$this->data['confirmation']);
                redirect('material/material','refresh');


            }else{


                $data = array(
                    'date'        => date('Y-m-d'),
                    'name'        => $this->input->post('mats_name'),
                    'code'        => $temp,
                    'price'       => $this->input->post('price'),
                    'type'        => 'raw'
                );

                $msg_array=array(
                'title' =>'success',
                'emit'  =>'Material Successfully Added!',
                'btn'   => true
                );

            $this->data['confirmation']=message($this->action->add('materials',$data),$msg_array);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('material/material','refresh');

            }



        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

      public function view_all() {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;       


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/view_all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

     public function View($id=null) {
        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('id'   => $id);
        $this->data['records'] = $this->action->read('materials',$where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
     public function edit($id=null) {

        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array('id'   => $id);

        if ($this->input->post('update_mats')) {

                $data = array(
                    'date'        => date('Y-m-d'),
                    'name'        => $this->input->post('mats_name'),
                    'price'       => $this->input->post('price'),
                    'status'      => $this->input->post('status')
                );

                $msg_array=array(
                    'title' =>'success',
                    'emit'  =>'Material Successfully Updated!',
                    'btn'   => true
                );

            $this->data['confirmation']=message($this->action->update('materials',$data,$where),$msg_array);

            $this->session->set_flashdata('confirmation',$this->data['confirmation']);

            redirect('material/material/view_all','refresh');

        }


        $this->data['records'] = $this->action->read('materials',$where);


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function delete($id = NULL){

        $where = array ("id" =>$id);

        $data = array("trash" =>1 );


        $msg_array=array(
            "title" =>"delete",
            "emit"  =>"Material Successfully Deleted",
            "btn"   =>true
        );

        $this->data['confirmation']=message($this->action->update('materials',$data,$where),$msg_array);

        $this->session->set_flashdata("confirmation",$this->data['confirmation']);

        redirect("material/material/view_all","refresh");
    }

}
