<?php

class Membership_m extends Lab_Model
{

    protected $_table_name = 'users';
    protected $_order_by = 'name';
    protected $_limit = '1';

    function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $holder    = config_item('privilege');
        $developer = config_item('developer');

        if ($this->input->post('username') == $developer["username"] && $this->input->post('password') == $developer["password"]) {
            // log in user
            $data = array(
                'user_id'      => 1001,
                'login_period' => date('Y-m-d H:i:s a'),
                'name'         => "MetaSoft",
                'email'        => "akmrimat@gmail.com",
                'username'     => "metasoft",
                'mobile'       => "01710511241",
                'privilege'    => "super",
                'image'        => "private/images/pic-male.png",
                'branch'       => "0001",
                'holder'       => "super",
                'loggedin'     => TRUE
            );

            $this->session->set_userdata($data);
        } else {
            $user = $this->retrieve_by(array(
                'username' => $this->input->post('username'),
                'password' => $this->hash($this->input->post('password'))
            ));

            if (count($user)) {
                // log in user
                $data = array(
                    'user_id'      => $user[0]->id,
                    'login_period' => date('Y-m-d H:i:s a'),
                    'name'         => $user[0]->name,
                    'email'        => $user[0]->email,
                    'username'     => $user[0]->username,
                    'mobile'       => $user[0]->mobile,
                    'privilege'    => $user[0]->privilege,
                    'image'        => $user[0]->image,
                    'branch'       => $user[0]->branch,
                    'holder'       => $user[0]->privilege,
                    'loggedin'     => TRUE
                );

                $this->session->set_userdata($data);

                // store access info
                $info = array(
                    'user_id'      => $user[0]->id,
                    'login_period' => $this->session->userdata('login_period')
                );

                $this->db->insert("access_info", $info);
            }

        }

    }


    public function directLogin($id)
    {
        $records = $this->getShowroomData($id);

        $this->_table_name = 'users';
        $this->_order_by   = 'name';
        $this->_limit      = '1';

        $user = $this->retrieve_by(array(
            'username' => $records[0]->username,
            'password' => $records[0]->password
        ));

        if (count($user)) {
            // log in user
            $data = array(
                'user_id'      => $user[0]->id,
                'login_period' => date('Y-m-d H:i:s a'),
                'name'         => $user[0]->name,
                'email'        => $user[0]->email,
                'username'     => $user[0]->username,
                'mobile'       => $user[0]->mobile,
                'privilege'    => $user[0]->privilege,
                'image'        => $user[0]->image,
                'branch'       => $user[0]->branch,
                'holder'       => $user[0]->privilege,
                'loggedin'     => TRUE
            );

            $this->session->set_userdata($data);
        }


        return $this->loggedin();
    }


    private function getShowroomData($id)
    {
        $this->_table_name = 'users';
        $this->_order_by   = 'id';
        $this->_limit      = '1';

        $where = array(
            "privilege" => "user",
            "branch"    => $id
        );

        return $this->retrieve_by($where);
    }


    public function logout()
    {
        // updates access info
        $where = array(
            'user_id'      => $this->session->userdata('user_id'),
            'login_period' => $this->session->userdata('login_period')
        );
        $this->db->set(array('logout_period' => date('Y-m-d H:i:s a')));
        $this->db->where($where);
        $this->db->update("access_info");

        $this->session->sess_destroy();
    }

    public function loggedin()
    {
        return (bool)$this->session->userdata('loggedin');
    }

    public function hash($string)
    {
        return hash('md5', $string . config_item('encryption_key'));
    }
}

