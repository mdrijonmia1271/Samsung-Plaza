<?php

class Salary extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="salary"';
        $this->data['confirmation'] = null;

        $this->data['employee'] = $this->allEmployee();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/basic-salary', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function set_basic_salary()
    {

        if (!empty($_POST['emp_id'])) {
            save_data('employee', ['employee_salary' => $_POST['employee_salary']], ['emp_id' => $_POST['emp_id']]);

            $msg = array(
                "title" => "success",
                "emit"  => "Salary add successfully!",
                "btn"   => true
            );

            $status = 'success';
        } else {
            $msg = array(
                "title" => "warning",
                "emit"  => "Something was wrong!",
                "btn"   => true
            );

            $status = 'warning';
        }


        $options = array(
            "title" => "Success",
            "emit"  => "Incentive Successfully Saved",
            "btn"   => true
        );

        $this->session->set_flashdata('confirmation', message($status, $msg));
        redirect('salary/salary', 'refresh');
    }

    public function ajax_emp_info()
    {
        $emp_id   = $this->input->post('emp_id');
        $where    = array("emp_id" => $emp_id);
        $emp_data = $this->action->read("employee", $where);
        if (count($emp_data)) {
            echo json_encode($emp_data[0]);
        } else {
            echo "empty";
        }
    }

    public function ajax_emp_salery()
    {
        $emp_id   = $this->input->post('emp_id');
        $where    = array("emp_id" => $emp_id);
        $emp_data = $this->action->read("basic_salary", $where);
        if (count($emp_data)) {
            echo json_encode($emp_data[0]);
        } else {
            echo "empty";
        }
    }


    public function incentive($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="incentive"';
        $this->data['confirmation'] = null;

        // work with DB
        if ($this->input->post('create')) {
            $counter = 0;

            // store data into incentive table
            foreach ($_POST['name'] as $key => $value) {
                $data = array(
                    "eid"        => $this->input->post('id'),
                    "fields"     => $_POST['name'][$key],
                    "percentage" => $_POST['percent'][$key],
                    "remarks"    => $_POST['remark'][$key]
                );

                // check the existance
                $where = array(
                    "eid"    => $this->input->post('id'),
                    "fields" => $_POST['name'][$key]
                );

                if ($this->action->exists("incentive_structure", $where)) {
                    $this->action->update("incentive_structure", $data, $where);
                } else {
                    $this->action->add("incentive_structure", $data);
                }

                if ($_POST['percent'][$key] > 0) {
                    $counter += 1;
                }
            }

            // active incentive from structure table
            $where = array('eid' => $this->input->post('id'));
            if ($counter > 0) {
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

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/incentive', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function salary_sheet($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="sheet"';
        $this->data['confirmation'] = null;

        $this->data['salarySheet'] = $this->action->readOrderby('employee', 'emp_id', array('status =>active'), 'asc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/salary_sheet', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function bonus($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="bonus"';
        $this->data['confirmation'] = null;

        // get all employee
        $this->data['allEmployee'] = get_result("employee", ['status' => 'active'], ['emp_id', 'name', 'designation'], "", "id", "asc");

        // get all percent
        $this->data['results'] = get_join('bonus', 'employee', 'bonus.emp_id=employee.emp_id', ['bonus.trash' => 0], ['employee.name', 'bonus.*'], '', 'created', 'desc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/bonus', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function set_bonus()
    {
        $bonus_date = ((!empty($_POST['year']) && !empty($_POST['month'])) ? date('Y-m-t', strtotime(($_POST['year'] . '-' . $_POST['month']))) : date('Y-m-t', strtotime('today')));

        if (!empty($_POST['id'])) {
            foreach ($_POST['id'] as $key) {

                $data = [
                    'created'    => date('Y-m-d'),
                    'bonus_date' => $bonus_date,
                    'emp_id'     => $_POST['emp_id'][$key],
                    'bonus'      => $_POST['bonus'][$key],
                ];

                $where = [
                    'bonus_date' => $bonus_date,
                    'emp_id'     => $_POST['emp_id'][$key]
                ];

                if (check_exists('bonus', $where)) {
                    save_data('bonus', $data, $where);
                } else {
                    save_data('bonus', $data);
                }
            }
        }


        $msg = array(
            'title' => 'success',
            'emit'  => 'Bonus Successfully Set!',
            'btn'   => true
        );

        $this->session->set_flashdata('confirmation', message('success', $msg));
        redirect('salary/salary/bonus', 'refresh');
    }


    public function bonus_delete($id = NULL)
    {
        if (!empty($id)) {
            delete_data('bonus', ['id' => $id]);
            $msg = array(
                'title' => 'delete',
                'emit'  => 'Bonus Percentage Successfully Deleted!',
                'btn'   => true
            );
            $this->session->set_flashdata('confirmation', message('danger', $msg));
        } else {
            $msg = array(
                'title' => 'error',
                'emit'  => 'Data Not Found!',
                'btn'   => true
            );
            $this->session->set_flashdata('confirmation', message('warning', $msg));
        }

        redirect('salary/salary/bonus', 'refresh');
    }

    public function edit_bonus($id = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="bonus"';
        $this->data['confirmation'] = null;

        // get all employee
        $this->data['employee'] = $this->allEmployee();

        // get bonus info
        $this->data['info'] = get_row('bonus', ['id' => $id]);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/edit_bonus', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function bonus_edit($id = NULL)
    {

        $bonus_date = ((!empty($_POST['year']) && !empty($_POST['month'])) ? date('Y-m-t', strtotime(($_POST['year'] . '-' . $_POST['month']))) : date('Y-m-t', strtotime('today')));

        $data = [
            'created'    => date('Y-m-d'),
            'bonus_date' => $bonus_date,
            'emp_id'     => $_POST['emp_id'],
            'bonus'      => $_POST['bonus'],
        ];

        $msg = array(
            'title' => 'update',
            'emit'  => 'Bonus Successfully Updated!',
            'btn'   => true
        );

        save_data('bonus', $data, ['id' => $id]);
        $this->session->set_flashdata('confirmation', message('success', $msg));
        redirect('salary/salary/bonus', 'refresh');
    }

    public function deduction($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="deduction"';
        $this->data['confirmation'] = null;

        // work with DB
        if ($this->input->post('create')) {
            $counter = 0;

            // store data into deduction table
            foreach ($_POST['name'] as $key => $value) {
                $data = array(
                    "eid"        => $this->input->post('id'),
                    "fields"     => $_POST['name'][$key],
                    "percentage" => $_POST['percent'][$key],
                    "amount"     => $_POST['amount'][$key],
                    "remarks"    => $_POST['remark'][$key]
                );

                // check the existance
                $where = array(
                    "eid"    => $this->input->post('id'),
                    "fields" => $_POST['name'][$key]
                );

                if ($this->action->exists("deduction_structure", $where)) {
                    $this->action->update("deduction_structure", $data, $where);
                } else {
                    $this->action->add("deduction_structure", $data);
                }

                if ($_POST['amount'][$key] > 0) {
                    $counter += 1;
                }
            }

            // active deduction from structure table
            $where = array('eid' => $this->input->post('id'));
            if ($counter > 0) {
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


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/deduction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function advanced()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="advanced"';
        $this->data['confirmation'] = null;

        $this->data['employee'] = $this->allEmployee();

        // delete data
        if (!empty($_GET['id'])) {
            $where = array("id" => $_GET['id']);

            $options = array(
                "title" => "delete",
                "emit"  => "Advanced Payment Successfully Deleted",
                "btn"   => true
            );

            save_data('advanced_payment', ['trash' => 1], $where);

            $this->session->set_flashdata('confirmation', message('danger', $options));
            redirect('salary/salary/advanced', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/advanced', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store_advance()
    {
        $payment_date = ((!empty($_POST['year']) && !empty($_POST['month'])) ? date('Y-m-t', strtotime(($_POST['year'] . '-' . $_POST['month']))) : date('Y-m-t', strtotime('today')));

        $data = array(
            "created"      => input_data('created'),
            "payment_date" => $payment_date,
            "emp_id"       => input_data('emp_id'),
            "amount"       => input_data('amount')
        );

        $options = array(
            "title" => "Success",
            "emit"  => "Advanced Payment Successfully Saved",
            "btn"   => true
        );

        save_data('advanced_payment', $data);

        // send sms start here....
        $content = "Dear Employee, Advance Salary Tk - " . $_POST['amount'] . " has been given. Regards, Charu Press.";
        $num     = $this->input->post("mobile");
        $message = send_sms($num, $content);
        if ($message) {

            $insert = array(
                'delivery_date'    => date('Y-m-d'),
                'delivery_time'    => date('H:i:s'),
                'mobile'           => $num,
                'message'          => $content,
                'total_characters' => strlen($content),
                'total_messages'   => message_length(strlen($content), $message),
                'delivery_report'  => $message
            );

            save_data('sms_record', $insert);
        }
        // send sms end here...

        $this->session->set_flashdata('confirmation', message('success', $options));
        redirect('salary/salary/advanced', 'refresh');
    }


    public function report($emit = NULL)
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="salary_menu"';
        $this->data['subMenu']      = 'data-target="report"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
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

    // get all employee
    private function allEmployee()
    {
        $result = get_result("employee", ['status' => 'active'], ['emp_id', 'name'], "", "id", "asc");
        return $result;
    }
}
