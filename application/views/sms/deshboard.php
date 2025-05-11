<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Control Panel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<style type="text/css">
		.card-head>h4{
			padding: 10px 25px;
			color: #000;
		}
	</style>
</head>
<body style="background: #dee2e6;">
	<div class="container">
		<div class="card mt-3" style="min-height: 95vh;">
			<div class="card-head" style="background: #f0f3f5;">
			    <h4>SMS MODULE <small><a href="<?php echo site_url('smsControl/logout');?>" class="float-right">Logout</a></small></h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
    							<form method="post" action="<?php echo site_url('smsControl/SmsUpdate');?>">
    							    <div class="form-group">
    									<label for="date"><strong>Date</strong></label>
    									<input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d');?>" readonly="true">
    								</div>
    								<div class="form-group">
    									<label for="pre_sms"><strong>Previous SMS</strong></label>
    									<input type="text" class="form-control" value="<?php echo $this->data['total_sms'][0]->sms;?>" readonly="true">
    								</div>
    								<div class="form-group">
    									<label for="Amount"><strong>Amount</strong></label>
    									<input type="text" class="form-control" name="amount" placeholder="Enter Amount" id="amount" autocomplete="off" value="">
    								</div>
    								<div class="form-group">
    									<label for="total_sms"><strong>SMS</strong></label>
    									<input type="text" class="form-control" name="sms" id="sms" value="0" readonly="true">
    								</div>
    								<div class="form-group">
    									<input type="submit" class="btn btn-success float-right" value="Submit">
    								</div>
    							</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
					    <table class="table table-bordered">
							<tr>
								<th width="10%">SL</th>
								<th>Date</th>
								<th>Amount</th>
								<th>SMS</th>
							</tr>
						    <?php 
						        $total_amount = 0;
						        $total_sms = 0;
						        foreach($this->data['sms'] as $key=>$row){ ?>
    							<tr>
    							    <td><strong><?php echo $key+1;?></strong></td>
    								<td><?php echo $row->date; ?></td>
    								<td><?php echo $row->amount; $total_amount += $row->amount; ?></td>
    								<td><?php echo $row->sms; $total_sms += $row->sms;?></td>
    							</tr>    	
							<?php } ?>
							<tr>
								<td colspan="2" class="text-right"><strong>Total</strong></td>
								<td><strong><?php echo $total_amount;?> TK</strong></td>
								<td><strong><?php echo $total_sms;?></strong></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<script>
		amount.focus();
		amount.onkeyup=function(){
			sms.value = parseInt(this.value*2);
		}

	</script>
</body>
</html>
