<style>
.mrgb-15{margin-bottom: 15px;}
</style>
<div class="container-fluid">
  <div class="row">
  <?php echo $confirmation; ?>
  <div class="panel panel-default">
    <div class="panel-heading panal-header">
      <div class="panal-header-title pull-left">
        <h1>Edit Supplier</h1>
      </div>
    </div>
    <div class="panel-body">
      <?php
      $attr = array("class"=>"form-horizontal");
      echo form_open('', $attr);
      ?>
      
      <input type="hidden" name="code" class="form-control" value="<?php echo $info[0]->code; ?>" readonly>
       
      <div class="form-group">
        <label class="col-md-3 control-label">Supplier</label>
        <div class="col-md-5">
          <input type="text" name="name" class="form-control"  value="<?php echo $info[0]->name; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Contact Person</label>
        <div class="col-md-5">
          <input type="text" name="contact_person" class="form-control" value="<?php echo $info[0]->contact_person; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Mobile Number </label>
        <div class="col-md-5">
          <input type="text" name="mobile" class="form-control" value="<?php echo $info[0]->mobile; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Address </label>
        <div class="col-md-5">
          <textarea name="address" cols="15" rows="5" class="form-control"><?php echo $info[0]->address; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Initial Balance (TK)</label>
        <div class="col-md-3">
          <input type="number" name="initial_balance" class="form-control" min=0 step="any" value="<?php echo abs($info[0]->initial_balance); ?>">
        </div>
        <div class="col-md-2">
          <select name="balance_type" class="form-control">
            <option <?php if($info[0]->initial_balance >= 0){echo "selected";} ?> value="receivable">Receivable</option>
            <option <?php if($info[0]->initial_balance < 0){echo "selected";} ?> value="payable">Payable</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">Status </label>
        <div class="col-md-5">
          <label class="radio-inline">
            <input <?php if($info[0]->status == "active"){echo "checked";} ?> type="radio" name="status" value="active"> Active
          </label>
          <label class="radio-inline">
            <input <?php if($info[0]->status == "deactivate"){echo "checked";} ?> type="radio" name="status" value="deactivate"> Deactivate
          </label>
        </div>
      </div>
      <div class="col-md-8">
        <div class="btn-group pull-right">
          <input type="submit" name="update" value="Update" class="btn btn-success">
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
  </div>
</div>
</div>