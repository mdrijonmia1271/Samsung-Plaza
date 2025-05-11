<?php

class Color extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->holder();

        $this->data['meta_title'] = 'Color';
        $this->data['active']     = 'data-target="colors_menu"';
    }

    // show all data
    public function index()
    {
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['results'] = get_result('colors', ['trash' => 0]);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/color/nav', $this->data);
        $this->load->view('components/color/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    // show create form
    public function create()
    {
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/color/nav', $this->data);
        $this->load->view('components/color/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    // store data
    public function store()
    {
        if (isset($_POST['save'])) {

            $data = [
                'created' => date('Y-m-d'),
                'color'   => $this->input->post('color'),
            ];

            save_data('colors', $data);

            $msg = [
                'title' => 'success',
                'emit'  => 'Color add successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('color/color', 'refresh');
    }

    // show edit form
    public function edit($id = null)
    {
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['info'] = get_row('colors', ['id' => $id]);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/color/nav', $this->data);
        $this->load->view('components/color/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    // update data
    public function update($id = null)
    {
        if (isset($_POST['update'])) {

            $data = ['color' => $this->input->post('color')];

            save_data('colors', $data, ['id' => $id]);

            $msg = [
                'title' => 'success',
                'emit'  => 'Color update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('color/color', 'refresh');
    }

    // delete data
    public function delete($id = NULL)
    {
        if (!empty($id)) {

            save_data('colors', ['trash' => 1], ['id' => $id]);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Color delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('color/color', 'refresh');
    }

    private function holder()
    {
        if ($this->session->userdata('holder') == null) {
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
}
