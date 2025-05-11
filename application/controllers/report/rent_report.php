<?php
class Rent_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){
        $this->data['resultset'] = array();
        $this->data['totalRec'] = array(
            'january' => 0.00, 
            'february' => 0.00, 
            'march' => 0.00, 
            'april' => 0.00, 
            'may' => 0.00, 
            'june' => 0.00, 
            'july' => 0.00, 
            'august' => 0.00, 
            'september' => 0.00, 
            'october' => 0.00, 
            'november' => 0.00, 
            'december' => 0.00
        );

        if(isset($_POST['show'])) {
            $months = config_item('months');
            $fields = $this->action->read('rent');
            $counter = 1;

            foreach ($fields as $rent) {
                $where = array(
                    'YEAR(date)' => $this->input->post('year'),
                    'field' => str_replace(" ","_",$rent->field),
                    'trash'      => 0
                );

                // print_r($where);


                $totalCost = 0.00;
                foreach ($months as $key => $month) {
                    $where['MONTH(date)'] = ($key + 1);
                    $details[$key] = array('month' => $month);
                    $records = $this->action->read('rent', $where);

                    $total = 0.00;
                    if($records != null) {
                        foreach ($records as $row) {
                            $total += $row->amount;
                        }
                    }

                    $totalCost += $total;
                    $details[$key]['amount'] = $total;
                }

                $this->data['resultset'][] = array(
                    'sl' => $counter,
                    'field' => $rent->field,
                    'details' => $details,
                    'total' => $totalCost
                );

                $counter++;
            }
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/rent_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }



 }
