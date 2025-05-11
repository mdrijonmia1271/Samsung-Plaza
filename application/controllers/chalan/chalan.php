<?php
class Chalan extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'chalan';
        $this->data['active']       = 'data-target="chalan_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';

        if(isset($_POST['save'])){
            foreach ($_POST['code'] as $key => $value) {
                $data = array(
                    'date'       => $this->input->post('date'),
                    'party_code' => $this->input->post('client_code'),
                    'chalan_no'  => $this->input->post('chalan_no'),
                    'code'       => $value,
                    'quantity'   => $_POST['quantity'][$key]
                );

                $this->action->add("chalan", $data);
            }

            $options = array(
                'title' =>"success",
                'emit'  =>"Chalan successfully saved!",
                'btn'   =>true
            );

            $msg = message('success', $options);
            $this->session->set_flashdata("confirmation", $msg);

            redirect("chalan/chalan/sigleView/".$this->input->post('chalan_no'), "refresh");
        }

        // all Product Get products table
        $this->data['product'] = $this->action->read('stock');

        // Get all Client from Parties Table
        $where = array(
            "type"   => "client",
            "trash"  => 0,
            "status" =>"active"
        );
        $this->data['AllClient'] = $this->action->read('parties',$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/chalan/nav', $this->data);
        $this->load->view('components/chalan/chalan', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function view_all($id=NULL) {
        $this->data['meta_title'] = 'Chalan';
        $this->data['active']     = 'data-target="chalan_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['resultset']  = null;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/chalan/nav', $this->data);
        $this->load->view('components/chalan/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function edit($chalanno=NULL) {
        $this->data['meta_title'] = 'chalan';
        $this->data['active']     = 'data-target="chalan_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['resultset']  = null;
        $this->data['chalanno'] = $chalanno;

        $where = array("type" => "finish_product","trash" => 0);
        $this->data['product'] = $this->action->read('materials',$where);

        $where = array('id' => $chalanno);
        $this->data['info']  = $this->action->read('chalan',$where);

        if(isset($_POST['change'])) {
            foreach ($_POST['code'] as $key => $value) {
                $where = array(
                    "chalan_no" => $chalanno,
                    "code" => $_POST['code'][$key],
                );

                $data = array('quantity'  => $_POST['quantity'][$key],'date' => $_POST['date']);

                $this->action->update("chalan", $data, $where);
            }

            $options = array(
                'title' => "Update",
                'emit'  => "Chalan successfully Update!",
                'btn'   => true
            );

            $msg = message($this->action->update("chalan", $data, $where), $options);

            $this->session->set_flashdata("confirmation", $msg);
            redirect("chalan/chalan/sigleView/" . $this->input->post('chalan_no'), "refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/chalan/nav', $this->data);
        $this->load->view('components/chalan/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function sigleView($csl) {
        $this->data['meta_title'] = 'chalan';
        $this->data['active']     = 'data-target="chalan_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $chalan = array(
            "chalan_no" => $csl,
            "trash" => 0
        );

        $this->data['info'] = $this->action->read('chalan', $chalan);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/chalan/nav', $this->data);
        $this->load->view('components/chalan/sigleView', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function delete($id=NULL){
        $where = array('chalan_no'=> $id);
        $data = array("trash" =>1);
        $options= array(
            'title' => 'delete',
            'emit'  => 'Successfully Deleted!',
            'btn'   => true
        );

       $this->data['confirmation'] = message($this->action->update('chalan', $data, $where), $options);
       $this->session->set_flashdata("confirmation",$this->data['confirmation']);
       redirect("chalan/chalan/view_all","refresh");
    }

}
