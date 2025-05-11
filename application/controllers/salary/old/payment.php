<?php
class Payment extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title'] = 'Pay Roll';
        $this->data['confirmation'] = null;
        $this->data['active'] = 'data-target="salary_menu"';
    }

    public function index($emit = NULL) {
        $this->data['subMenu'] = 'data-target="payment"';

        // Save Data
        if (isset($_POST['create'])) {
            // save salary
            foreach ($_POST['fields_name'] as $key => $value) {
                $data = array(
                    "date"      => $_POST['payment_date'],
                    "eid"       => $this->input->post('id'),
                    "fields"    => $_POST['fields_name'][$key],
                    "amounts"   => $_POST['fields_value'][$key],
                    "remarks"   => $_POST['type'][$key]
                );

                $this->action->add('salary_records', $data);
            }

            $options = array(
                "title" => "Success",
                "emit"  => "Data Successfully Saved",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message("success", $options));
            redirect('salary/payment', 'refresh');
        }


        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/payment', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function all_payment($emit = NULL) {
        $this->data['subMenu'] = 'data-target="all_payment"';

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/all-payment', $this->data);
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
        $where = array("employee_status" => "1");
        $employeeInfo = $this->action->read("employee", $where);

        // get data from salary record table using epmloyee info
        foreach ($employeeInfo as $key => $employee) {
            // set employee record
            $resultset[$key]['eid']    = $employee->employee_emp_id;
            $resultset[$key]['name']   = $employee->employee_name;
            $resultset[$key]['img']    = $employee->employee_photo;
            $resultset[$key]['post']   = $employee->employee_designation;
            $resultset[$key]['mobile'] = $employee->employee_mobile;

            $salaryWhere["eid"] = $employee->employee_emp_id;
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
                $where = array("eid" => $employee->employee_emp_id);
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


    public function payment_view($emit = NULL) {
        $this->data['active'] = 'data-target="salary_menu"';
        $this->data['subMenu'] = 'data-target="report"';
        $this->data['confirmation'] = null;
        $this->data['result'] = array();

        // get employee info
        $where = array("employee_emp_id" => $this->input->get('id'));
        $employees = $this->action->read("employee", $where);

        $this->data['result']['eid']         = $employees[0]->employee_emp_id;
        $this->data['result']['name']        = $employees[0]->employee_name;
        $this->data['result']['img']         = $employees[0]->employee_photo;
        $this->data['result']['post']        = $employees[0]->employee_designation;
        $this->data['result']['joining']     = $employees[0]->employee_joining;
        $this->data['result']['present']     = $employees[0]->employee_present_address;
        $this->data['result']['permanent']   = $employees[0]->employee_permanent_address;
        $this->data['result']['gender']      = $employees[0]->employee_gender;
        $this->data['result']['status']      = $employees[0]->employee_status;
        $this->data['result']['mobile']      = $employees[0]->employee_mobile;
        $this->data['result']['salary']      = array();

        // get salary record
        $where = array("eid" => $this->input->get('id'));
        $info = $this->action->readGroupBy("salary_records", "date", $where);

        if($info != null) {
            foreach ($info as $key => $row) {
                $date       = $row->date;
                $basic      = 0;
                $insentive  = 0;
                $bonus      = 0;
                $deduction  = 0;

                $where = array(
                    "date"  => $row->date,
                    "eid"   => $this->input->get('id')
                );

                $info = $this->action->read("salary_records", $where);

                foreach ($info as $row) {
                    if($row->remarks == 'basic') {
                        $basic = $row->amounts;
                    }

                    if($row->remarks == 'insentive') {
                        $insentive += $row->amounts;
                    }

                    if($row->remarks == 'bonus') {
                        $bonus += $row->amounts;
                    }

                    if($row->remarks == 'deduction') {
                        $deduction += $row->amounts;
                    }
                }

                $total = ($basic + $insentive + $bonus) - $deduction;

                $this->data['result']['salary'][] = array(
                    'date'      => $date,
                    'basic'     => $basic,
                    'insentive' => $insentive,
                    'bonus'     => $bonus,
                    'deduction' => $deduction,
                    'total'     => $total
                );
            }
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/payment-view', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
