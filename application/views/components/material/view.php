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
</style>

<div class="container-fluid" >
  <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="panal-header-title">
          <h1 class="pull-left">View Material</h1>
          <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>

      <div class="panel-body" ng-cloak>
          <!-- Print banner -->
          <img class="img-responsive print-banner hide" src="<?php echo site_url($banner_info[0]->path); ?>">

        <h4 class="text-center hide" style="margin-top: 0px;">Material</h4>
        <table class="table table-bordered table-hover">
          <tr>
            <td>Date</td>
            <td><?php echo $records[0]->date; ?></td>
          </tr>
          <!-- <tr>
            <td width="40%">Code</td>
            <td><?php //echo $records[0]->code; ?></td>
          </tr> -->
          <tr>
            <td>Name</td>
            <td><?php echo filter($records[0]->name); ?></td>
          </tr>
          <tr>
            <td>Price</td>
            <td><?php echo $records[0]->price; ?> TK</td>
          </tr>
          
          <tr>
            <td>Status</td>
            <td><?php echo filter($records[0]->status); ?></td>
          </tr>
        </table>
      </div>
      <div class="panel-footer">&nbsp;</div>
    </div>
  </div>
</div>