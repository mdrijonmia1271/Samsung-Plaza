<?php

class Lab_Model extends CI_Model {

    protected $_table_name = '';
    protected $_order_by = 'id';
    protected $_order_type = 'asc';
    protected $_limit = '';

    function __construct() {
        parent::__construct();
    }

    public function existance($table, $where) {
        $this->db->where($where);
        $result = $this->db->get($table);

        if($result->num_rows() >= 1){
            return TRUE;
        }

        return FALSE;
    }

    public function retrieve() {
        // set order by
        if(!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by, $this->_order_type);
        }

        // check limit exists or not
        if($this->_limit != NULL){
            $this->db->limit($this->_limit);
        }

        // query
        return $this->db->get($this->_table_name)->result();
    }

    public function retrieve_by($where = array()) {
        $this->db->where($where);
        return $this->retrieve();
    }

    public function save($data, $where = NULL) {
        // insert
        if($where === NULL) {
            $this->db->insert($this->_table_name, $data);

            return 'success';
        } else {
            $this->db->set($data);
            $this->db->where($where);
            $this->db->update($this->_table_name);

            return 'success';
        }
    }

    public function delete($where = array()) {
        $this->db->where($where);
        $this->db->delete($this->_table_name);

        return 'danger';
    }

}
