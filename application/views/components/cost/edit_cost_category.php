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
     <div class="panel panel-default">      
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Cost Category</h1>
                </div>
            </div>

            <div class="panel-body">
                       
                <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                echo form_open("cost_category/cost_category/edit", $attr);
                ?>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label>Field Of Cost Category</label>
                        </div>                            
                        <div class="col-md-6">
                            <input type="text" name="cost_category"  value="<?php echo $row[0]->cost_category; ?>" class="form-control" >
                            <input type="hidden" name="id"  value="<?php echo $row[0]->id; ?>" class="form-control" >
                        
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="update"  value="Update" class="btn btn-primary" >
                        </div>
                    </div>

                          

                    </div>
                    <?php echo form_close(); ?>   
                  </div>
            <div class="panel-footer">&nbsp;</div>
        </div>


