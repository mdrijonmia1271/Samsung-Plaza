<style>
  @media print{
  aside{display: none !important;}
  nav{display: none;}
  .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
  .none{display: none;}
  .panel-heading{display: none;}
  .panel-footer{display: none;}
  .panel .hide{display: block !important;}
  .title{font-size: 25px;}
  table tr th,table tr td{font-size: 12px;}
  }
  table.md5 tr th,table.md5 tr td{width: 25%;}
</style>

<div class="container-fluid" >
  <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">View Production</h1>
          <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

      <div class="panel-body" ng-cloak>
          <!-- Print banner -->
          <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

        <h4 class="text-center hide" style="margin-top: 0px;">Production</h4>
        <table class="md5 table table-bordered table-hover">
          <tr>
            <th>Date</th>
            <td><?php echo ($record) ? $record[0]->date : ""; ?></td>
            <th>Batch No.</th>
            <td><?php echo ($record) ? $record[0]->batch_no : ""; ?></td>
          </tr>

          <tr>
            <th>Product</th>
            <td>
                <?php
                   $code = ($record) ? $record[0]->finish_product : "";
                   $info = $this->action->read("materials",array("code" => $code));
                   $product = ($info) ? $info[0]->name : "";

                   echo filter($product);
                ?>
            </td>
            <th>Quantity</th>
            <td>
                <?php
                  echo ($record) ? $record[0]->quantity : "" ;
                  echo " ";
                  echo ($record) ? $record[0]->finish_unit : "";
               ?>
            </td>
          </tr>
        </table>

      <?php if($record != NULL) { ?>
        <table class="table table-bordered table-hover">
          <!-- <caption style="font-weight: bold;">Raw Material</caption> -->
          <tr>
              <th style="width:55px !important;">SL</th>
              <th>Raw Material</th>
              <th style="width:20% !important;">Quantity</th>
          </tr>
          <?php
           foreach ($record as $key => $value) {
             $info = $this->action->read("materials",array("code" => $value->raw_material));
             $raw_mat = ($info) ? $info[0]->name : "";
          ?>
              <tr>
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo filter($raw_mat); ?></td>
                   <td><?php echo $value->raw_quantity; ?></td>
              </tr>
         <?php }  ?>
        </table>
      <?php } ?>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
  </div>
</div>
