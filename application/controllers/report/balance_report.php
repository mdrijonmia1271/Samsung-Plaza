<?php

class Balance_report extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title'] = 'Balance Report';
        $this->data['active']     = 'data-target="report_menu"';
        $this->data['subMenu']    = 'data-target="balance"';

        $this->data['saleIncome']      = NULL;
        $this->data['creditSaleIncome']= NULL;
        $this->data['dealerSaleIncome']= NULL;
        $this->data['cashSaleIncome']  = NULL;
        $this->data['clientPayment']   = NULL;
        $this->data['dueCollection']   = NULL;
        $this->data['otherIncome']     = NULL;
        $this->data['bankIncome']      = NULL;
        $this->data['loanReceived']    = NULL;
        $this->data['loanTrxReceived'] = NULL;

        $this->data['purchase']        = NULL;
        $this->data['SaleReturnInfo']  = NULL;
        $this->data['supplierPayment'] = NULL;
        $this->data['cashtoTT']        = NULL;
        $this->data['allCost']         = NULL;
        $this->data['bankCost']        = NULL;
        $this->data['loanPaid']        = NULL;
        $this->data['loanTrxPaid']     = NULL;
        $this->data['advanceSalary']   = NULL;
        $this->data['salary']          = NULL;
        $this->data['mdTransactionReceived'] = NULL;
        $this->data['mdTransactionPaid'] = NULL;

        $where['trash'] = 0;
        $dueWhere       = ['paid >' => 0];
        $mdTransactionWhere['trash'] = 0;
        
        $whereSap       = ['saprecords.status' => 'sale', 'saprecords.trash' => 0];
        
        $whereSaleReturn = [
            'saprecords.status' => 'sale_return',
            'saprecords.trash'  => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['godown_code'])) {

                if ($_POST['godown_code'] != 'all') {
                    
                    $whereSaleReturn['saprecords.godown_code']        = $_POST['godown_code'];
                    $where['godown_code']        = $_POST['godown_code'];
                    $bankWhere['godown_code']    = $_POST['godown_code'];
                    $loanWhere['godown_code']    = $_POST['godown_code'];
                    $loanTrxWhere['godown_code'] = $_POST['godown_code'];

                    $whereSap['saprecords.godown_code']       = $_POST['godown_code'];
                    $dueWhere['godown_code']                  = $_POST['godown_code'];
                    $clientWhere['partytransaction.godown_code']               = $_POST['godown_code'];
                    $dealerWhere['partytransaction.godown_code']               = $_POST['godown_code'];

                    $wherePurchase['godown_code']   = $_POST['godown_code'];
                    $whereSaleReturn['saprecords.godown_code'] = $_POST['godown_code'];
                    $cashTTwhere['godown_code']     = $_POST['godown_code'];
                    $supplierWhere['godown_code']   = $_POST['godown_code'];
                    $mdTransactionWhere['godown_code']  = $_POST['godown_code'];
                }
            }

            if (!empty($_POST['date'])) {
                
                foreach ($_POST['date'] as $key => $val) {
                    if ($val != null && $key == 'from') {
                        $where['date >=']                 = $val;
                        $whereSaleReturn['saprecords.sap_at >=']     = $val;
                        $bankWhere['transaction_date >='] = $val;
                        $loanWhere['date >=']             = $val;
                        $loanTrxWhere['date >=']          = $val;

                        $whereSap['saprecords.sap_at >='] = $val;
                        $dueWhere['date >='] = $val;
                        $clientWhere['partytransaction.transaction_at >='] = $val;
                        $dealerWhere['partytransaction.transaction_at >='] = $val;

                        $wherePurchase['sap_at >=']         = $val;
                        $cashTTwhere['transaction_at >=']   = $val;
                        $supplierWhere['transaction_at >='] = $val;
                        $advanceSalaryWhere['advanced_payment.created >='] = $val;
                        $salaryWhere['salary_records.created >='] = $val;
                        $mdTransactionWhere['date >=']      = $val;
                    }

                    if ($val != null && $key == 'to') {
                        $whereSaleReturn['saprecords.sap_at <=']                 = $val;
                        $where['date <=']                 = $val;
                        $bankWhere['transaction_date <='] = $val;
                        $loanWhere['date <=']             = $val;
                        $loanTrxWhere['date <=']          = $val;

                        $whereSap['saprecords.sap_at <='] = $val;
                        $dueWhere['date <=']= $val;
                        $clientWhere['partytransaction.transaction_at <='] = $val;
                        $dealerWhere['partytransaction.transaction_at <='] = $val;

                        $wherePurchase['sap_at <=']         = $val;
                        $cashTTwhere['transaction_at <=']   = $val;
                        $supplierWhere['transaction_at <='] = $val;
                        
                        $advanceSalaryWhere['advanced_payment.created <='] = $val;
                        $salaryWhere['salary_records.created <='] = $val;
                        $mdTransactionWhere['date <=']      = $val;
                    }
                }
            } else {
                
                $where['date']                 = date('Y-m-d');
                $bankWhere['transaction_date'] = date('Y-m-d');
                $loanWhere['date']             = date('Y-m-d');
                $loanTrxWhere['date']          = date('Y-m-d');

                $whereSap['saprecords.sap_at']       = date('Y-m-d');
                $dueWhere['date']                    = date('Y-m-d');
                $clientWhere['partytransaction.transaction_at']       = date('Y-m-d');
                $dealerWhere['partytransaction.transaction_at']       = date('Y-m-d');

                $wherePurchase['sap_at']         = date('Y-m-d');
                $whereSaleReturn['saprecords.sap_at']   = date('Y-m-d');
                $cashTTwhere['transaction_at']   = date('Y-m-d');
                $supplierWhere['transaction_at'] = date('Y-m-d');
                $advanceSalaryWhere['advanced_payment.created'] = date('Y-m-d');
                $salaryWhere['salary_records.created'] = date('Y-m-d');
                $mdTransactionWhere['date']      = date('Y-m-d');
            }
            
        } else {
            
            $where        = ['date' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $bankWhere    = ['transaction_date' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $loanWhere    = ['date' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $loanTrxWhere = ['date' => date('Y-m-d'), 'godown_code' => $this->data['branch']];

            $whereSap      = ['sap_at' => date('Y-m-d'), 'saprecords.trash' => 0, 'saprecords.godown_code' => $this->data['branch']];
            $dueWhere      = ['date' => date('Y-m-d'), 'paid >' => 0, 'godown_code' => $this->data['branch']];
            $clientWhere   = ['partytransaction.transaction_at' => date('Y-m-d'), 'partytransaction.godown_code' => $this->data['branch']];
            $dealerWhere   = ['partytransaction.transaction_at' => date('Y-m-d'), 'partytransaction.godown_code' => $this->data['branch']];

            $wherePurchase   = ['sap_at' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $whereSaleReturn = ['saprecords.sap_at' => date('Y-m-d'), 'saprecords.godown_code' => $this->data['branch']];
            $cashTTwhere     = ['transaction_at' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $supplierWhere      = ['transaction_at' => date('Y-m-d'), 'godown_code' => $this->data['branch']];
            $advanceSalaryWhere = ['advanced_payment.created' => date('Y-m-d')];
            $salaryWhere        = ['salary_records.created' => date('Y-m-d')];
            $mdTransactionWhere = ['date' => date('Y-m-d'), 'godown_code' =>$this->data['branch']];
        }


        //======================================================================
        // INCOME BALANCE CALCULATION START HERE
        
        // advance salary
        $advanceSalaryWhere['advanced_payment.trash'] = 0;
        $this->data['advanceSalary'] = get_left_join('advanced_payment', 'employee', 'advanced_payment.emp_id=employee.emp_id', $advanceSalaryWhere, ['advanced_payment.*', 'employee.name', 'employee.mobile']);
        
        // salary
        $salaryWhere['salary_records.trash'] = 0;
        $this->data['salary'] = get_left_join('salary_records', 'employee', 'salary_records.emp_id=employee.emp_id', $salaryWhere, ['salary_records.*', 'employee.name', 'employee.mobile']);
        

        // all sale 
        $select                        = ['saprecords.sap_at', 'saprecords.party_code', 'saprecords.godown_code', 'saprecords.sap_type', 'saprecords.voucher_no', 'saprecords.paid'];
        $this->data['saleIncome']      = get_result('saprecords', $whereSap, $select);
        
        // all credit sale
        $whereSap['saprecords.sap_type']= 'credit';
        $select                         = ['saprecords.sap_at', 'saprecords.party_code', 'saprecords.godown_code', 'saprecords.sap_type', 'saprecords.voucher_no', 'saprecords.paid'];
        $this->data['creditSaleIncome'] = get_result('saprecords', $whereSap, $select);
        
        // all dealer sale
        $whereSap['saprecords.sap_type']= 'dealer';
        $select                         = ['saprecords.sap_at', 'saprecords.party_code', 'saprecords.godown_code', 'saprecords.sap_type', 'saprecords.voucher_no', 'saprecords.paid'];
        $this->data['dealerSaleIncome'] = get_result('saprecords', $whereSap, $select);
        
        // all cash sale
        $whereSap['saprecords.sap_type']= 'cash';
        $select                         = ['saprecords.sap_at', 'saprecords.party_code', 'saprecords.godown_code', 'saprecords.sap_type', 'saprecords.voucher_no', 'saprecords.paid'];
        $this->data['cashSaleIncome']   = get_result('saprecords', $whereSap, $select);
        
        
        // Client Payment
        $clientWhere['partytransaction.trash']= 0;
        $clientWhere['partytransaction.credit >']= 0;
        $clientWhereIn = [['partytransaction.transaction_type',  ['transaction', 'installment']], ['parties.customer_type',  ['hire', 'weekly']]];
        $select = ['partytransaction.transaction_at', 'partytransaction.credit',  'partytransaction.lpr_code', 'partytransaction.inc_code',  'partytransaction.party_code', 'parties.name'];
        $this->data['clientPayment']   = get_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', $clientWhere, $select, '', '', '', '', '', $clientWhereIn);
        
        // Client Payment
        $dealerWhere['partytransaction.trash'] = 0;
        $dealerWhere['parties.customer_type'] = 'dealer';
        $dealerWhere['partytransaction.transaction_type'] = 'transaction';
        $select = ['partytransaction.transaction_at', 'partytransaction.credit', 'partytransaction.inc_code',  'partytransaction.party_code', 'parties.name'];
        $this->data['dealerPayment']   = get_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', $dealerWhere, $select);

        // Due Collection
        $this->data['dueCollection'] = $this->action->readGroupBy('due_collect', 'voucher_no', $dueWhere);


        // Other Income
        $where['trash']            = 0;
        $this->data['otherIncome'] = $this->action->readGroupBy('income', 'field', $where);

        // Bank Income
        $bankWhere['transaction_type'] = 'Debit';
        $this->data['bankIncome']      = get_result('transaction', $bankWhere);

        // Loan Received 
        $loanWhere['type']          = 'Received';
        $this->data['loanReceived'] = get_result('loan_new', $loanWhere);

        // Loan Trx Received =>
        $loanTrxWhere['type']          = 'Receive';
        $this->data['loanTrxReceived'] = get_result('add_trx', $loanTrxWhere);
        
        // MD Transaction Received =>
        $mdTransactionWhere['type']             = 'Received';
        $this->data['mdTransactionReceived']    = get_result('md_transactions', $mdTransactionWhere);

        // INCOME BALANCE CALCULATION END HERE
        //======================================================================


        //======================================================================
        // COST BALANCE CALCULATION START HERE

        // Purchase Cost =>
        $wherePurchase['status'] = 'purchase';
        $wherePurchase['paid >'] = 0;
        $wherePurchase['trash']  = 0;
        $this->data['purchase']  = get_result('saprecords', $wherePurchase);

        // Sale Return Cost =>
        
        $whereSaleReturn['saprecords.trash'] = 0;
        $whereSaleReturn['saprecords.status'] ='sale_return';
        
        $tableTo                   = ['godowns'];
        $joinCond                  = ['saprecords.godown_code=godowns.code'];
        $select                    = ['saprecords.*', 'godowns.name as godown_name'];
        $this->data['sale_return'] = get_left_join("saprecords", $tableTo, $joinCond, $whereSaleReturn, $select, "saprecords.voucher_no", "saprecords.id", "desc");
        
        
        // Supplier Collection =>
        $supplierWhere['transaction_by'] = 'supplier';
        $supplierWhere['trash']          = 0;
        $this->data['supplierPayment']   = get_result('partytransaction', $supplierWhere);

        // Cash to TT =>
        $cashTTwhere['transaction_via'] = 'cash_to_tt';
        $cashTTwhere['transaction_by']  = 'supplier';
        $cashTTwhere['trash']           = 0;
        $this->data['cashtoTT']         = get_result('partytransaction', $cashTTwhere);

        //All Cost =>
        $this->data['allCost'] = $this->action->readGroupBy('cost', 'cost_field', $where);

        //Bank Cost =>
        $bankWhere['transaction_type'] = 'Credit';
        $this->data['bankCost']        = get_result('transaction', $bankWhere);

        // Loan Paid =>
        $loanWhere['type']      = 'Paid';
        $this->data['loanPaid'] = get_result('loan_new', $loanWhere);

        // Loan Trx Paid =>
        $loanTrxWhere['type']      = 'Paid';
        $this->data['loanTrxPaid'] = get_result('add_trx', $loanTrxWhere);



        // MD Transaction Paid =>
        $mdTransactionWhere['type']         = 'Paid';
        $this->data['mdTransactionPaid']    = get_result('md_transactions', $mdTransactionWhere);
        
        // COST BALANCE CALCULATION END HERE
        //======================================================================


        // close blance
        if (isset($_POST['close_balance'])) {
            if ($_POST['start_date'] == $_POST['close_date']) {

                $data = array(
                    'date'            => $this->input->post('close_date'),
                    'godown_code'     => $this->input->post('godownCode'),
                    'opening_balance' => $this->input->post('opening_balance'),
                    'closing_balance' => $this->input->post('closing_balance')
                );

                $where = ['date' => $_POST['close_date'], 'godown_code' => $this->input->post('godownCode')];

                if (check_exists('opening_balance', $where)) {
                    $status = $this->action->update('opening_balance', $data, $where);
                    $msg    = array(
                        'title' => 'Added',
                        'emit'  => 'Balance Successfully Closed',
                        'btn'   => true
                    );
                } else {
                    $status = $this->action->add('opening_balance', $data);
                    $msg    = array(
                        'title' => 'Added',
                        'emit'  => 'Balance Successfully Closed',
                        'btn'   => true
                    );
                }
            } else {
                $status = 'warning';
                $msg    = array(
                    'title' => 'Warning',
                    'emit'  => 'Both date are not same...!',
                    'btn'   => true
                );
            }
            $confirm = message($status, $msg);
            $this->session->set_flashdata('confirmation', $confirm);
            redirect('report/balance_report', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        // $this->load->view('components/report/report_nav', $this->data);
        $this->load->view('components/report/balance_report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
}
