<?php
class GeneralSettings extends Admin_controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'General Settings';
        $this->data['active'] = 'data-target="general-settings"';
        $this->data['subMenu'] = 'data-target=""';

		if(isset($_POST['save'])) {
			foreach ($_POST['meta'] as $key => $value) {
				$where = array(
					'meta_key' 		=> $key,
					'meta_type' 	=> 'general-settings'
				);

				$data = array(
					'meta_key' 		=> $key,
					'meta_type' 	=> 'general-settings',
					'meta_value' 	=> $value
				);

				if($this->action->exists('sitemeta', $where)) {
					$this->action->update('sitemeta', $data, $where);
				} else {
					$this->action->add('sitemeta', $data);
				}
			}

			$msg = array(
				"title" => "success",
				"emit" 	=> "Information saved successfully!",
				"btn"	=> true
			);

			$this->session->set_flashdata('confirmation', message('success', $msg));
			redirect('generalSettings', 'refresh');
		}

		$this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/general-settings', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
