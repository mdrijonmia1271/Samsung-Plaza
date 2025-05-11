<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
	@media print {

		aside,
		.panel-heading,
		.panel-footer,
		nav,
		.none {
			display: none !important;
		}

		.panel {
			border: 1px solid transparent;
			left: 0px;
			position: absolute;
			top: 0px;
			width: 100%;
		}

		.hide {
			display: block !important;
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

	.md15 {
		padding: 0 15px !important;
	}

	.Receivable {
		color: green;
		font-weight: bold;
	}

	.Payable {
		color: red;
		font-weight: bold;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<?php  echo $this->session->flashdata('confirmation'); ?>
		<div class="panel panel-default" id="data">
			<div class="panel-heading">
				<div class="panal-header-title">
					<?php $slug = $this->uri->segment(4); ?>
					<?php if($slug != 'due'){ ?>
					<h1 class="pull-left">View All Supplier</h1>
					<?php }else{ ?>
					<h1 class="pull-left">Supplier Due</h1>
					<?php } ?>
					<a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
						onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
			</div>
			<div class="panel-body">
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->
				<!--<h4 class="text-center hide" style="margin-top: 0px;">All Supplier</h4>-->

				<div class="col-md-12 text-center hide">
					<h3>All Supplier</h3>
				</div>


				<div class="row md15 none">
					<?php
					echo $this->session->flashdata('deleted');
					$attr = array("class" => "form-horizontal");
					echo form_open("", $attr);
					?>
					<div class="form-group">
						<label class="col-md-2 control-label">Supplier Name </label>
						<div class="col-md-4">
							<select name="party_code" class="selectpicker form-control" data-show-subtext="true"
								data-live-search="true">
								<option value="" selected disabled>--Select---</option>
								<?php if($allParty != null){ foreach($allParty as $key => $row){ ?>
								<option value="<?php echo $row->code; ?>">
									<?php echo filter($row->name); ?>
								</option>
								<?php }} ?>
							</select>
						</div>

					<?php if($this->data['privilege'] == 'super') { ?>
                     <div class="col-md-3">
                        
                        <select  name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>-- Select Showroom --</option>
                            <option value="all">All Showroom</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    
                    <?php }else{ ?>
                    
                         <input type="hidden" name="godown_code" value ='<?php echo $this->data['branch']; ?>' >
                    <?php } ?>
                    </div>

						<div class="col-md-1">
							<div class="btn-group">
								<input type="submit" name="show" value="Show" class="btn btn-primary">
							</div>
						</div>
					</div>

					<?php echo form_close(); ?>
				</div>


				<div class="row md15">
					<div class="table-responsive">
						<p> <span style="color: green;font-weight: bold;">Green = Receivable</span>&nbsp;<span
								style="color: red;font-weight: bold;">Red = Payable</span></p>

						<table class="table table-bordered">
							<tr>
								<th style="width: 50px;">SL</th>
								<?php if($slug == 'due'){  ?>
								<th>Supplier ID</th>
								<?php } ?>
								<th>Showroom</th>
								<th>Name</th>
								<th>Contact Person</th>
								<th>Mobile</th>
								<th>Current Balance</th>
								<!--<th>Type</th>-->
								<?php if($slug != 'due'){  ?>
								<th class="none">Status</th>
								<th class="none" style="width: 170px;">Action</th>
								<?php } ?>
							</tr>
							<?php
							    $total = 0.00;
							foreach ($results as $key => $value) {
								$showroom = get_name('godowns', 'name', ['code'=>$value->godown_code]);
							?>
							<tr>
								<td><?php echo $key+1; ?></td>
								<?php if($slug == 'due'){ ?>
								<td><?php echo filter($value->code); ?></td>
								<?php } ?>
								<td><?php echo filter($showroom); ?></td>
								<td><?php echo filter($value->name); ?></td>
								<td><?php echo filter($value->contact_person); ?></td>
								<td><?php echo $value->mobile; ?></td>
								<?php
									// Calculate Balance from partytrasaction table.
									// Final balance = total_debit - total_credit + initial_balance.
									// Final Balance (+ve) = Receivable and (-ve) = Payable
								$where = array(
									'party_code' => $value->code,
									'trash' => 0
								);
								$balance = 0;
								$transactionRec = $this->retrieve->read('partytransaction', $where);
								if (!empty($transactionRec)) {
								    $total_credit = $total_debit = $currentBalance = 0.0;
								    
									foreach ($transactionRec as $key => $row) {
										$total_credit += $row->credit;
										$total_debit += $row->debit;
									}
									
    								if($value->initial_balance > 0){
                                        $balance = ($value->initial_balance + $total_debit) - $total_credit;
                    	   			}else{
                                        $balance = $total_debit - ($total_credit + abs($value->initial_balance));
                    	   			}
                    	   			
									$balance_status = ($balance >= 0) ?  "Receivable" : "Payable";
									$balanceStatus = ($balance >= 0) ?  "" : " - ";
								}else{
									$balance = $value->initial_balance;
									$balance_status = ($balance >= 0) ?  "Receivable" : "Payable";
									$balanceStatus = ($balance >= 0) ?  "" : "  - ";
								}
								
								?>
								<th class="text-center <?php echo $balance_status; ?>">
									<?php 
								    $total += $balance; 
								    echo $balanceStatus.f_number(abs($balance)); ?>
								</th>
								<!--<th class="<?php //echo $balance_status; ?>" ><?php //echo $balance_status; ?> </th>-->
								<?php if($slug != 'due'){  ?>
								<td class="none"><?php echo filter($value->status); ?></td>


								<td class="none">
    									<a class="btn btn-info" title="Preview"
    										href="<?php echo site_url('supplier/supplier/preview/'.$value->id);?>"><i
    											class="fa fa-eye" aria-hidden="true"></i></a>
                                 	<?php 
                                        $privilege = $this->data['privilege'];
                                        if($privilege != 'user'){
                                    ?>    
    									<a class="btn btn-warning" title="Edit"
    										href="<?php echo site_url('supplier/supplier/edit/'.$value->id);?>"><i
    											class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    									<a onclick="return confirm('Do you want to delete this information?');"
    										class="btn btn-danger" title="Delete"
    										href="<?php echo site_url('supplier/supplier/delete/'.$value->code); ?>"><i
    											class="fa fa-trash-o" aria-hidden="true"></i></a>
								  <?php } ?>
								    
								</td>
								<?php } ?>
							</tr>
							<?php } ?>
							<tr>
								<?php if($slug == 'due'){ ?>
								<th colspan="6" class="text-right">
									Total
								</th>
								<?php }else{ ?>
								<th colspan="5" class="text-right">
									Total
								</th>
								<?php } ?>
								<th class="text-center">
									<?php echo (!empty($balanceStatus) ? $balanceStatus : '').f_number(abs($total)); ?> Tk
								</th>
								<?php if($slug != 'due'){  ?>
								<th class="none"></th>
								<th class="none"></th>
								<?php } ?>
							</tr>

						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">&nbsp;</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>