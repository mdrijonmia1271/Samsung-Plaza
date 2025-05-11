<?php

class Action extends Lab_Model {

    function __construct() {
        parent::__construct();
    }

    // for custom helper
    public function maxId($table) {
        $sql = "SELECT id AS maxId FROM $table ORDER BY id DESC LIMIT 1";

        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        }
        return 0;
    }

    public function max_value($table, $column, $where = array()) {
        $this->db->select_max($column);
        $this->db->where($where);

        $result = $this->db->get($table)->row();

        return $result->$column;
    }

    //For barcode
    public function read_col($table, $col = "*", $where=array(),$type='asc',$field='id'){
		$this->db->select($col);
		$this->db->where($where);
		$this->db->order_by($field,$type);
		$query=$this->db->get($table);
		return $query->result();
	}



     public function readOrderby($table, $order_by, $where=array(), $sort='asc'){
        $this->db->order_by($order_by, $sort);
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->result();
    }
    
     public function read_with_limit($table, $where = array(),$limit, $offset) {
        $query = $this->db->get_where($table,$where, $limit, $offset);
        return $query->result();
    }  


    // for custom helper
    public function forIdGenerator($table) {
        $this->_table_name = $table;
        $this->_order_type = 'desc';
        $this->_limit = '1';

        return $this->retrieve();
    }

    // retrieve unic value from database
    public function read_distinct($table, $where = array(), $column) {
        $this->db->distinct();
        $this->db->select($column);
        $this->db->where($where);

        return $this->db->get($table)->result();
    }
    // check existance
    public function exists($table, $where) {
        return $this->existance($table, $where);
    }

    // save into database
    public function add($table, $data) {
        $this->_table_name = $table;
        return $this->save($data);
    }

	// retrieve last inserted id from database
	public function addAndGetId($table, $data) {
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

    // update into database
    public function update($table, $data, $where) {
        $this->_table_name = $table;
        return $this->save($data, $where);
    }

    // retrieve from database
    public function read($table, $where = array(), $by="asc") {
        $this->_table_name = $table;
        $this->_order_type = $by;

        if(count($where) > 0){
            return $this->retrieve_by($where);
        } else {
            return $this->retrieve();
        }
    }


    // like Query      
     public function readLikeAfter($table,$match_column,$matchElement){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->like($match_column,$matchElement, 'after');
        $query = $this->db->get();
        
        return $query->result();
    }


    public function read_limit($table, $where = array(), $by="asc",$limit) {
        $this->_table_name = $table;
        $this->_order_type = $by;
        if (isset($limit)) {
            $this->_limit = $limit;
        }

        if(count($where) > 0){
            return $this->retrieve_by($where);
        } else {
            return $this->retrieve();
        }
    }

    public function readGroupBy($table, $groupBy, $where=array(), $orderBy="id", $sort="desc"){
        $this->db->select('*');
        $this->db->group_by($groupBy);
        $this->db->order_by($orderBy, $sort);
        $this->db->where($where);
        $result = $this->db->get($table);

        return $result->result();
    }

    public function read_sum($table, $column, $where=array()){
        $this->db->select_sum($column);
        $this->db->where($where);
        $result = $this->db->get($table);

        return $result->result();
    }

    public function sum($table, $column, $where=array()){
        $this->db->select("SUM($column) AS amount", FALSE);
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->result();
    }

    public function sum_groupby($table, $column, $groupIn, $where=array()){
        $this->db->select("SUM($column) AS amount", FALSE);
        $this->db->group_by($groupIn);
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->result();
    }

    public function group_sum($table, $column1,$column2, $where=array()){
        $this->db->select("SUM($column1*$column2) AS total", FALSE);
        $this->db->group_by("product_code");
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->result();
    }


	// retrieve from database using two table
    public function joinAndRead($from, $join, $joinCond, $where=array(), $where2 = array()){
        $this->db->select('*');
        $this->db->from($from);
        $this->db->join($join, $joinCond);
        $this->db->where($where);
        $this->db->where($where2);

        $query = $this->db->get();

		return $query->result();
    }

    // retrieve from database using two table
    public function joinAndReadPurchase($from, $join, $joinCond, $where=array(),$orderbye="id", $ordertype="asc"){
        $this->db->select('*');
        $this->db->from($from);
        $this->db->join($join, $joinCond);
        $this->db->order_by($orderbye, $ordertype);
        $this->db->where($where);

        $query = $this->db->get();

        return $query->result();
    }

    // retrieve from database using two table
    public function joinAndReadGroupby($from, $join, $joinCond, $where=array(), $groupby, $where2=array()){
        $this->db->select('*');
        $this->db->from($from);
        $this->db->join($join, $joinCond);
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->group_by($groupby); // $groupby = 'table-name.column-name'

        $query = $this->db->get();

        return $query->result();
    }

    // retrieve from database using multiple table
    public function multipleJoinAndRead($from, $details=array(), $where=array()){
        $this->db->select('*');
        $this->db->from($from);

        // check type exists or not
        foreach ($details as $key => $val) {
            if(array_key_exists("type", $val)){
                $this->db->join($key, $val["condition"], $val["type"]);
            } else {
                $this->db->join($key, $val["condition"]);
            }
        }

        // appling condition
        $this->db->where($where);
        // get the result set
        $query = $this->db->get();


        // return the set
        return $query->result();
    }

    public function searchTransaction($table) {
        $bank= $this->input->post('bank_name');
        $account= $this->input->post('account_no');
        $fromDate= $this->input->post('date_from');
        $toDate= $this->input->post('date_to');

        $sql = "SELECT * FROM $table WHERE bank='$bank' AND account_number='$account' AND transaction_date BETWEEN   '$fromDate' AND  '$toDate' ";

		$query = $this->db->query($sql);
		return $query->result();
    }

	public function searchCost($table){
        $fromDate= $this->input->post('date_from');
        $toDate= $this->input->post('date_to');

        $sql = "SELECT * FROM $table WHERE  datetime BETWEEN   '$fromDate' AND  '$toDate' order by datetime asc";

		$query = $this->db->query($sql);
		return $query->result();
    }
    // Get Previous Balance For company
    public function previous_balance($from,$code){
        $sql = "SELECT * FROM `partytransaction` where `party_code`='$code' and `transaction_at` = (SELECT max(`transaction_at`) FROM `partytransaction` where `transaction_at` < '$from' and `party_code`='$code') order by `id` desc limit 1";
        $query = $this->db->query($sql);

        return $query->result();
    }

    // Get Previous Balance For client
    public function previous_balance_client($from,$code,$brand=null){
        $brand_filter="";
        if($brand!=null && $brand!=""){
            $brand_filter = " and party_brand='$brand'";
        }

        $sql = "SELECT * FROM `partytransaction` where `party_code`='$code'".$brand_filter." and `transaction_at` = (SELECT max(`transaction_at`) FROM `partytransaction` where `transaction_at` < '$from' and `party_code`='$code'".$brand_filter.") order by `id` desc limit 1";
        $query = $this->db->query($sql);

        return $query->result();
    }

    // retrieve from database
    public function showbyClass($table, $where = array()){
        $this->_table_name = $table;
        return $this->retrieve_by($where);
    }

	// retrieve from database
    public function show($table){
        $this->_table_name = $table;
		$this->_limit = '10';
        $this->_order_type = 'desc';
        return $this->retrieve();
    }

	// retrieve from database
    public function showbyDesc($table){
        $this->_table_name = $table;
        $this->_order_type = 'desc';
        return $this->retrieve();
    }

    // delete information from table
    public function deleteData($table, $where) {
        $this->_table_name = $table;

        if($this->delete($where)){
            return 'danger';
        }
    }

	public function getAllItems($table) {
        return $this->db->distinct('account_number')->from($table)->get()->result();
    }// for distinct value


    public function retrieve_cond($table, $where = array(), $order = 'asc') {
        $this->db->where($where);
        $this->db->order_by("id", $order);
        $query = $this->db->get($table);

        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
    }

	// retrieve from database
    public function readDistinct($table, $field_name){
        $sql = "select distinct $field_name from $table";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function read_leftJoin($leftTable,$leftField,$rightTable,$rightField){
        $sql= "select * from $leftTable LEFT JOIN users ON $leftTable.$leftField=$rightTable.$rightField";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function check_existance($table, $where) {
        return $this->existance($table, $where);
    }

    public function update_profile($info, $where) {
        $this->_table_name = 'users';
        return $this->save($info, $where);
    }

    public function sms_between($table,$fromDate,$toDate) {
        $sql = "SELECT * FROM $table WHERE delivery_date BETWEEN '$fromDate' AND  '$toDate'";
        $query = $this->db->query($sql);
        return $query->result();
    }

        // retrieve from database
    public function attendance_DISTINCT($session,$class,$shift,$section,$group){
        $sql = "SELECT DISTINCT attendance_roll,attendance_class,attendance_section,attendance_session,attendance_group,attendance_shift FROM attendance where `attendance_session`='$session' and `attendance_class`='$class' and `attendance_shift`='$shift' and `attendance_section`='$section' and `attendance_group`='$group' ";
        $query = $this->db->query($sql);
        return $query->result();
    }
/*
    public function read_leftJoin(){
        $sql= "select * from employee LEFT JOIN users ON employee.employee_mobile=users.mobile where employee_mobile='01735189237' ";
        $query=$this->db->query($sql);
        return $query->result();
    }*/

  public function readPagination($table,$per_page,$offset,$order="asc")
    {
        $dateM=explode("-",date('Y-m-d'));
        $val=$dateM[2]-1;
        if(strlen($val) == 1){
          $date_cond = "0".$val;
        }else{
         $date_cond = $val;
        }
        $this->db->order_by('id',$order);
        $this->db->where("installment_type","monthly");
        $this->db->where("installment_date",$date_cond);
        $this->db->where("status","opened");
        $query=$this->db->get($table,$per_page,$offset);
        if($query->num_rows()>0){
          return $query->result();
        }else{
          return FALSE;
        }

    }

    public function read_absent_client($date, $showroom){
        // $sql = "SELECT party_code FROM `saprecords` WHERE party_code in (select code from`parties` where type='client') and sap_at < '$date' and showroom_id = '$showroom' group by party_code";

        $sql = "SELECT party_code FROM `saprecords` WHERE party_code in (select code from `parties` where type='client') and sap_at < '$date' and showroom_id = '$showroom' and party_code not in (select party_code from saprecords where sap_at >= '$date') group by party_code";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function get_due(){
        $sql = "SELECT sum(`balance`) as `balance` FROM `partybalance`,`parties` WHERE `parties`.`type`='client' and `partybalance`.`balance`>=0";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function get_max_value($table,$column,$length){
        $sql = "SELECT max(code) as last_code FROM $table WHERE length($column)='$length' " ;
        $query = $this->db->query($sql);
        return $query->result();
    }

    //Query to get STOCK (ROW MATS) in dashboard

    public function get_stock($type){
        $col = "";
        if($type=="raw"){
            $col = 'purchase_price';
        }else{
            $col = 'sell_price';
        }

        $sql = "SELECT sum(`quantity`*`$col`) AS stock_price FROM `stock` WHERE `type` = '$type'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    // retrieve one column by desc
    public function readSingle($table, $field_name){
        $sql = "SELECT $field_name FROM $table ORDER BY `id` DESC limit 1";
        $query = $this->db->query($sql);
        return $query->result();
    }



    //get irregular users from registration
    public function irregular_users($table){

        $sql = " SELECT * from `registration` WHERE `id` not IN (SELECT distinct `user_id` FROM `access_info` WHERE date(`login_period`)>='2017-12-24' AND date(`login_period`)<= '2017-12-24')";
    

        $query = $this->db->query($sql);
        return $query->result();

    }
    
    /*public function CommissionUsers(){
        
        $sql = " SELECT `voucher_no` FROM `saprecords` WHERE `total_discount` = 0 ";
        $query = $this->db->query($sql);
        return $query->result();
    }*/
    
    public function readMulti($table1,$table2){
        $sql = "SELECT * FROM $table1,$table2";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    
}
