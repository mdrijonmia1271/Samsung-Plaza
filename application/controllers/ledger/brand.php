<?php

class Brand extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Brand Ledger';
        $this->data['active']     = 'data-target="ledger"';
    }

    public function index()
    {
        $this->data['subMenu'] = 'data-target="brand"';
        $this->data['width']   = 'width';

        $this->data['godownList'] = getAllGodown();
        $this->data['brandList']  = get_result('brand', ['trash' => 0], 'brand');

        if (!empty($_POST['party_code']) && !empty($_POST['brand'])) {

            $partyCode = $_POST['party_code'];

            $this->data['partyInfo'] = get_row_join('parties', 'godowns', 'parties.godown_code=godowns.code', ['parties.code' => $partyCode], ['parties.*', 'godowns.name AS godown_name']);

            $dateFrom = (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] : '');
            $dateTo = (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'));

            $brand    = !empty($_POST['brand']) ? ' AND brand = \'' . $_POST['brand'] . '\'' : '';

            $previousBalance = 0;
            if (!empty($dateFrom)){
                $tranInfo = custom_query("SELECT IFNULL(SUM(credit), 0) AS credit, IFNULL(SUM(debit), 0) AS debit, IFNULL(SUM(remission), 0) AS remission, brand FROM partytransaction WHERE party_code='$partyCode' AND trash=0 AND transaction_at < '$dateFrom' {$brand} GROUP BY brand", true);
                $previousBalance = $tranInfo->debit - ($tranInfo->credit + $tranInfo->remission);
            }

            $this->data['previousBalance'] = $previousBalance;

            $startDate = !empty($dateFrom) ? ' AND transaction_at >= \'' . $dateFrom . '\'' : '';
            $endDate = !empty($dateTo) ? ' AND transaction_at <= \'' . $dateTo . '\'' : '';
            $branInfo = custom_query("SELECT id, transaction_at, relation, remark, credit, debit, remission, adjustment, brand FROM partytransaction WHERE party_code='$partyCode' AND trash=0 {$brand} {$startDate} {$endDate}");

            $results = [];
            $balance = $previousBalance;
            if (!empty($branInfo)) {
                foreach ($branInfo as $row) {

                    $balance += $row->debit - ($row->credit + $row->remission) + $row->adjustment;

                    $voucherNo = ($row->remark != 'transaction' ? explode(':', $row->relation)[1] : get_code($row->id));

                    $item               = [];
                    $item['date']       = $row->transaction_at;
                    $item['voucher_no'] = $voucherNo;
                    $item['remark']     = filter($row->remark);
                    $item['brand']      = $row->brand;
                    $item['debit']      = $row->debit;
                    $item['credit']     = $row->credit;
                    $item['remission']  = $row->remission;
                    $item['adjustment'] = $row->adjustment;
                    $item['balance']    = $balance;

                    array_push($results, (object)$item);
                }
            }

            $this->data['results']    = $results;
            $this->data['showResult'] = false;
        } else {
            $this->data['results']    = $this->defaultData();
            $this->data['showResult'] = true;
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/brand', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // Get the default data
    public function defaultData()
    {
        $where = [
            'parties.type'  => 'client',
            'parties.trash' => 0,
        ];

        if (!empty($_POST['godown_code'])) {
            if ($_POST['godown_code'] != 'all') {
                $where['parties.godown_code'] = $_POST['godown_code'];
            }
        } else {
            $where['parties.godown_code'] = $this->data['branch'];
        }

        if (!empty($_POST['party_code'])) {
            $where['parties.code'] = $_POST['party_code'];
        }


        $select     = ['parties.code', 'parties.name', 'parties.mobile', 'parties.address', 'parties.godown_code', 'godowns.name AS godown_name'];
        $clientList = get_join('parties', 'godowns', 'parties.godown_code=godowns.code', $where, $select);

        // get Client transaction
        $results = [];
        if (!(empty($clientList))) {
            foreach ($clientList as $row) {

                $brand    = !empty($_POST['brand']) ? ' AND brand = \'' . $_POST['brand'] . '\'' : '';
                $branInfo = custom_query("SELECT IFNULL(SUM(credit), 0) AS credit, IFNULL(SUM(debit), 0) AS debit, IFNULL(SUM(remission), 0) AS remission, IFNULL(SUM(adjustment), 0) AS adjustment, brand FROM partytransaction WHERE party_code='$row->code' AND trash=0 {$brand} GROUP BY brand");

                if (!empty($branInfo)) {
                    foreach ($branInfo as $b_row) {

                        $balance = $b_row->debit - ($b_row->credit + $b_row->remission) + $b_row->adjustment;

                        $item                = [];
                        $item['code']        = $row->code;
                        $item['name']        = $row->name;
                        $item['mobile']      = $row->mobile;
                        $item['address']     = $row->address;
                        $item['godown_name'] = $row->godown_name;
                        $item['brand']       = $b_row->brand;
                        $item['debit']       = $b_row->debit;
                        $item['credit']      = $b_row->credit;
                        $item['remission']   = $b_row->remission;
                        $item['adjustment']  = $b_row->adjustment;
                        $item['balance']     = $balance;

                        array_push($results, (object)$item);
                    }
                }
            }

            return $results;
        }
    }
}