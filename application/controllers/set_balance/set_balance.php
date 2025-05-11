<?php

class Set_balance extends Admin_Controller{
    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index(){
        echo "I am here";
    }
}