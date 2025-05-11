<?php

class Payment extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title']   = 'Pay Roll';
        $this->data['confirmation'] = null;
        $this->data['active']       = 'data-target="salary_menu"';
    }

    public function index($emit = NULL)
    {
        $this->data['employee'] = $this->data['bonus'] = NULL;
        $this->data['subMenu']  = 'data-target="payment"';

        // Save Data
        if (isset($_POST['show'])) {
            $year  = $_POST['year'];
            $month = $_POST['month'];
        } else {
            $year  = date('Y');
            $month = date('m');
        }

        $payment_date = (date('Y-m-t', strtotime(($year . '-' . $month))));

        $this->data['result'] = custom_query("SELECT employee.emp_id, employee.name, employee.mobile, employee.designation, employee.path, salary.adjust_amount, employee.basic_salary, bonus.bonus, overtime.overtime, salary_records.previous_paid, advanced_payment.advance_paid FROM( SELECT id, emp_id, name, mobile, path, designation, employee_salary as basic_salary FROM employee WHERE status='active')employee LEFT JOIN ( SELECT emp_id, adjust_amount FROM salary WHERE MONTH(payment_date)=MONTH(DATE_ADD('$payment_date',INTERVAL -1 MONTH)) AND trash=0 )salary ON employee.emp_id=salary.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) as previous_paid FROM salary_records WHERE YEAR(payment_date)='$year' AND MONTH(payment_date)='$month' AND trash=0 GROUP BY emp_id )salary_records ON employee.emp_id=salary_records.emp_id LEFT JOIN ( SELECT emp_id, bonus FROM bonus WHERE YEAR(bonus_date)='$year' AND MONTH(bonus_date)='$month' AND trash=0 )bonus ON employee.emp_id=bonus.emp_id LEFT JOIN ( SELECT emp_id, SUM(TIMESTAMPDIFF(hour, start_time, end_time) * hourly_rate) as overtime FROM overtime WHERE YEAR(date)='$year' AND MONTH(date)='$month' AND trash=0 GROUP BY emp_id ) overtime ON employee.emp_id=overtime.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) as advance_paid FROM advanced_payment WHERE YEAR(payment_date)='$year' AND MONTH(payment_date)='$month' AND trash=0 GROUP BY emp_id )advanced_payment ON employee.emp_id=advanced_payment.emp_id ORDER BY emp_id ASC");


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/payment', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store_payment()
    {

        $status = $msg = null;

        foreach ($_POST['id'] as $key) {

            $recordData = [
                "created"      => $_POST['created'],
                "payment_date" => $_POST['payment_date'],
                "emp_id"       => $_POST['emp_id'][$key],
                "amount"       => $_POST['paid'][$key],
                "remarks"      => "Salary Paid"
            ];

            save_data('salary_records', $recordData);

            // save salary data
            $salaryData = [
                "created"       => $_POST['created'],
                "payment_date"  => $_POST['payment_date'],
                "emp_id"        => $_POST['emp_id'][$key],
                "total_salary"  => $_POST['total_salary'][$key],
                "adjust_amount" => $_POST['total_salary'][$key] - ($_POST['deduction'][$key] + $_POST['paid'][$key])
            ];

            $where = [
                "payment_date" => $_POST['payment_date'],
                "emp_id"       => $_POST['emp_id'][$key],
                "trash"        => 0
            ];

            if (check_exists("salary", $where)) {
                save_data('salary', $salaryData, $where);
            } else {
                save_data('salary', $salaryData);
            }

            $msg    = array(
                "title" => "Success",
                "emit"  => "Payment Successfully Paid",
                "btn"   => true
            );
            $status = 'success';


            //Sending SMS Start
            $content = "Dear Employee, Salary Tk - " . $_POST['paid'][$key] . " has been given. Regards, Charu Press.";

            $num = $_POST["mobile"][$key];

            $message = send_sms($num, $content);
            if ($message) {
                $insert = array(
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'mobile'           => $num,
                    'message'          => $content,
                    'total_characters' => strlen($content),
                    'total_messages'   => message_length(strlen($content)),
                    'delivery_report'  => $message
                );
                save_data('sms_record', $insert);
            }
            //Sending SMS End
        }

        if (!empty($msg)) {
            $this->session->set_flashdata('confirmation', message('success', $msg));
        }
        redirect('salary/payment', 'refresh');

    }

    public function all_payment()
    {
        $this->data['subMenu']  = 'data-target="all_payment"';
        $this->data['employee'] = $this->data['advanced'] = $this->data['salary'] = NULL;

        $this_month = date('Y-m');
        $this_full_month = date('Y-m-t');
        $adjust_amount = true;
        $e2x = $this->employee_to_x($this_month, $adjust_amount);
        // dd($e2x);
        $this->data['employee_history'] = $e2x;
        $this->data['employee'] = get_result("employee", ["status" => "active"], ['emp_id', 'name'], '', "id", "asc");

        $bonus = [];
        $this->data['bonus'] = get_result("bonus", ["trash" => 0, 'bonus_date' => $this_full_month]);
        foreach ($this->data['bonus'] as $value) {
            $bonus[$value->emp_id] = $value;
        }
        $this->data['bonus'] = $bonus;

        // dd($bonus);

        $where = ['trash' => 0];

        if (isset($_POST['show'])) {
            foreach ($_POST['search'] as $key => $value) {
                if (!empty($value)) {
                    $where[$key] = $value;
                }
            }

            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value) && $key == "from") {
                    $where['created >='] = $value;
                }

                if (!empty($value) && $key == "to") {
                    $where['created <='] = $value;
                }
            }

            $this->data['advanced'] = get_result("advanced_payment", $where, '', '', 'id', 'desc');
            $this->data['salary']   = get_result("salary_records", $where, 'created, payment_date, SUM(amount) AS amount', ['emp_id', 'payment_date'], 'id', 'desc');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/all-payment', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function delete_payment($d=NULL, $i=NULL)
    {
        $this->data['confirmation'] = null;

        $emp_id = get_decode($_GET['i'],'urldecode');
        $date   = date('Y-m-t', strtotime(get_decode($_GET['d'],'urldecode')));
        // dd($date);
        $data1   = [
            'trash'     => 1
        ];
        $where  = [
            'emp_id'        => $emp_id,
            'payment_date'  => $date,
            'trash'         => 0
        ];

        save_data('salary_records', $data1, $where);
        save_data('salary', $data1, $where);

        $msg    = array(
            "title" => "Success",
            "emit"  => "Payment Successfully Deleted",
            "btn"   => true
        );
        $status = 'success';


        if (!empty($msg)) {
            $this->session->set_flashdata('confirmation', message($status, $msg));
        }
        redirect('salary/payment/all_payment', 'refresh');
    }

    public function read_salary()
    {
        $resultset   = array();
        $salaryWhere = array();

        // receive data via javascript
        $content = file_get_contents("php://input");
        $receive = json_decode($content, true);

        if (count($receive) > 0) {
            $salaryWhere = $receive;
        }

        // get employee info
        $where        = array("status" => "active");
        $employeeInfo = $this->action->read("employee", $where);

        // get data from salary record table using epmloyee info
        foreach ($employeeInfo as $key => $employee) {
            // set employee record
            $resultset[$key]['eid']    = $employee->emp_id;
            $resultset[$key]['name']   = $employee->name;
            $resultset[$key]['img']    = $employee->path;
            $resultset[$key]['post']   = $employee->designation;
            $resultset[$key]['mobile'] = $employee->mobile;

            $salaryWhere["eid"] = $employee->emp_id;
            $salaryInfo         = $this->action->read("salary_records", $salaryWhere);


            if ($salaryInfo != null) {
                $total = 0;

                foreach ($salaryInfo as $salary) {
                    if ($salary->remarks == 'basic') {
                        $resultset[$key]['basic'] = $salary->amounts;
                    }

                    if ($salary->remarks == 'deduction') {
                        $total -= $salary->amounts;
                    } else {
                        $total += $salary->amounts;
                    }

                }

                $resultset[$key]['total']  = $total;
                $resultset[$key]['status'] = 'paid';

            } else {
                $total = 0.00;

                // get salary structure
                $where      = array("eid" => $employee->emp_id);
                $salaryInfo = $this->action->read("salary_structure", $where);

                if ($salaryInfo != null) {
                    // get basic
                    $resultset[$key]['basic'] = $salaryInfo[0]->basic;

                    // check insentive
                    if ($salaryInfo[0]->incentive == "yes") {
                        $insentivesInfo = $this->action->read("incentive_structure", $where);

                        foreach ($insentivesInfo as $insentive) {
                            $total += (($resultset[$key]['basic'] * $insentive->percentage) / 100) + $resultset[$key]['basic'];
                        }
                    }

                    // check bonus
                    if ($salaryInfo[0]->bonus == "yes") {
                        $bonusInfo = $this->action->read("bonus_structure", $where);
                        foreach ($bonusInfo as $bonus) {
                            $total += (($resultset[$key]['basic'] * $bonus->percentage) / 100) + $resultset[$key]['basic'];
                        }
                    }

                    // check deduction
                    if ($salaryInfo[0]->deduction == "yes") {
                        $deductionInfo = $this->action->read("deduction_structure", $where);
                        foreach ($deductionInfo as $deduction) {
                            $total -= $deduction->amount;
                        }
                    }

                    $resultset[$key]['total']  = $total;
                    $resultset[$key]['status'] = 'due';
                } else {
                    $resultset[$key]['basic']  = 0.00;
                    $resultset[$key]['total']  = 0.00;
                    $resultset[$key]['status'] = 'unknown';
                }

            }
        }

        echo json_encode($resultset);
    }


    public function payment_view($emit = NULL)
    {
        $this->data['active']       = 'data-target="employee_menu"';
        $this->data['subMenu']      = 'data-target="report"';
        $this->data['confirmation'] = null;
        $this->data['result']       = array();

        // get employee info
        $where     = array("emp_id" => $this->input->get('id'));
        $employees = $this->action->read("employee", $where);

        $this->data['result']['eid']       = $employees[0]->emp_id;
        $this->data['result']['name']      = $employees[0]->name;
        $this->data['result']['img']       = $employees[0]->path;
        $this->data['result']['post']      = $employees[0]->designation;
        $this->data['result']['joining']   = $employees[0]->joining_date;
        $this->data['result']['present']   = $employees[0]->present_address;
        $this->data['result']['permanent'] = $employees[0]->permanent_address;
        $this->data['result']['gender']    = $employees[0]->gender;
        // $this->data['result']['status']      = $employees[0]->status;
        $this->data['result']['mobile'] = $employees[0]->mobile;
        $this->data['result']['salary'] = array();

        // get salary record
        $where = array("eid" => $this->input->get('id'));
        $info  = $this->action->readGroupBy("salary_records", "date", $where);

        if ($info != null) {
            foreach ($info as $key => $row) {
                $date      = $row->date;
                $basic     = 0;
                $insentive = 0;
                $bonus     = 0;
                $deduction = 0;

                $where = array(
                    "date" => $row->date,
                    "eid"  => $this->input->get('id')
                );

                $info = $this->action->read("salary_records", $where);

                foreach ($info as $row) {
                    if ($row->remarks == 'basic') {
                        $basic = $row->amounts;
                    }

                    if ($row->remarks == 'insentive') {
                        $insentive += $row->amounts;
                    }

                    if ($row->remarks == 'bonus') {
                        $bonus += $row->amounts;
                    }

                    if ($row->remarks == 'deduction') {
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

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/payment-view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function employee_to_x($date = null, $adjust_amount = false){
        $result     = [];
        $just_emp   = [];
        $all_months = [];

        { //employee_salaries
            $joinTable  = [
                'salary'
            ];
            $joinCond   = [
                'employee.emp_id        = salary.emp_id'
            ];
            $joinWhere  = [
                'employee.status'       => 'active',
                'salary.trash'          => 0
            ];
            $joinSelect = [
                'employee.path',
                'employee.name',
                'employee.emp_id',
                'employee.mobile',
                'employee.designation',
                'employee.employee_salary',

                'salary.total_salary',
                'salary.payment_date as sal_payment_date ',
                'DATE_FORMAT(salary.payment_date, "%Y-%m") as sal_payment_y_m'
            ];
            $joinGroup = [
                'employee.emp_id',
                'sal_payment_date'
            ];
            $employee_salaries = get_left_join('employee', $joinTable, $joinCond, $joinWhere, $joinSelect, $joinGroup);
            $temp = [];
            foreach ($employee_salaries as $value) {
                $temp[$value->sal_payment_y_m][$value->emp_id] = $value;
                $just_emp[$value->emp_id] = $value;
                $all_months[$value->sal_payment_y_m] = $value->sal_payment_y_m;
            }

            $employee_salaries          = $temp;
            $size['employee_salaries']  = sizeof($temp);
            $result['employee_salaries'] = $employee_salaries;
        }

        { //employee_overtimes
            $joinTable  = [
                'overtime'
            ];
            $joinCond   = [
                'employee.emp_id     = overtime.emp_id'
            ];
            $joinWhere  = [
                'employee.status'       => 'active',
                'overtime.trash'        => 0
            ];
            $joinSelect = [
                'employee.emp_id',

                'overtime.date as overtime_date',
                'DATE_FORMAT(overtime.date, "%Y-%m") as overtime_y_m',
                'SUM(ROUND(TIME_TO_SEC(TIMEDIFF(overtime.end_time, overtime.start_time))/3600 * overtime.hourly_rate)) as overtime_total_amount'
            ];
            $joinGroup = [
                'employee.emp_id',
                'overtime_y_m'
            ];
            $employee_overtimes = get_left_join('employee', $joinTable, $joinCond, $joinWhere, $joinSelect, $joinGroup);

            $temp = [];
            foreach ($employee_overtimes as $value) {
                $temp[$value->overtime_y_m][$value->emp_id] = $value;
                $all_months[$value->overtime_y_m] = $value->overtime_y_m;
            }

            $employee_overtimes         = $temp;
            $size['employee_overtimes'] = sizeof($temp);
            $result['employee_overtimes'] = $employee_overtimes;
        }

        { //employee_advances
            $joinTable  = [
                'advanced_payment'
            ];
            $joinCond   = [
                'employee.emp_id     = advanced_payment.emp_id'
            ];
            $joinWhere  = [
                'employee.status'           => 'active',
                'advanced_payment.trash'    => 0
            ];
            $joinSelect = [
                'employee.emp_id',

                'advanced_payment.payment_date as advanced_payment_date',
                'SUM(advanced_payment.amount) as advanced_payment_amount',
                'DATE_FORMAT(advanced_payment.payment_date, "%Y-%m") as advanced_payment_y_m'
            ];
            $joinGroup = [
                'employee.emp_id',
                'advanced_payment_y_m'
            ];
            $employee_advances = get_left_join('employee', $joinTable, $joinCond, $joinWhere, $joinSelect, $joinGroup);

            $temp = [];
            foreach ($employee_advances as $value) {
                $temp[$value->advanced_payment_y_m][$value->emp_id] = $value;
                $all_months[$value->advanced_payment_y_m] = $value->advanced_payment_y_m;
            }
            $employee_advances          = $temp;
            $size['employee_advances']  = sizeof($temp);

            $large_key = array_keys($size, max($size))[0];
            unset($size[$large_key]);
            $result['employee_advances'] = $employee_advances;
        }

        $temp_result = [];

        foreach ($result as $key_k => $employees) { // all data
            foreach ($all_months as $key_month => $month) { // all months
                foreach ($employees as $emp_month => $employee) { // all employee data
                    foreach ($employee as $emp_id => $emp) { // single employee full data
                        $temp_result[$month][$emp_id]['date'] = $date;
                        foreach ($emp as $key => $val) { // single employee single data
                            if($month == $emp_month){
                                $temp_result[$month][$emp_id][$key] = $val;
                            } else {
                                // foreach($just_emp[$emp_id] as $key_2 => $val_2){
                                //     $temp_result[$month][$emp_id][$key_2] = $val_2;
                                // }
                            }
                        }
                    }
                }
            }
        }

        if(!empty($date)){
            if($adjust_amount == true){
                $prev_month = date('Y-m-t', strtotime($date." -1 month"));
                // $prev_month = date('Y-m-t', strtotime('2020-01'));
                // $prev_month = date('Y-m-t', strtotime($date));
                $pre_mon_salary = get_result('salary', ['payment_date' => $prev_month, 'trash' => 0], ['emp_id', 'adjust_amount']);

                $temp_result_this = $temp_result[$date];

                $temp = [];
                foreach ($pre_mon_salary as $value) {
                    $temp[$value->emp_id] = $value->adjust_amount;
                }
                $pre_mon_salary = $temp;

                $temp_result_this_result = [];
                foreach ($temp_result_this as $key => $value) {
                    if(!empty($pre_mon_salary[$key])){
                        $temp_result_this[$key]['adjust_amount'] = $pre_mon_salary[$key];
                    } else {
                        $temp_result_this[$key]['adjust_amount'] = '0.00';
                    }
                    
                }
                return $temp_result_this; // with adjust_amount
            } else {
                return $temp_result[$date]; // without adjust_amount
            }
        } else {
            return $temp_result; // without adjust_amount & date

        }
    }

}
