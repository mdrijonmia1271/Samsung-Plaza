<?php
class Salary extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="salary"';
        $this->data['confirmation'] = null;

        $this->data['get_data'] = $this->action->read('employee');
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/basic-salary', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function ajax_emp_info(){
        $emp_id = $this->input->post('emp_id');
        $where=array("emp_id"=>$emp_id);
        $emp_data=$this->action->read("employee",$where);
        if (count($emp_data)) {
            echo json_encode($emp_data[0]);
        }else{
            echo "empty";
        }
    }

    public function ajax_emp_salery(){
        $emp_id = $this->input->post('emp_id');
        $where=array("emp_id"=>$emp_id);
        $emp_data=$this->action->read("basic_salary",$where);
        if (count($emp_data)) {
            echo json_encode($emp_data[0]);
        }else{
            echo "empty";
        }
    }


    public function incentive($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="incentive"';
        $this->data['confirmation'] = null;

        // work with DB
        if ($this->input->post('create')) {
            $counter = 0;

            // store data into incentive table
            foreach ($_POST['name'] as $key => $value) {
                $data = array(
                    "eid"           => $this->input->post('id'),
                    "fields"        => $_POST['name'][$key],
                    "percentage"    => $_POST['percent'][$key],
                    "remarks"       => $_POST['remark'][$key]
                );

                // check the existance
                $where = array(
                    "eid"      => $this->input->post('id'),
                    "fields"   => $_POST['name'][$key]
                );

                if($this->action->exists("incentive_structure", $where)) {
                    $this->action->update("incentive_structure", $data, $where);
                } else {
                    $this->action->add("incentive_structure", $data);
                }

                if($_POST['percent'][$key] > 0) {
                    $counter += 1;
                }
            }

            // active incentive from structure table
            $where = array('eid' => $this->input->post('id'));
            if($counter > 0) {
                $data = array('incentive' => 'yes');
                $this->action->update("salary_structure", $data, $where);
            } else {
                $data = array('incentive' => 'no');
                $this->action->update("salary_structure", $data, $where);
            }

            $options = array(
                "title" => "Success",
                "emit"  => "Incentive Successfully Saved",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message('success', $options));
            redirect('salary/salary/incentive', 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/incentive', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function salary_sheet($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="sheet"';
        $this->data['confirmation'] = null;

        $this->data['salarySheet'] = $this->action->readOrderby('employee', 'emp_id', array(), 'asc');

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/salary_sheet', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


     public function bonus($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="bonus"';
        $this->data['confirmation'] = null;


        // work with DB
        if ($this->input->post('create')) {
            $counter = 0;

            // store data into deduction table
            foreach ($_POST['purpose'] as $key => $value) {
                $data = array(
                    "eid"           => $this->input->post('id'),
                    "fields"        => $_POST['purpose'][$key],
                    "percentage"    => $_POST['percent'][$key],
                    "remarks"       => $_POST['remarks'][$key]
                );

                // check the existance
                $where = array(
                    "eid"      => $this->input->post('id'),
                    "fields"   => $_POST['purpose'][$key]
                );

                if($this->action->exists("bonus_structure", $where)) {
                    $this->action->update("bonus_structure", $data, $where);
                } else {
                    $this->action->add("bonus_structure", $data);
                }

                if($_POST['percent'][$key] > 0) {
                    $counter += 1;
                }
            }

            // active deduction from structure table
            $where = array('eid' => $this->input->post('id'));
            if($counter > 0) {
                $data = array('bonus' => 'yes');
                $this->action->update("salary_structure", $data, $where);
            } else {
                $data = array('bonus' => 'no');
                $this->action->update("salary_structure", $data, $where);
            }

            $options = array(
                "title" => "Success",
                "emit"  => "Bonus Successfully Saved",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message('success', $options));
            redirect('salary/salary/bonus', 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/bonus', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function deduction($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="deduction"';
        $this->data['confirmation'] = null;

        // work with DB
        if ($this->input->post('create')) {
            $counter = 0;

            // store data into deduction table
            foreach ($_POST['name'] as $key => $value) {
                $data = array(
                    "eid"           => $this->input->post('id'),
                    "fields"        => $_POST['name'][$key],
                    "percentage"    => $_POST['percent'][$key],
                    "amount"        => $_POST['amount'][$key],
                    "remarks"       => $_POST['remark'][$key]
                );

                // check the existance
                $where = array(
                    "eid"      => $this->input->post('id'),
                    "fields"   => $_POST['name'][$key]
                );

                if($this->action->exists("deduction_structure", $where)) {
                    $this->action->update("deduction_structure", $data, $where);
                } else {
                    $this->action->add("deduction_structure", $data);
                }

                if($_POST['amount'][$key] > 0) {
                    $counter += 1;
                }
            }

            // active deduction from structure table
            $where = array('eid' => $this->input->post('id'));
            if($counter > 0) {
                $data = array('deduction' => 'yes');
                $this->action->update("salary_structure", $data, $where);
            } else {
                $data = array('deduction' => 'no');
                $this->action->update("salary_structure", $data, $where);
            }

            $options = array(
                "title" => "Success",
                "emit"  => "Deduction Successfully Saved",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message('success', $options));
            redirect('salary/salary/deduction', 'refresh');
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/deduction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }



    public function report($emit = NULL) {
        $this->data['meta_title'] = '';
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="report"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function read_salary() {
        $resultset = array();
        $salaryWhere = array();

        // receive data via javascript
        $content = file_get_contents("php://input");
        $receive = json_decode($content, true);

        if(count($receive) > 0) {
            $salaryWhere = $receive;
        }

        // get employee info
        $where = array("status" => "active");
        $employeeInfo = $this->action->read("employee", $where);

        // get data from salary record table using epmloyee info
        foreach ($employeeInfo as $key => $employee) {
            // set employee record
            $resultset[$key]['eid'] = $employee->emp_id;
            $resultset[$key]['name'] = $employee->name;
            $resultset[$key]['img'] = $employee->path;
            $resultset[$key]['post'] = $employee->designation;
            $resultset[$key]['mobile'] = $employee->mobile;

            $salaryWhere["eid"] = $employee->emp_id;
            $salaryInfo = $this->action->read("salary_records", $salaryWhere);

            if($salaryInfo != null) {
                $total = 0;

                foreach ($salaryInfo as $salary) {
                    if($salary->remarks == 'basic') {
                        $resultset[$key]['basic'] = $salary->amounts;
                    }

                    if($salary->remarks == 'deduction') {
                        $total -= $salary->amounts;
                    } else {
                        $total += $salary->amounts;
                    }

                }

                $resultset[$key]['total'] = $total;
                $resultset[$key]['status'] = 'paid';

            } else {
                $total = 0.00;

                // get salary structure
                $where = array("eid" => $employee->emp_id);
                $salaryInfo = $this->action->read("salary_structure", $where);

                if($salaryInfo != null){
                    // get basic
                    $resultset[$key]['basic'] = $salaryInfo[0]->basic;

                    // check insentive
                    if($salaryInfo[0]->incentive == "yes"){
                        $insentivesInfo = $this->action->read("incentive_structure", $where);

                        foreach ($insentivesInfo as $insentive) {
                            $total += (($resultset[$key]['basic'] * $insentive->percentage) / 100) + $resultset[$key]['basic'];
                        }
                    }

                    // check bonus
                    if($salaryInfo[0]->bonus == "yes"){
                        $bonusInfo = $this->action->read("bonus_structure", $where);
                        foreach ($bonusInfo as $bonus) {
                            $total += (($resultset[$key]['basic'] * $bonus->percentage) / 100) + $resultset[$key]['basic'];
                        }
                    }

                    // check deduction
                    if($salaryInfo[0]->deduction == "yes"){
                        $deductionInfo = $this->action->read("deduction_structure", $where);
                        foreach ($deductionInfo as $deduction) {
                            $total -= $deduction->amount;
                        }
                    }


                    $resultset[$key]['total'] = $total;
                    $resultset[$key]['status'] = 'due';
                } else {
                    $resultset[$key]['basic'] = 0.00;
                    $resultset[$key]['total'] = 0.00;
                    $resultset[$key]['status'] = 'unknown';
                }

            }
        }

        echo json_encode($resultset);
    }
}
