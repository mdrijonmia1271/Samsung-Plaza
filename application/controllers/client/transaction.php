<?php

/**
 * Working with client transaction
 * Methods():
 *   index: Add transactional record to database
 *   edit_transaction : Edit transaction record
 *   partyTransactionMeta: Add Additional transaction record to database
 **/
class Transaction extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get brand list
        $this->data['brandList'] = get_result('brand', ['trash' => 0]);
    }

    public function index()
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"'; //sale_menu
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;

        // Get all client parties name
        $this->data['allGodowns'] = getAllGodown();
        $this->data['allClient']  = $this->getAllClient();


        // save installment
        if (isset($_POST['save'])) {

            // fetch last insert record and increase by 1.
            $where      = array('party_code' => $this->input->post('code'));
            $last_sl    = $this->action->read_limit('partytransaction', $where, 'desc', 1);
            $voucher_sl = ($last_sl) ? ($last_sl[0]->serial + 1) : 1;

            $data = array(
                'inc_code'        => installmentCollectionId('partytransaction'),
                'transaction_at'  => $this->input->post('created_at'),
                'party_code'      => $this->input->post('code'),
                'credit'          => $this->input->post('payment'),
                'transaction_via' => $this->input->post('payment_type'),
                'brand'           => $this->input->post('brand'),
                'remission'       => $this->input->post('remission'),
                'adjustment'      => $this->input->post('adjustment'),
                'transaction_by'  => 'client',
                'serial'          => $voucher_sl,
                'godown_code'     => !empty($_POST['godown_code']) ? $_POST['godown_code'] : $this->data['branch'],
                'comment'         => $this->input->post('comment'),
            );


            if ($_POST['customer_type'] != 'dealer' && !empty($_POST['voucher_no'])) {
                $data['transaction_type'] = 'installment';
                $data['relation']         = $_POST['voucher_no'];
                $data['remark']           = 'installment';
            } else {
                $data['transaction_type'] = 'transaction';
                $data['relation']         = 'transaction';
                $data['remark']           = 'transaction';
            }

            $options = array(
                'title' => 'success',
                'emit'  => 'Client Transaction Successfully Saved!',
                'btn'   => true
            );


            $tid = $this->action->addAndGetId('partytransaction', $data);
            // save additional transaction info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($tid);
            }

            //Sending SMS Start
            if (isset($_POST['send_sms'])) {

                $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
                //$content = "Dear client, your payment " . $this->input->post("payment") . "TK successfully paid. Your current balance is " . $this->input->post("totalBalance") . "TK " . $sign. " Regards, RAFIQ ELECTRONICS.";
                $customer_name = get_row('parties', ['code' => $this->input->post('code')], ['name']);
                $content       = "নামঃ " . filter($customer_name->name) . ", জমাঃ  " . $this->input->post('payment') . " Tk, বর্তমান ব্যাল্যান্সঃ " . $this->input->post("totalBalance") . " Tk, তাংঃ " . $this->input->post('created_at') . ", Sharif Iqbal Store.";

                $num = $this->input->post("mobile_number");
                $message = send_sms($num, $content);

                $insert = array(
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'mobile'           => $num,
                    'message'          => $content,
                    'total_characters' => strlen($content),
                    'total_messages'   => message_length(strlen($content), $message),
                    'delivery_report'  => $message
                );

                if ($message) {
                    $this->action->add('sms_record', $insert);
                    
                    // $another_number = "01303270422";  
                    // $message_another = send_sms($another_number, $content);
                
                    // if($message_another){      
                           
                    //     $insert = array(
                    //         'delivery_date'    => date('Y-m-d'),
                    //         'delivery_time'    => date('H:i:s'),
                    //         'mobile'           => $another_number,  
                    //         'message'          => $content,
                    //         'total_characters' => strlen($content),
                    //         'total_messages'   => message_length(strlen($content), $message_another),
                    //         'delivery_report'  => $message_another
                    //     );
                        
                    //     save_data('sms_record', $insert);
                    // }
                    
                    
                    $this->data['confirmation'] = message('success', array());
                } else {
                    $this->data['confirmation'] = message('warning', array());
                }

            }
            //Sending SMS End


            $this->session->set_flashdata('confirmation', message("success", $options));
            $lastId = $this->action->read('partytransaction', array(), 'DESC');

            redirect('client/all_transaction/view/' . $lastId[0]->id, 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        //$this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/client/transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Edit transaction
     * table : partytransaction
     * Strategy : Update column credit using table id
     *
     */
    public function edit_transaction($id = null)
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"'; //sale_menu
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;

        // Get transactions Info
        $select = ['partytransaction.*', 'parties.name', 'parties.customer_type', 'parties.mobile', 'parties.address'];
        $this->data['info'] = $info = get_row_join("partytransaction", 'parties', 'parties.code=partytransaction.party_code', ["partytransaction.id" => $id], $select);
        $this->data['previousTranInfo'] = (object)get_client_balance($info->party_code, $info->id);

        //Update start from here
        if (isset($_POST['update'])) {
            
            $where = array("id" => $id);
            
            $data  = array(
                "transaction_at"  => $this->input->post("date"),
                "change_at"       => date('Y-m-d'),
                'brand'           => $this->input->post('brand'),
                "credit"          => $this->input->post("payment"),
                "remission"       => $this->input->post("remission"),
                "adjustment"      => $this->input->post("adjustment"),
                "transaction_via" => $this->input->post("payment_type"),
                "comment"         => $this->input->post("comment")
            );

            // Save additional transactional info
            if ($this->input->post('payment_type') == 'cheque') {
                $this->partyTransactionMeta($id);
            }

            $msg_array                  = array(
                "title" => "Success",
                "emit"  => "Transaction Successfully Updated",
                "btn"   => true
            );
            
            $this->data["confirmation"] = message($this->action->update("partytransaction", $data, $where), $msg_array);

            $this->session->set_flashdata("confirmation", $this->data['confirmation']);

            redirect('client/transaction/edit_transaction/' . $id, 'refresh');
        }
        // Update end here

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        //$this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/client/edit_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Save cheque info
     * Table: partytransactionmeta
     * Strategy: partytransaction's table auto increament id
     *  save into transaction_id column and other info as meta_key and meta_value
     */
    private function partyTransactionMeta($id)
    {
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'transaction_id' => $id,
                    'meta_key'       => $key,
                    'meta_value'     => $value
                );
                $this->action->add('partytransactionmeta', $data);
            }
        }
        return true;
    }

    private function getAllClient()
    {
        $where = [];
        $where = [
            "type"   => "client",
            "status" => "active",
            "trash"  => 0
        ];

        if ($this->data['privilege'] != 'super') {
            $where["godown_code"] = $this->data['branch'];
        }


        $result = get_result('parties', $where, ['code', 'name', 'mobile']);
        return $result;
    }
}
