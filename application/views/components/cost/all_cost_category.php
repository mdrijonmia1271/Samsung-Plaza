<style>
    @media print{
        aside, nav, .panel-heading, .panel-footer, .none{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
    }

</style>

<div class="container-fluid" >
        <?php echo $this->session->flashdata("confirmation"); ?>   
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Cost Category</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                echo form_open("cost_category/cost_category/add", $attr);
                ?>

                  <div class="form-group">
                        <div class="col-md-3">
                            <label>Cost Category</label>
                        </div>                            
                        <div class="col-md-5">
                            <input type="text" name="cost_category" class="form-control" >
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="save"  value="Save" class="btn btn-primary" >
                        </div>
                  </div>
                <?php echo form_close(); ?>                       
                 </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
         



     <div class="panel panel-default">      
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Cost Category</h1>
                </div>
                <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">

            <div class="row none">
                <div class="col-md-5">
                    <input type="text"  placeholder="Search By Name......"  id="menu_name_search" class="form-control"   onkeyup="menuSearch()" >
                </div>                
            </div>    
               <br class="none"><br class="none"> 
                <!-- Print banner Start Here -->
                    <?php $this->load->view('print', $this->data); ?>
                <!-- Print banner End Here -->

                <table class="table table-bordered"  id="myTable" >
                    <tr>
                        <th style="width:50px"> SL </th>
                        <th>Category</th>
                        <th style="width:150px" class="none"> Action </th>
                    </tr>

                    <?php 
                        foreach($resultset as $key => $row) { 
                    ?>
                        <tr>
                            <td style="width:50px"> <?php  echo $key+1; ?> </td>
                            <td> <?php  echo $row->cost_category; ?> </td>
                           <td style="width:150px" class="none"> 
                                <?php 
                                    $privilege = $this->data['privilege'];
                                    if($privilege != 'user'){
                                ?> 
                                
                                        <a href="<?php  echo site_url('cost_category/cost_category/edit_cost_category').'/'.$row->id; ?>" class="btn btn-warning"   >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
        
                                        <a href="<?php  echo site_url('cost_category/cost_category/delete').'/'.$row->id; ?>"  onclick="return confirm('Are you sure want to delete this Cost Category?');"  class="btn btn-danger">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>    
                                <?php  } ?>   
                            </td>                                                                       

                                                    
                           
                        </tr>
                    <?php } ?>
                   </table>
         </div>           
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
    </div>

<script>
    function menuSearch() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("menu_name_search");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }

 
</script>
