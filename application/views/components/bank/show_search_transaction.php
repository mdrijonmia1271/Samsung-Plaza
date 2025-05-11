<!-- add account page start here -->
<style type="text/css">
 .bank-table h3{
		display: none;
	}
	.bank-table{
		width: 100%;
		height: 80px;
	}
	.bank-table button{
		float: left;
	}
	
    
    @media print{
    
    
        nav,
        header,
        aside,
        form,
        .form-element{
            display: none;
        }
		.bank-table h3{
			display: block;
			text-align: center;
			font-weight: bold;
		}
		.bank-table button{
			display: none;
		}
		table{
			width: 100%;
		}
		table, tr, th, td{
			border: 1px solid #000;
			border-collapse: collapse;
		}
		table tr th,
		table tr td{
			text-align: left !important;
			padding: 0 5px;
		}
		table#cost-table tr th:nth-child(1),
		table#cost-table tr td:nth-child(1){
			text-align: center !important;
		}
		table#income-table tr th:nth-child(1),
		table#income-table tr td:nth-child(1){
			text-align: center !important;
		}
	}


</style>
<div class="column global-pad">
    <div class="row">
	    <?php 
        $attribute_one = array(
            'name' => '',
            'class' => 'horizontal',
            'id' => ''
        );
        echo form_open_multipart('bank/bankInfoView/search', $attribute_one);
        ?>
		
        <blockquote class="form-head">
            <h1>Search Bank Transaction</h1>
            <small>
				1. Fill all the required <mark>*</mark> fields<br/>
				2. Click the <mark>Show</mark> button to view data 
            </small>
        </blockquote>

        <div class="form-content">

            <div class="form-element">
                <label>Select Bank <sup class="required"></sup></label>
                <select name="bank_name" required>
                    <option value="">-- Select one --</option>
                    <option value="b1">Sonali Bank Limited</option>
                    <option value="b2">Janata Bank Limited</option>
                    <option value="b3">Agrani Bank Limited</option>
                    <option value="b4">Rupali Bank Limited</option>
                    <option value="b5">AB Bank Limited</option>
                    <option value="b6">Jamuna Bank Limited</option>
                    <option value="b7">National Bank Limited</option>
                    <option value="b8">NCC Bank Limited</option>
                    <option value="b9">Prime Bank Limited</option>
                    <option value="b10">Standard Bank Limited</option>
                    <option value="b11">The City Bank Limited</option>
                    <option value="b12">Trust Bank Limited</option>
                    <option value="b13">Islami Bank Bangladesh Limited</option>
                    <option value="b14">The City Bank Limited</option>
                </select>
            </div>

            <div id="acc-id">
                <div class="form-element">
                    <label>Account number <sup class="required"></sup></label>
                    <select name="account_no" required>
                        <option value="">-- Select one --</option>                       
                    </select>
                </div>
            </div>
			
			
			 <div class="form-element">
                <label for="in1">Date (from) <sup class="required"></sup></label>
                <input type="text" required class="date-picker" name="date_from" id="in1" placeholder="YYYY-MM-DD" />
            </div>

            <div class="form-element">
                <label for="in2">Date (to) <sup class="required"></sup></label>
                <input type="text" required class="date-picker" name="date_to" id="in2" placeholder="YYYY-MM-DD" />
            </div>
			
			
			
        </div>
            
        <blockquote class="form-foot">
            <input type="submit" class="button" name="submit" value="Show" />
        </blockquote>

        <?php echo form_close(); ?>
<?php
          if($bank_record!= NULL)
          {
          ?>
        
         <div class="bank-table">
			<h3>Bank Transaction</h3>
			<button class="button" onclick="window.print();"><i class="fa fa-print"></i> Print </button>
         </div>
       
        <table id="transition-table">
            <thead>
                <tr>               
                    <th>Date</th>
                    <th>Transaction by</th>
                    <th>Debit (tk)</th>
                    <th>Credit (tk)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
				
				
			<?php 
			 $dd=0;
			 $cc=0;
				foreach($bank_record as $value):
				  {
					?>				
				
                   <tr>
                    <td><?php  echo $value->datetime;?></td>
                    <td><?php  echo $value->transaction_by;?></td>
                    <td>
					    <?php  
						    $d=$value->debit;
							echo $d;
						 ?>
					  </td>
                    <td>
						   <?php
							   $c=$value->credit;
							   echo $c;
							?>
					  </td>
                   </tr>
				   <?php 
				   $dd=$dd+$d;
				   $cc=$cc+$c;
				  }
				endforeach;
			?>
              
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>&nbsp;</td>
                    <td><?php  echo $dd; ?></td>
                    <td><?php  echo $cc; ?></td>
                </tr>
            </tbody>
        </table>
         <?Php
        }
        else
        {
           echo "<h3 style='text-align:center;color:red;font-weight:bold;'>No Transaction Found.</h3>";
        }
        ?>
        
    </div>
    
    <script type="text/javascript">
		$(document).ready(function(){
			$('select[name="bank_name"]').on('change', function(event){
				event.preventDefault();			
			
				//var cond = {'bank_name': };	// class means field name .it is object type variable				
				
				$.ajax({
					type: 'POST',
					url: '<?php echo site_url(); ?>ajax/getAllItems/transaction',
					data: 'condition=' + $(this).val()
				}).done(function(response){
							var obj = $.parseJSON(response),
								data = [];
								
							$.each(obj, function(index, element){
								data.push('<option value="'+element.account_number+'">'+element.account_number+'</option>');
							});
							
                            $('select[name="account_no"]').html(data);
							console.log(obj);
						});
				
				console.log(response);
			});
			
	
					/* $('form').on('submit', function(event){
						event.preventDefault();	
						// class means field name .it is object type variable
						var cond = {
							//'bank_name':$(this).val(),
							'account_no':$('selcet[name="account_no"]').val()
							//'date-from':$(this).val(),
							//'date-to':$(this).val()
						};				
						
						$.ajax({
							type: 'POST',
							url: '<?php echo site_url(); ?>ajax/retrieveBy/transaction',
							data: 'condition=' + JSON.stringify(cond)
						}).done(function(response){
							var obj = $.parseJSON(response),
								data = [];
							// set table header
							data.push('<tr><th>#</th><th>Date</th><th>Transaction by</th><th>Debit</th><th>Credit</th></tr>');
							data.push('<tr><td colspan="5">&nbsp;</td></tr>');
							// for each object
							$.each(obj, function(index, element){
								data.push('<tr>'
									+'<td>'+ (index+1) +'</td>'
									+'<td>'+ element.datetime +'</td>'
									+'<td>'+ element.transaction_by +'</td>'
									+'<td>'+ element.transaction_type +'</td>'
									+'<td>'+ element.transaction_type +'</td>'
									+'</tr>');
							});
							data.push('<tr><td colspan="5">&nbsp;</td></tr>');
							// replace in the table
							$('table').html(data);
							console.log(obj);
						});
					// show the table	
					$('div#transition-table').removeClass('hide');
				});	*/			
					
		});
	</script>
</div>
<!-- add account page end here -->



