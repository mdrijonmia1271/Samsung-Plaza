<?php

class Employee_validation extends Admin_Controller {

    function __construct()
	{
        parent::__construct();
        // account holder restriction
        $this->holder();
        // set meta title
        $this->data['meta_title'] = 'employee';
        // load library
        $this->load->library('upload');
        // load model
        $this->load->model('action');
    }


public function index()
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|is_unique[employee.mobile]|max_length[11]|xss_clean');
        $this->form_validation->set_rules('present_address', 'Present address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('permanent_address', 'Permanent address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('type', 'Employee Type', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|max_length[100]|xss_clean');

		if($this->form_validation->run() == FALSE){
				// call form validation error
				$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
		}else{

          // set img upload condition
            $config['upload_path']      = './public/upload/employee/';
            $config['allowed_types']    = 'jpg|jpeg|png|bmp';
            $config['max_size']         = '2048';
            $config['file_name']        = $this->input->post('type')."_".rand(1000,99999);
            $config['overwrite']        = true;

            $this->upload->initialize($config);
            $this->form_validation->set_rules('image', 'File', 'callback_handle_upload');

            if ($this->form_validation->run() == FALSE)
				{
					// call form validation error
					$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
				}

			else
				 {
					$upload_data = $this->upload->data();
					$file =$upload_data['file_name'];
                    if($this->input->post('type')=='teacher')
                    {
                        $data = array(
                            'joining' => $this->input->post('joining_date'),
                            'name' => $this->input->post('full_name'),
                            'gender' => $this->input->post('gender'),
                            'mobile' => $this->input->post('mobile'),
                            'present_address' => $this->input->post('present_address'),
                            'permanent_address' => $this->input->post('permanent_address'),
                            'type' => $this->input->post('type'),
                            'designation' => $this->input->post('designation_teacher'),
                            'username'=>$this->input->post('username'),
                            'password'=>$this->input->post('password'),
                            'salary' => $this->input->post('salary'),
                            'photo' => $file,
                            'subject' => $this->input->post('subject'),
                            'status' => $this->input->post('status')
                        );
                    }
                    else
                    {
                        $data = array(
                        'joining' => $this->input->post('joining_date'),
                        'name' => $this->input->post('full_name'),
                        'gender' => $this->input->post('gender'),
                        'mobile' => $this->input->post('mobile'),
                        'present_address' => $this->input->post('present_address'),
                        'permanent_address' => $this->input->post('permanent_address'),
                        'type' => $this->input->post('type'),
                        'designation' => $this->input->post('designation_staff'),
                        'salary' => $this->input->post('salary'),
                        'photo' => $file,
                        'status' => $this->input->post('status')
                        );
                    }


				    $this->data['confirmation'] = message($this->action->add('employee', $data));
			    }
		   }
		$this->session->set_flashdata('confirmation', $this->data['confirmation']);
	  redirect('employee/employee_view', 'refresh');

}

public function updateData()
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('present_address', 'Present address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('permanent_address', 'Permanent address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|max_length[100]|xss_clean');

	if($this->form_validation->run() == FALSE)
	{
		// call form validation error
		$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
	}
	else
	      {
		    // set img upload condition
	            $config['upload_path']      = './public/upload/employee/';
	            $config['allowed_types']    = 'jpg|jpeg|png|bmp';
	            $config['max_size']         = '2048';
	            $config['file_name']        = $this->input->post('photo_name');
	            $config['overwrite']        = true;

		$this->upload->initialize($config);
		$this->form_validation->set_rules('image', 'Image', 'callback_handle_upload');

		if ($this->form_validation->run() == FALSE)
		{
		// call form validation error
		$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
		}
		else
		{
		$upload_data = $this->upload->data();
		$file = $upload_data['file_name'];
		}


		if($_FILES['image']['tmp_name']!=NULL)
		{

		  if($this->input->post('type')=='teacher')
                    {
                        $data = array(
                            'joining' => $this->input->post('joining_date'),
                            'name' => $this->input->post('full_name'),
                            'gender' => $this->input->post('gender'),
                            'mobile' => $this->input->post('mobile'),
                            'present_address' => $this->input->post('present_address'),
                            'permanent_address' => $this->input->post('permanent_address'),
                            'designation' => $this->input->post('designation_teacher'),
                            'salary' => $this->input->post('salary'),
                            'photo' => $file,
                            'subject' => $this->input->post('subject'),
                            'status' => $this->input->post('status')
                        );
                    }
                    else
                    {
                        $data = array(
                        'joining' => $this->input->post('joining_date'),
                        'name' => $this->input->post('full_name'),
                        'gender' => $this->input->post('gender'),
                        'mobile' => $this->input->post('mobile'),
                        'present_address' => $this->input->post('present_address'),
                        'permanent_address' => $this->input->post('permanent_address'),
                        'type' => $this->input->post('type'),
                        'designation' => $this->input->post('designation_staff'),
                        'salary' => $this->input->post('salary'),
                        'photo' => $file,
                        'status' => $this->input->post('status')
                        );
                    }

		}
		else
		{
		  if($this->input->post('type')=='teacher')
                    {
                        $data = array(
                            'joining' => $this->input->post('joining_date'),
                            'name' => $this->input->post('full_name'),
                            'gender' => $this->input->post('gender'),
                            'mobile' => $this->input->post('mobile'),
                            'present_address' => $this->input->post('present_address'),
                            'permanent_address' => $this->input->post('permanent_address'),
                            'designation' => $this->input->post('designation_teacher'),
                            'salary' => $this->input->post('salary'),
                            'subject' => $this->input->post('subject'),
                            'status' => $this->input->post('status')
                        );
                    }
                    else
                    {
                        $data = array(
                        'joining' => $this->input->post('joining_date'),
                        'name' => $this->input->post('full_name'),
                        'gender' => $this->input->post('gender'),
                        'mobile' => $this->input->post('mobile'),
                        'present_address' => $this->input->post('present_address'),
                        'permanent_address' => $this->input->post('permanent_address'),
                        'designation' => $this->input->post('designation_staff'),
                        'salary' => $this->input->post('salary'),
                        'status' => $this->input->post('status')
                        );
                    }
		}

	$this->data['confirmation'] = message($this->action->update('employee', $data, array('id'=>$this->input->post('id'),'type'=>$this->input->post('type'))));

	    }

	$this->session->set_flashdata('confirmation', $this->data['confirmation']);
	redirect('employee/employee_view/show_employee','refresh');



}

public function update_data() {
        $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('mobile', 'Mobile number', 'trim|required|max_length[15]|xss_clean');
        $this->form_validation->set_rules('present_address', 'Present address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('permanent_address', 'Permanent address', 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|max_length[10]|xss_clean');

        if($this->form_validation->run() == FALSE) { // not valid
            // call form validation error
            echo message('warning', validation_errors('<p>', '</p>'));
        } else {
            $update = array(
                'name' => $this->input->post('full_name'),
                'mobile' => $this->input->post('mobile'),
                'present_address' => $this->input->post('present_address'),
                'permanent_address' => $this->input->post('permanent_address'),
                'designation' => $this->input->post('designation'),
                'salary' => $this->input->post('salary'),
                'status' => $this->input->post('status')
            );

            $confirm = $this->action->update('employee', $update, array('id' => $this->input->post('field_id')));
            echo message($confirm);
        }
    }

public function salary_update() {
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required|max_length[10]|xss_clean');
        $this->form_validation->set_rules('bonus', 'Bonus', 'trim|numeric|max_length[10]|xss_clean');
         $this->form_validation->set_rules('year', 'Year', 'trim|required|xss_clean');
          $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');

        if($this->form_validation->run() == FALSE) { // not valid
            // call form validation error
            echo message('warning', validation_errors('<p>', '</p>'));
        } else {
            $cond = array(
                'employee_id' => $this->input->post('employee_id'),
                'year' => $this->input->post('year'), // Current Year
                'month' => $this->input->post('month') //current month
            );
            $exists = $this->action->exists('salary', $cond);

            if($exists){
                // take no action
                echo message('warning', '<p>This Monthly Payment already exists</p>');
            } else {

               $ad=$this->input->post('advance');
               $ad_payment=$this->input->post('advanced_payment');

               $insert = array(
                    'date' => date('Y-m-d'),
                    'employee_id' => $this->input->post('employee_id'),
                    'mobile' => $this->input->post('mobile'),
                    'year' => $this->input->post('year'),
                    'month' => $this->input->post('month'),
                    'salary' => $this->input->post('salary'),
                    'advanced' =>$this->input->post('salary_advanced'),
                    'bonus' => $this->input->post('bonus'),
                    'status' => 1
                );
                $confirm = $this->action->add('salary', $insert);
                if( $ad_payment != NULL)
                {
                  if($ad>= $ad_payment)
                  {
	                 $less_advance=($ad- $ad_payment);
	                 $cond=array( 'employee_id' => $this->input->post('employee_id'),  'month' => date('m'));
	                 $data=array('advanced'=> $less_advance);
	                 $this->action->update('salary', $data,$cond);

                  }

                }
                echo message($confirm);

            }
        }
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
            $this->form_validation->set_message('handle_upload', "You must upload an valid file!");
            return false;
        }
    }



   private function holder() {
		$holder = config_item('privilege');

        if(!(in_array($this->session->userdata('holder'), $holder)))
		{
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
