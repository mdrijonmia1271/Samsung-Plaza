<script src="<?php echo site_url('private/js/ngscript/multiSaleReturn.js?').time(); ?>"></script>

<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
  .table2 tr td {
    padding: 0 !important;
  }

  .table2 tr td input {
    border: 1px solid transparent;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }
</style>

<div class="container-fluid" ng-controller="multiSaleReturn" ng-cloak>
  <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading panal-header">
        <div class="panal-header-title pull-left">
          <h1>Add Return Product</h1>
        </div>
      </div>
      <div class="panel-body" ng-cloak>
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
                  <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control"
                    placeholder="YYYY-MM-DD" required>
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <?php if(checkAuth('super')) { ?>
          <div class="col-md-3">
            <select class="form-control" ng-model="godown_code" ng-change="getAllProductsFn()">
              <option value="" selected disabled>-- Select Showroom --</option>
              <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
              <option value="<?php echo $row->code; ?>">
                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
              </option>
              <?php } } ?>
            </select>
          </div>
          <?php } else { ?>
          <input type="hidden" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-model="godown_code" ng-value="godown_code"
            required>
          <?php } ?>

          <div class="col-md-4">
            <select ui-select2="{ allowClear: true}" class="form-control" ng-model='product_code'
              data-placeholder="Select Product" ng-change="addNewProductFn()" required>
              <option value="" selected disable> </option>
              <option ng-repeat="product in allProducts" value="{{product.code}}">{{product.product_model | textBeautify }}</option>
            </select>
          </div>

        </div>

        <hr>
        <table class="table table-bordered table2">
          <tr>
            <th style="width: 40px;">SL</th>
            <th style="width:275px;">Product Name</th>
            <th style="width:275px;">Product Model</th>
            <th width="100px">Stock</th>
            <th width="80px">Unit</th>
            <th width="80px">Quantity</th>
            <th width="100px">Return Price</th>
            <th width="100px">Total</th>
            <th style="width: 50px;">Action</th>
          </tr>
          <tr ng-repeat="item in cart">

            <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

            <td>
              <input type="text" name="category[]" class="form-control" ng-value="item.category | textBeautify" readonly>
              <input type="hidden" class="form-control" name="godown" ng-value="item.godown_code">
              <input type="hidden" name="product[]" class="form-control" ng-value="item.product" readonly>
              <input type="hidden" name="product_code[]" ng-value="item.product_code">
              <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
              <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
            </td>

            <td>
              <input type="text" class="form-control" name="product_model[]" ng-value="item.product_model" readonly>
            </td>
            
            <td>
              <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
            </td>

            <td>
              <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
            </td>

            <td>
              <input type="number" name="quantity[]" class="form-control" min="1" ng-model="item.quantity" step="any">
            </td>

            <td>
              <input type="number" name="return_price[]" class="form-control" min="0" ng-model="item.sale_price"
                step="any">
            </td>

            <td>
              <input type="number" class="form-control" name="product_total[]" ng-value="setSubtotalFn($index)"
                readonly>
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
            <div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Client</label>
                    <div class="col-md-9">
                      <select ui-select2="{ allowClear: true}" class="form-control" name="code" ng-model="partyCode" ng-change="findPartyFn()"
                        data-placeholder="Select Client" required>
                        <option value="" selected disable> </option>
                        <option ng-repeat="client in clientList" value="{{client.code}}">{{ client.code + " - " + client.name +"-"+ client.mobile}}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Mobile </label>
                    <div class="col-md-9">
                      <input type="text" name="mobile" ng-model="partyInfo.contact" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Address </label>
                    <div class="col-md-9">
                      <textarea name="address" class="form-control"
                        readonly>{{ partyInfo.address  | textBeautify | removeDash }}</textarea>
                    </div>
                  </div>
              
                <div class="form-group">
                    <label class="col-md-3 control-label">Comment </label>
                    <div class="col-md-9">
                        <textarea name="comment" rows="4" class="form-control"></textarea>
                    </div>
                </div>

            </div>
            <hr>
          </div>
          <div class="col-md-6">


            <div class="form-group">
              <label class="col-md-4 control-label"> Total Quantity </label>
              <div class="col-md-8">
                <input type="number" name="totalQty" ng-value="getTotalQtyFn()" class="form-control" step="any"
                  readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label"> Total </label>
              <div class="col-md-8">
                <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control"
                  readonly>
              </div>
            </div>


            <div class="form-group hide">
              <label class="col-md-4 control-label">Commission(%)</label>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-7">
                    <select class="form-control" name="meta[commission]" ng-model="commission"
                      ng-change="calculateTotalCommission();">
                      <option value="" selected disabled>-Commission-</option>
                      <?php for ($i=10; $i<=30 ; $i++) {  ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php } ?>
                      <input type="hidden" name="meta[remaining_commission]" ng-value="remaining_commission">
                    </select>
                  </div>

                  <div class="col-md-5">
                    <input type="text" name="total_commission" ng-model="total_commission_amount" class="form-control"
                      readonly>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group hide">
              <label class="col-md-4 control-label">Discount</label>
              <div class="col-md-8">
                <input type="number" name="discount" ng-model="total_discount" min="0" class="form-control" step="any">
              </div>
            </div>

            <div class="form-group hide">
              <label class="col-md-4 control-label">Sub Total</label>
              <div class="col-md-8">
                <input type="number" name="sub_total" ng-value="getGrandTotalFn()" class="form-control" step="any"
                  readonly>
              </div>
            </div>

            <div class="form-group hide">
              <label class="col-md-4 control-label">Extra Comm.(%)</label>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-7">
                    <select class="form-control" name="meta[extra_commission]" ng-model="extraCommission"
                      ng-change="calculateExtraTotalCommission();">
                      <option value="" selected disabled>-Commission-</option>
                      <?php for ($i=1; $i<=10 ; $i++) {  ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-5">
                    <input type="text" name="extra_commission" ng-model="extra_commission_amount" class="form-control"
                      readonly>
                  </div>
                </div>
              </div>
            </div>


            <div class="form-group hide">
              <label class="col-md-4 control-label">Grand Total</label>
              <div class="col-md-8">
                <input type="number" name="grand_total" ng-value="GrandTotalFn()" class="form-control" step="any"
                  readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Previous Balance </label>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-7">
                    <input type="number" name="previous_balance" ng-model="partyInfo.balance" class="form-control"
                      step="any" readonly>
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Return Amount <span class="req">*</span></label>
              <div class="col-md-8">
                <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Current Balance </label>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-7">
                    <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control"
                      step="any" readonly>
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="btn-group pull-right">
          <input type="submit" name="return" value="Save" class="btn btn-primary">
        </div>

        <div class="btn-group pull-right">
          <p ng-bind="message" style="font-weight:bold;color:red;font-size:18px;"></p>
        </div>
        <?php echo form_close(); ?>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $('#datetimepicker').datetimepicker({
      format: 'YYYY-MM-DD'
    });
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>