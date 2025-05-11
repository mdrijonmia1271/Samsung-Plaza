<?php

class BankInfoValidation extends Admin_Controller {

    function __construct() {
        parent::__construct();
        // account holder restriction
        $this->holder();
        // set meta title
        $this->data['meta_title'] = 'bank';
        // load library
        $this->load->library('upload');
        // load model
        $this->load->model('action');
    }
    
public function index()
       
     	   {		   
			 
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('holder', 'Account Holder Name', 'trim|required|max_length[100]|xss_clean');
				$this->form_validation->set_rules('account_no', 'Account Number', 'trim|required|is_unique[bank_account.account_number]|numeric|max_length[15]|xss_clean');
				$this->form_validation->set_rules('balance', 'Balance', 'trim|required|numeric|xss_clean');
									
				if($this->form_validation->run() == FALSE)
					{
						// call form validation error
						$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
					} 
				else 
				   {					
						
						$info = array(
							'datetime' => $this->input->post('date'),
							'bank_name' => $this->input->post('bank_name'),
							'holder_name' => $this->input->post('holder'),						
							'account_number' => $this->input->post('account_no'),
							'pre_balance' => $this->input->post('balance')				
								
							
						);
						
						$this->data['confirmation'] = message($this->action->add('bank_account', $info));
				   }
				
				$this->session->set_flashdata('confirmation', $this->data['confirmation']);
				redirect('bank/bankInfoView', 'refresh');
				
           }
		   
public function transaction()
       
	   {		   
		$debit=0;
		$credit=0;
		$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('account_no', 'Account Number', 'trim|required|numeric|max_length[15]|xss_clean');
		$this->form_validation->set_rules('transaction_type', 'Transaction Type','trim|required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric|max_length[50]|xss_clean');
		$this->form_validation->set_rules('transaction', 'Transaction By', 'trim|required|max_length[100]|xss_clean');					
		if($this->form_validation->run() == FALSE)
			{
				// call form validation error
				$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
			} 
		else 
		   {					
				
				if($this->input->post('transaction_type')=='t1')
					{
						$debit=$this->input->post('amount');
					}
				if($this->input->post('transaction_type')=='t2')
					{
					   $credit=$this->input->post('amount');	
					}
				
				$info = array(
					'datetime' => $this->input->post('date'),
					'bank_name' => $this->input->post('bank_name'),
					'account_number' => $this->input->post('account_no'),
					'transaction_type' => $this->input->post('transaction_type'),
					'debit'=>$debit,
					'credit'=>$credit,					
					'transaction_by' => $this->input->post('transaction')				
						
					
				);
				
				$this->data['confirmation'] = message($this->action->add('transaction', $info));
		   }
		
		$this->session->set_flashdata('confirmation', $this->data['confirmation']);
		redirect('bank/bankInfoView/transaction', 'refresh');
			
	   }
	   
	   
	   public function updateTransaction()
       
	   {		   
		$debit=0;
		$credit=0;
		$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('account_no', 'Account Number', 'trim|required|numeric|max_length[15]|xss_clean');
		$this->form_validation->set_rules('transaction_type', 'Transaction Type','trim|required|xss_clean');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric|max_length[50]|xss_clean');
		$this->form_validation->set_rules('transaction', 'Transaction By', 'trim|required|max_length[100]|xss_clean');					
		if($this->form_validation->run() == FALSE)
			{
				// call form validation error
				$this->data['confirmation'] = message('warning', validation_errors('<p>', '</p>'));
			} 
		else 
		   {					
				
				if($this->input->post('transaction_type')=='t1')
					{
						$debit=$this->input->post('amount');
					}
				if($this->input->post('transaction_type')=='t2')
					{
					   $credit=$this->input->post('amount');	
					}
				
				$info = array(
					'datetime' => $this->input->post('date'),
					'bank_name' => $this->input->post('bank_name'),
					'account_number' => $this->input->post('account_no'),
					'transaction_type' => $this->input->post('transaction_type'),
					'debit'=>$debit,
					'credit'=>$credit,					
					'transaction_by' => $this->input->post('transaction')				
						
					
				);
				
				$this->data['confirmation'] = message($this->action->update('transaction', $info,array('id'=>$this->input->post('id'))));
		   }
		
		$this->session->set_flashdata('confirmation', $this->data['confirmation']);
		redirect('bank/bankInfoView/allTransaction', 'refresh');
			
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

