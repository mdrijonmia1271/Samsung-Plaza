<script src="<?php echo site_url('private/js/ngscript/SaleEntryCtrl.js')?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
  .table2 tr td{padding: 0 !important;}
  .table2 tr td input{border: 1px solid transparent;}
  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button{-webkit-appearance: none;margin: 0;}
  input[type=number] {-moz-appearance: textfield;}
</style>

<div class="container-fluid" ng-controller="SaleEntryCtrl">
  <div class="row">
    <?php echo $confirmation; ?>
    <div class="panel panel-default">
      <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
          <h1>Add Sale</h1>
        </div>
        <div class="panal-header-title pull-left">
          <p style="color: red;font-weight:bold; margin-left: 25px;"><?php echo ($last_voucher)? "Last voucher: ".$last_voucher[0]->voucher_no : " " ;?></p>
        </div>
      </div>
      <div class="panel-body" ng-cloak>
        
        <form ng-submit="addNewProductFn()">
            
            <div class="col-md-4">
                <!--<select name="product" ng-model='product' class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                  <option value="" selected disabled>-- Select Product--</option>
                  <?php if($allProducts != null){ foreach($allProducts as $key => $product){ ?>
                  <option value="<?php echo $product->code; ?>"><?php echo filter($product->name); ?></option>
                  <?php }} ?>
                </select>-->
                
                <input type="text" ng-model="product_serial" class="form-control" name="product">
            </div>
            
            <input type="submit" style="display:none;">
        </form>
        
        
        <!-- horizontal form -->
        <?php
        $attr = array('class' => 'form-horizontal');
        echo form_open('', $attr);
        ?>
        <div class="row">
            
          <div class="col-md-3">
            <div class="form-group">
              <div class="col-md-12">
                <div class="input-group date" id="datetimepicker">
                  <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
          
          <!--div class="col-md-3">
            <div class="form-group">
              <div class="col-md-12">
                <input type="text" name="voucher_number"
                value="<?php if($voucher_number != NULL){echo $voucher_number;} ?>"
                placeholder="Voucher No" class="form-control" readonly>
              </div>
            </div>
          </div-->
          
          
          <!--div class="col-md-2">
            <div>
              <a class="btn btn-success" ng-click="addNewProductFn()">
                <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
              </a>
            </div>
          </div-->
          
        </div>
        
        
        <hr>
        <table class="table table-bordered table2">
          <tr>
            <th style="width: 40px;">SL</th>
            <th style="width:275px;">Product Name</th>
            <th width="80px">Unit</th>
            <th width="80px">Stock</th>
            <th width="80px">Quantity</th>
            <th width="100px">Sale Price</th>
            <th width="100px">Total</th>
            <th style="width: 50px;">Action</th>
          </tr>
          <tr ng-repeat="item in cart">
            <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
            <td>
              <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
              <input type="hidden" name="product_code[]" value="{{ item.product_code }}">
              <input type="hidden" name="product_serial[]" value="{{ item.product_serial }}">
            </td>
            <td>
              <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
            </td>
            <td>
              <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
            </td>
            <td>
              <input type="number" name="quantity[]" class="form-control" min="1" max="{{ item.maxQuantity }}" ng-model="item.quantity" step="any">
            </td>
            <td>
              <input type="number" name="sale_price[]" class="form-control" min="0" ng-model="item.sale_price" step="any">
              <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
            </td>
            <td>
              <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
              <input type="hidden"  ng-value="purchaseSubtotalFn($index)" step="any">
            </td>
            <td class="text-center">
              <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                <i class="fa fa-times fa-lg"></i>
              </a>
            </td>
          </tr>
      </table>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-md-3 control-label">Sale Type <span class="req">&nbsp;</span></label>
            <div class="col-md-9">
              <label ng-click="getsaleType('cash')">
                <input type="radio" name="stype"  ng-model="stype" checked value="cash">
                <span>Cash</span>
              </label>
              <label ng-click="getsaleType('credit')" style="margin-left: 20px;">
                <input type="radio" name="stype"  ng-model="stype" value="credit">
                <span>Credit</span>
              </label>
            </div>
          </div>
          <div  ng-init="active=true;" ng-show="active">
            <div class="form-group">
              <label class="col-md-3 control-label">Client </label>
              <div class="col-md-9">
                <input type="text" name="name" class="form-control" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Mobile</label>
              <div class="col-md-9">
                <input type="text" name="mobile_number"  class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Address </label>
              <div class="col-md-9">
                <textarea name="details_address" rows="4" class="form-control" ></textarea>
              </div>
            </div>
          </div>
          <div ng-init="active1=false;" ng-show="active1">
            
            <div class="form-group">
              <label class="col-md-3 control-label">Client</label>
              <div class="col-md-9">
                <select
                name="code"
                ng-model="partyCode"
                ng-change="findPartyFn()"
                class="selectpicker form-control"
                data-show-subtext="true"
                data-live-search="true" >
                <option value="" selected disabled>&nbsp;</option>
                <?php
                if($allClients != null){
                  foreach ($allClients as $key => $row) {
                    ?>
                    <option value="<?php echo $row->code; ?>">
                      <?php echo $row->code."-".filter($row->name)."-".$row->mobile; ?>
                    </option>
                    <?php }} ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Mobile  </label>
                <div class="col-md-9">
                  <input type="text" name="mobile" ng-model="partyInfo.contact" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Address </label>
                <div class="col-md-9">
                  <textarea name="address" class="form-control" readonly>{{ partyInfo.address }}</textarea>
                </div>
              </div>
            </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="col-md-4 control-label"> Total Quantity </label>
          <div class="col-md-8">
            <input type="number" name="totalqty" ng-value="getTotalQtyFn()" class="form-control" step="any" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label"> Total </label>
          <div class="col-md-8">
            <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
            <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control" readonly>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label">Commission (%)</label>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-5">
                <input type="number" ng-model="amount.discount_percentage" class="form-control" step="any">
              </div>
              <div class="col-md-7">
                <input type="text" name="total_discount" ng-value="calculateDiscountFn()" class="form-control" readonly>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-4 control-label">Grand Total</label>
          <div class="col-md-8">
            <input type="number" name="grand_total" ng-value="getGrandTotalFn()" class="form-control" step="any" readonly>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-4 control-label">Previous Balance </label>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-7">
                <input type="number" name="previous_balance" ng-model="partyInfo.balance" class="form-control" step="any" readonly>
              </div>
              <div class="col-md-5">
                <input type="text" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
              </div>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-4 control-label">{{ payment_label }}</label>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-7">
                <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
              </div>
              <div class="col-md-5">
                <select
                name="method"
                class="form-control"
                ng-init="transactionBy='cash'"
                ng-model="transactionBy" required>
                <option value="cash">Cash</option>
                <option value="cheque">Cheque</option>
                <option value="bKash">bKash</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      
      <!-- for selecting cheque -->
      <div ng-if="transactionBy == 'cheque'">
        <div class="form-group">
          <label class="col-md-4 control-label">
            Bank Name <span class="req">*</span>
          </label>
          <div class="col-md-8">
            <select  name="meta[bankname]" class="form-control">
              <option value="" selected disabled>&nbsp;</option>
              <?php foreach (config_item("banks") as $key => $value) { ?>
              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label">
            Branch Name <span class="req">*</span>
          </label>
          <div class="col-md-8">
            <input type="text" name="meta[branchname]" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label">
            Cheque No <span class="req">*</span>
          </label>
          <div class="col-md-8">
            <input type="text" name="meta[chequeno]" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label">
            Pass Date <span class="req">*</span>
          </label>
          <div class="col-md-8">
            <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD" class="form-control">
            <input type="hidden" name="meta[status]" value="pending">
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <!--label class="col-md-4 control-label">Current Balance </label-->
        <label class="col-md-4 control-label">Due</label>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-7">
              <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
            </div>
            <div class="col-md-5">
              <input type="text" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-group" ng-if="stype=='credit' && partyInfo.csign=='Receivable'">
        <label class="col-md-4 control-label">Installment Type</label>
        <div class="col-md-8">
            <select name="installment_type" class="form-control">
                <option value="" selected disabled> Select </option>
                <option value="monthly">Monthly</option>
                <option value="weekly">Weekly</option>
            </select>
        </div>
      </div>
      
      
      <div class="form-group" ng-if="stype == 'credit' && partyInfo.csign=='Receivable'">
		<label class="col-md-4 control-label">Installment Number</label>
		<div class="col-md-8">
		  <div class="row">
			<div class="col-md-5">
			  <input type="number" name="installment_number" ng-model="installment_number" ng-change="calculate_installment_amount(installment_number);" class="form-control" step="any" min="0">
			</div>
			<div class="col-md-7">
			  <input type="number" name="installment_amount" ng-value="installment_amount" class="form-control" readonly>
			</div>
		  </div>
		</div>
	  </div>
      
      <div class="form-group" ng-if="stype=='credit' && partyInfo.csign=='Receivable'">
        <label class="col-md-4 control-label">Installment Date</label>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <input type="text" name="installment_date" placeholder="YYYY-MM-DD" class="form-control">
            </div>
          </div>
        </div>
      </div>
      

    </div>
  </div>
  <div class="btn-group pull-right">
    <input
    type="submit"
    name="save"
    value="Save"
    class="btn btn-primary"
    ng-init="isDisabled=false;">
  </div>
  
  <?php echo form_close(); ?>
</div>
<div class="panel-footer">&nbsp;</div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>