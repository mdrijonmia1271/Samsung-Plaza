<style>
  @media print {
    aside {
      display: none !important;
    }

    nav {
      display: none;
    }

    .panel {
      border: 1px solid transparent;
      left: 0px;
      position: absolute;
      top: 0px;
      width: 100%;
    }

    .none {
      display: none;
    }

    .panel-heading {
      display: none;
    }

    .panel-footer {
      display: none;
    }

    .panel .hide {
      display: block !important;
    }

    .title {
      font-size: 25px;
    }

    table tr th,
    table tr td {
      font-size: 12px;
    }

    .print_banner_logo {
      width: 19%;
      float: left;
    }

    .print_banner_logo img {
      margin-top: 10px;
    }

    .print_banner_text {
      width: 80%;
      float: right;
      text-align: center;
    }

    .print_banner_text h2 {
      margin: 0;
      line-height: 38px;
      text-transform: uppercase !important;
    }

    .print_banner_text p {
      margin-bottom: 5px !important;
    }

    .print_banner_text p:last-child {
      padding-bottom: 0 !important;
      margin-bottom: 0 !important;
    }
  }
</style>
<div class="container-fluid">
  <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">Profile</h1>
          <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i
              class="fa fa-print"></i> Print</a>
        </div>
      </div>
      <div class="panel-body" ng-cloak>
        <!-- Print banner Start Here -->
        <?php $this->load->view('print', $this->data); ?>
        <!-- Print banner End Here -->

        <!--<h4 class="text-center hide" style="margin-top: 0px;">Profile</h4>-->
        <div class="col-md-12 text-center hide">
          <h3>Supplier Profile</h3>
        </div>

        <table class="table table-bordered table-hover">
          <tr>
            <th>Date</th>
            <td><?php echo $partyInfo[0]->opening; ?></td>
          </tr>
          <!--tr>
            <th width="40%">ID</th>
            <td><?php echo $partyInfo[0]->code; ?></td>
          </tr-->
          <tr>
            <th>Name</th>
            <td><?php echo filter($partyInfo[0]->name); ?></td>
          </tr>
          <tr>
            <th>Showroom</th>
            <td>
              <?php
                $showroom = get_name('godowns', 'name', ['code'=>$partyInfo[0]->godown_code]);
              echo (!empty($showroom) ? $showroom : ''); ?>
            </td>
          </tr>
          <tr>
            <th>Mobile Number</th>
            <td><?php echo $partyInfo[0]->mobile; ?></td>
          </tr>
          <tr>
            <th>Address</th>
            <td><?php echo $partyInfo[0]->address; ?></td>
          </tr>
          <tr>
            <th>Initial Balance </th>
            <td>
              <?php
              $init_balance = $partyInfo[0]->initial_balance;
              //$status = ($init_balance >= 0) ?  "Receivable" : "Payable";
              $status = ($init_balance >= 0) ?  " - " : " ";
              echo  $status . f_number(abs($init_balance)) . ' TK';
              //echo f_number($init_balance) . ' TK';
              ?>
            </td>
          </tr>
          <tr>
            <th>Current Balance </th>
            <td>
              <?php
              $where = ['party_code' => $partyInfo[0]->code, 'trash' => 0];
              $transactionRec = $this->retrieve->read('partytransaction',$where);
              $total_credit = $total_debit = 0.0;
              if (!empty($transactionRec)) {
				    $total_credit = $total_debit = $currentBalance = 0.0;
				    
					foreach ($transactionRec as $row) {
						$total_credit += $row->credit;
						$total_debit += $row->debit;
					}
					
					if($partyInfo[0]->initial_balance > 0){
                        $balance = $partyInfo[0]->initial_balance + $total_debit - $total_credit;
    	   			}else{
                        $balance = $total_debit - ($total_credit + abs($partyInfo[0]->initial_balance));
    	   			}
					//$status = ($balance >= 0) ?  "Receivable" : "Payable";
					$status = ($balance >= 0) ?  " - " : " ";
				}else{
					$balance = $partyInfo[0]->initial_balance;
					//$status = ($balance >= 0) ?  "Receivable" : "Payable";
					$status = ($balance >= 0) ?  " - " : " ";
				}
              echo $status . f_number(abs($balance))." Tk";
              //echo f_number($balance) . ' TK';
              ?>
            </td>
          </tr>
          <tr>
            <th>Status</th>
            <td><?php echo filter($partyInfo[0]->status); ?></td>
          </tr>
        </table>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
  </div>
</div>