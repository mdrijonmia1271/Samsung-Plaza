<?php

class Employee extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');

        $this->data['godownList'] = getAllGodown();
    }

    public function index()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="employee_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[11]|is_unique[employee.mobile]');
        $this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required|max_length[11]|is_unique[employee.emp_id]');

        if ($this->input->post("add_emp")) {

            if ($this->form_validation->run() == FALSE) {
                $msg_array                  = array(
                    "title" => "Error",
                    "emit"  => validation_errors(),
                    "btn"   => true
                );
                $this->data['confirmation'] = message("warning", $msg_array);
            } else {
                //Image Upload Start here
                $photo = '';
                if ($_FILES["attachFile"]["name"] != null or $_FILES["attachFile"]["name"] != "") {

                    $config['upload_path']   = './public/employee';
                    $config['allowed_types'] = 'png|jpeg|jpg|gif';
                    $config['max_size']      = '4096';
                    $config['max_width']     = '3000'; /* max width of the image file */
                    $config['max_height']    = '3000';
                    $config['file_name']     = "employee_" . rand(1111, 99999) . "_" . $this->input->post("emp_id");
                    $config['overwrite']     = true;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload("attachFile")) {
                        $upload_data = $this->upload->data();
                        $photo       = "public/employee/" . $upload_data['file_name'];
                    }

                }


                $data = array(
                    "date"              => date("Y-m-d"),
                    "emp_id"            => $this->input->post('emp_id'),
                    "name"              => $this->input->post("full_name"),
                    "joining_date"      => $this->input->post('joining_date'),
                    "gender"            => $this->input->post("gender"),
                    "mobile"            => $this->input->post("mobile_number"),
                    "present_address"   => $this->input->post("present_address"),
                    "permanent_address" => $this->input->post("permanent_address"),
                    "designation"       => $this->input->post("designation"),
                    "path"              => $photo,
                );

                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "New Employee Successfully Saved",
                    "btn"   => true
                );

                $this->data['confirmation'] = message($this->action->add("employee", $data), $msg_array);

            }
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/employee/nav', $this->data);
        $this->load->view('components/employee/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function show_employee()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="employee_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['showrooms'] = $this->action->readGroupBy("showroom", "showroom_id", array(), "id", "asc");

        $where = array();
        if ($this->input->post('showroom')) {
            $where['showroom_id'] = $this->input->post('showroom');
        }
        $this->data['emp_info'] = $this->action->read('employee', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/employee/nav', $this->data);
        $this->load->view('components/employee/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View Employee end here------------------------------
    //----------------------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View profile start here-----------------------------
    //----------------------------------------------------------------------------------------------

    public function profile()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="employee_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['emp_info'] = $this->action->read('employee', array('id' => $this->input->get("id")));

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/employee/nav', $this->data);
        $this->load->view('components/employee/profile', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View profile end here-------------------------------
    //----------------------------------------------------------------------------------------------

    public function edit_employee()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="employee_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        //-------------------------------------------------------------------------------------------
        //-----------------------------------update employee Start here-------------------------------------
        $where                  = array("id" => $this->input->get('id'));
        $this->data['emp_info'] = $this->action->read('employee', $where);

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[11]');


        if ($this->input->post("update_emp")) {

            if ($this->form_validation->run() == FALSE) {
                $msg_array                  = array(
                    "title" => "Error",
                    "emit"  => validation_errors(),
                    "btn"   => true
                );
                $this->data['confirmation'] = message("warning", $msg_array);
            } else {
                $photo = NULL;
                //Image Upload Start here
                if ($_FILES["attachFile"]["name"] != null or $_FILES["attachFile"]["name"] != "") {

                    $config['upload_path']   = './public/employee';
                    $config['allowed_types'] = 'png|jpeg|jpg|gif';
                    $config['max_size']      = '4096';
                    $config['max_width']     = '3000'; /* max width of the image file */
                    $config['max_height']    = '3000';
                    $config['file_name']     = "employee_" . rand(1111, 99999) . "_" . $this->input->post("emp_id");
                    $config['overwrite']     = true;

                    $this->upload->initialize($config);


                    if ($this->upload->do_upload("attachFile")) {
                        $upload_data = $this->upload->data();
                        $photo       = "public/employee/" . $upload_data['file_name'];
                    }

                }
                //Image Upload End here

                if ($photo != NULL) {
                    $data = array(
                        "emp_id"            => $this->input->post('emp_id'),
                        "name"              => $this->input->post("full_name"),
                        "joining_date"      => $this->input->post('joining_date'),
                        "gender"            => $this->input->post("gender"),
                        "mobile"            => $this->input->post("mobile_number"),
                        //"email"=>$this->input->post("email"),
                        "present_address"   => $this->input->post("present_address"),
                        "permanent_address" => $this->input->post("permanent_address"),
                        "designation"       => $this->input->post("designation"),
                        "path"              => $photo,
                        "showroom_id"       => $this->data['branch']
                    );

                } else {
                    $data = array(
                        "emp_id"            => $this->input->post('emp_id'),
                        "name"              => $this->input->post("full_name"),
                        "joining_date"      => $this->input->post('joining_date'),
                        "gender"            => $this->input->post("gender"),
                        "mobile"            => $this->input->post("mobile_number"),
                        //"email"=>$this->input->post("email"),
                        "present_address"   => $this->input->post("present_address"),
                        "permanent_address" => $this->input->post("permanent_address"),
                        "designation"       => $this->input->post("designation"),
                        "showroom_id"       => $this->data['branch']
                    );
                }
                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "Employee Successfully Updated!",
                    "btn"   => true
                );

                $this->data['confirmation'] = message($this->action->update("employee", $data, $where), $msg_array);
                $this->session->set_flashdata("confirmation", $this->data['confirmation']);
                redirect("employee/employee/show_employee", "refresh");

            }
        }

        //------------------------------------Update employee End here--------------------------------------
        //---------------------------------------------------------------------------------------------


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/employee/nav', $this->data);
        $this->load->view('components/employee/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function delete($id = NULL)
    {

        $info = $this->action->read('employee', array('id' => $id));
        if ($info != NULL) {
            unlink($info[0]->path);
        }

        $options = array(
            'title' => 'delete',
            'emit'  => 'Employee Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation'] = message($this->action->deletedata('employee', array('id' => $id)), $options);
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        redirect("employee/employee/show_employee", "refresh");
    }


    public function hash($string)
    {
        return hash('md5', $string . config_item('encryption_key'));
    }

}
