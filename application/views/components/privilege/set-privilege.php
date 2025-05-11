<style>
    .deshitem {margin-bottom: 15px !important;} 
    .privilege tr th {white-space: nowrap;}
    .view {color: green;}
    .edit {color: #EC971F;}
    .checkbox-inline, .checkbox label, .radio label {font-weight: bold;padding-left: 0;}
    .checkbox label:after, .radio label:after {content: '';display: table;clear: both;}
    .checkbox .cr, .radio .cr {
        border: 1px solid #a9a9a9;
        display: inline-block;
        border-radius: .25em;
        position: relative;
        width: 1.3em;
        float: left;
        height: 1.3em;
        margin-right: 5px;
    }
    .checkbox-inline, .radio-inline+.radio-inline {
        margin-right: 10px !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
    }
    .radio .cr {border-radius: 50%;}
    .checkbox .cr .cr-icon, .radio .cr .cr-icon {
        position: absolute;
        font-size: .8em;
        line-height: 0;
        top: 50%;
        left: 20%;
    }
    .radio .cr .cr-icon {margin-left: 0.04em;}
    .checkbox label input[type="checkbox"], .radio label input[type="radio"] {display: none;}
    .checkbox label input[type="checkbox"] + .cr > .cr-icon, .radio label input[type="radio"] + .cr > .cr-icon {
        transform: scale(3) rotateZ(-20deg);
        opacity: 0;
        transition: all .3s ease-in;
    }
    .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon, .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
    .checkbox label input[type="checkbox"]:disabled + .cr, .radio label input[type="radio"]:disabled + .cr {opacity: .5;}
    #progress {display: none;}
</style>

<div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Set Privilege</h1>
                    <img id="progress" class="pull-right" src="#" alt=""></span>
                </div>
            </div>

            <div class="panel-body">
                <form action="" class="row">
                    <div class="col-md-4">
                        <label class="control-label">Privilege <span class="req">*</span></label>
                        <div class="form-group">
                            <select name="privilege" id="privilege" class="form-control" required>
                                <option value="">Select Menu</option>
                                <?php foreach ($privileges as $privilege) { ?>
                                    <option value="<?php echo $privilege->privilege; ?>">
                                        <?php echo filter($privilege->privilege); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">User Name<span class="req">*</span></label>
                        <div class="form-group">
                            <select name="user_id" id="user_id" class="form-control" required> </select>
                        </div>
                        <div class="col-md-12">
                            <hr style="margin-bottom: 0">
                        </div>
                    </div>
                </form>

                <div class="table-responsive privilege">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th rowspan="2" width="200" style="vertical-align: middle;">Menu Item
                                </th>
                                <th colspan="3">Navbar Items</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Dashboard Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="dashboard">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Dashboard</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="purchase">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="stock">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Stock
                                        </label>
                                    </div>
                                    
                              
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_purchase">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_hire_sale">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_due">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Due
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_total_paid">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Paid
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="bank_to_tt">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank To TT
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="supplier_paid">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier Paid
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="bank_withdraw">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank Withdraw
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="client_collection">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Client Collection
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="bank_deposit">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank Deposit
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="cash_to_tt">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cash To TT
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_cost">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            TOday's Cost
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_income">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today's Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_installment_list">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today Installment's List
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_commitment_list">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Today Commitment's List
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Category Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="category_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Category</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="category_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="category_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Subcategory Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="subCategory_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Subcategory</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="subCategory_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="subCategory_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Brand Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="brand_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Brand</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="brand_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="brand_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>


                            <!-- Color Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="colors_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Color</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="colors_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="colors_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Fixed Assate Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="fixed_assate_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Fixed Assate</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Field Of Fixed Assate
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Fixed Assate
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Fixed Assate
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Product Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="product_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Product</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="product_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Product
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="product_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Product
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Supplier Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="supplier-menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Supplier</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="supplier-menu" data-item="action" value="add">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Supplier
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="supplier-menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Supplier
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="supplier-menu" data-item="action" value="transaction">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="supplier-menu" data-item="action" value="all-transaction">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Transaction
                                        </label>
                                    </div>
                                </td>
                            </tr>


                            <!-- Zone Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="zone_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Zone</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="zone_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="zone_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <!-- Customer Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="client_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Customer</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="client_menu" data-item="action" value="add">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="client_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="client_menu" data-item="action" value="transaction">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Installment Collection
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="client_menu" data-item="action" value="all-transaction">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Installment Collection
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Customer Commitment Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="commitment_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Customer Commitment</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="commitment_menu" data-item="action" value="add">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="commitment_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Purchase Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="purchase_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Purchase</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu" data-item="action" value="add-new-mobile">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Mobile Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu" data-item="action" value="wise">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Item Wise
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu" data-item="action" value="createReturn">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase Return
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu" data-item="action" value="allReturn">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Return
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            
                            
                             <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="purchase_menu_elec">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Electronic Purchase</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu_elec" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Electronic Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu_elec" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Electronic Purchase
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu_elec" data-item="action" value="wise">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Item Wise Electronic
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu_elec" data-item="action" value="return">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Electronic Purchase Return
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="purchase_menu_elec" data-item="action" value="all_return">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Electronic Return
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Stock Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="raw_stock_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Stock</span>
                                    </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            
                              <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="raw_stock_menu_elec">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Electronic Stock</span>
                                    </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            

                            <!-- Sale Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="sale_menu_elec">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Electronic Sale</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="retail">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Retail Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="hire">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Hire Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="dealer">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Dealer Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="d_c">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Dealer Chalan
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="hire-all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Hire Sale
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="wise">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                           Search Item Wise
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="client_search">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Search Client Wise
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="return">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                           Sale Return
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu_elec" data-item="action" value="return-all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Sale Return
                                        </label>
                                    </div>
                                    
                                    
                                </td>
                            </tr>
                            
                            
                            
                            
                            
                            <!-- Sale Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="sale_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Sale</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="mobile_sale">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Mobile Sale
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            View All
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="wise">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Search Item Wise
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="mobile_sale_return">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Mobile Sale Return
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sale_menu" data-item="action" value="all_sale_return">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Sale Return
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Income Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="income_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Income</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Field Of Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Income
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="income_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Income
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Cost Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="cost_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Cost</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="all_cost_category">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cost Category
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Field Of Cost
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Cost
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="cost_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Cost
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            


                    <!-- Showroom trx Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="md_transaction_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Showroom Transaction</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="md_transaction_menu" data-item="action" value="field">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add New Investor
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="md_transaction_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Showroom Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="md_transaction_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Showroom Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="md_transaction_menu" data-item="action" value="balance">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Balance Report
                                        </label>
                                    </div>
                                </td>
                            </tr>


                            <!-- Due List Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="due_list_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Due List</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="cash">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Retail Due
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="retail_due_collection">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Retail Due Collection
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="dealer_list">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Dealer Due
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="due_list_menu" data-item="action" value="supplier_list">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier Due
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Banking Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="bank_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Banking</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-bank">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Bank
                                        </label>
                                    </div>
                                    
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Account
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="all-acc">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Account
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="add">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bank Ledger
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="bank_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Transaction
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Employee Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="employee_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Employee</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="employee_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Employee
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="employee_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Employee
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Salary Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="salary_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Salary</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="salary_menu" data-item="action" value="salary">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Basic
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="salary_menu" data-item="action" value="bonus">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Bonus
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="salary_menu" data-item="action" value="advanced">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Advanced
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="salary_menu" data-item="action" value="payment">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Payment
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="salary_menu" data-item="action" value="all_payment">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Payment
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Loan Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="loan-menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Loan</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="loan-menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            New Loan
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="loan-menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Loan
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="loan-menu" data-item="action" value="trans">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Transaction
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="loan-menu" data-item="action" value="all_trx">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Transaction
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Ledger Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Ledger</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="company-ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Supplier Ledger
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="client-ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Customer Ledger
                                        </label>
                                    </div>
                                    <!--<div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="dealer-ledger">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Dealer Ledger 
                                        </label>
                                    </div>-->
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="ledger" data-item="action" value="brand">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Brand Ledger
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Report Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="report_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Report</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="purchase_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="purchase_report_item">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase Item Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="sales_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Sale Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="sales_report_item">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Sale Item Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="income_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Income Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="cost_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cost Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="client_profit">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Profit/Loss
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="balance_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Cash Book
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="report_menu" data-item="action" value="sale-profit">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Sale Profit
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Analytical Report Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="analytical_report_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Analytical Report</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="analytical_report_menu" data-item="action" value="client_report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Sales Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="analytical_report_menu" data-item="action" value="client_collection">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Collection Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="analytical_report_menu" data-item="action" value="supplier_purchase">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Purchase Report
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="analytical_report_menu" data-item="action" value="supplier_payment">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Payment Report
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Mobile SMS Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="sms_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Mobile SMS</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sms_menu" data-item="action" value="send-sms">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Send SMS
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sms_menu" data-item="action" value="custom-sms">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Custom SMS
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="sms_menu" data-item="action" value="sms-report">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            SMS Report
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Complain Start here -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="complain_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Complain</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="complain_menu" data-item="action" value="new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Add Complain
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="complain_menu" data-item="action" value="all">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            All Complain
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Access Info Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="access_info">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Access Info</span>
                                    </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            

                            <!-- Privilege Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="privilege-menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Privilege</span>
                                    </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320"></td>
                            </tr>
                            

                            <!-- Settings Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-item="menu" value="theme_menu">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            <span>Settings</span>
                                        </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="theme_menu" data-item="action" value="logo">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Banner / Icon
                                        </label>
                                    </div>
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="theme_menu" data-item="action" value="tools">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Theme Tools
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            

                            <!-- Data Backup Start -->
                            <tr>
                                <th>
                                    <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="backup_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Data Backup</span>
                                    </label>
                                    </div>
                                </th>
                                <td colspan="3" width="320">
                                    <div class="deshitem checkbox checkbox-inline view">
                                        <label>
                                            <input type="checkbox" data-menu="backup_menu" data-item="action" value="add-new">
                                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                            Export
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        // get all users
        $('select#privilege').on("change",function(){
            var data = [];
            var obj = { 'privilege' : $(this).val() };

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url("ajax/retrieveBy/users"); ?>",
                data : "condition=" + JSON.stringify(obj)
            }).done(function(response){
                var items = $.parseJSON(response);
                data.push('<option value="">-- Select --</option>');
                $.each(items,function(i,el){
                    data.push('<option value="'+ el.id+'">'+ el.username +'</option>');
                });

                $('select#user_id').html(data);

            });
        });

        $("#check_view").on('change', function(event) {
            if($(this).is(":checked")){
                $('input[type="checkbox"][value="view"]').prop({checked:true});
            }else{
                $('input[type="checkbox"][value="view"]').prop({checked:false});
            }
        });


        $("#check_edit").on('change', function(event) {
            if($(this).is(":checked")){
                $('input[type="checkbox"][value="edit"]').prop({checked:true});
            }else{
                $('input[type="checkbox"][value="edit"]').prop({checked:false});
            }
        });

        $("#check_delete").on('change', function(event) {
            if($(this).is(":checked")){
                $('input[type="checkbox"][value="delete"]').prop({checked:true});
            }else{
                $('input[type="checkbox"][value="delete"]').prop({checked:false});
            }
        });
        //Getting All Menu Name It's Just for use the data
        var input = $('input[type="checkbox"][data-item="menu"]');
        var list = [];
        $.each(input,function(index, el) {
            list.push($(el).val());
        });
        // console.log(list);

        //Set Privilege Data Start
        $('input[type="checkbox"]').on('change', function(event) {
            if($('select[name="privilege"]').val()!="" && $('select[name="user_id"]').val()!=""){
                $("#progress").fadeIn(300);
                //Collecting all data start here
                var access_item = {};

                var input = $('input[type="checkbox"]');

                $.each(input,function(index, el) {
                    if($(el).is(":checked")){
                        //access_item.push($(el).val());
                        if($(el).data("item")=="menu"){
                            //action data collection Start here
                            var ac_el = $('input[data-menu="'+$(el).val()+'"]');
                            var action_data = [];
                            $.each(ac_el,function(ac_i, ac_el) {
                                if($(ac_el).is(":checked")){
                                    action_data.push($(ac_el).val());
                                }
                            });
                            //action data collection End here
                            access_item[$(el).val()] = action_data;
                        }
                    }
                });
                //console.log(access_item);

                var access = JSON.stringify(access_item);
                //console.log(access);
                var privilege_name = $('select[name="privilege"]').val();
                var user_id = $('select[name="user_id"]').val();
                //Collecting All data end here


                //Sending Request Start here
                $.ajax({
                    url: '<?php echo site_url("privilege/privilege/set_privilege_ajax"); ?>',
                    type: 'POST',
                    data: {
                        privilege_name: privilege_name,
                        user_id : user_id ,
                        access : access
                    }
                })
                .done(function(response) {
                    //console.log(response);
                    $("#progress").fadeOut(300);
                });
                //Sending Request End here
            }else{
                alert("Please select a Privilege and User Name.");
                return false
            }
        });
        //Set Privilege Data End

        //Get Privilege Data Start
        $('select[name="user_id"]').on('change', function(event) {
            $('input[type="checkbox"]').prop({checked:false});
            //Sending Request Start here
            var user_id = $(this).val();
            var privilege_name = $('#privilege').val();
            $.ajax({
                url: '<?php echo site_url("privilege/privilege/get_privilege_ajax"); ?>',
                type: 'POST',
                data: {user_id : user_id , privilege_name:privilege_name}
            }).done(function(response) {
                if(response!="error"){
                    var data = $.parseJSON(response);
                    access = $.parseJSON(data.access);

                    //console.log(access);
                    $.each(access,function(access_index,access_val){
                        //console.log(access_index);
                        //data-item="menu" value="theme_ettings"
                        $('input[data-item="menu"][value="'+access_index+'"]').prop({checked: true});
                        $.each(access_val,function(action_in,action_val){
                            $('input[data-item="action"][data-menu="'+access_index+'"][value="'+action_val+'"]').prop({checked: true});
                        });
                        //$('input[name="'+el.module_name+'"][value="'+access_val+'"]').prop({checked: true});
                    });
                }
            });
            //Sending Request End here
        });
        //Get Privilege Data End
    });
</script>