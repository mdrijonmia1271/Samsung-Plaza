<style>
    ul li a span.icon {
        margin-right: 10px;
        float: right;
    }
    .new-aside-icon {
        color: #00a65a;
    }
    .aside-head {
        position: fixed;
        z-index: 2;
        width: 150px;
    }
    .sidebar-brand {
        transition: all 0.4s ease-in-out;
        position: absolute;
        width: 250px;
        z-index: 2;
    }
    .sidebar-brand.sidebar-slide {
        transition: all 0.4s ease-in-out;
        transform: translateX(-100%);
    }
    .aside-nav {
        margin-top: 65px;
        z-index: -3;
    }
    @media screen and (max-width: 768px) {
        .sidebar-brand {
            transition: all 0.4s ease-in-out;
            transform: translateX(-100%);
        }
        .sidebar-brand.sidebar-slide {
            transition: all 0.4s ease-in-out;
            transform: translateX(0%);
        }
    }
</style>


<!-- Sidebar -->
<aside id="sidebar-wrapper" style="background-color: #00283b;">
    <div class="sidebar-nav" style="background-color: #00283b;">
        <h3 class="sidebar-brand <?php if($this->data['width'] == 'full-width') {echo 'sidebar-slide';} ?>" style="background: #00283b;">
			<a style="font-size: 23px !important; color: #fff" href="<?php echo site_url('super/dashboard'); ?>">Admin <span>Panel</span>
			</a>
		</h3>
    </div>

    <nav class="aside-nav">
        <ul class="sidebar-nav">
            <!--Dashboard -->
            <li id="dashboard">
                <a href="<?php echo site_url('super/dashboard'); ?>">
                    <i class="fa fa-home new-aside-icon" aria-hidden="true"></i> Dashboard
                </a>
            </li>
            
            <!-- Category -->
           <!-- <li id="category_menu">
                <a href="#category" data-toggle="collapse">
                    <i class="fa fa-product-hunt new-aside-icon" aria-hidden="true"></i> Category
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>-->
                <ul id="category" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('category/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('category/category/allCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Subcategory -->
            <li id="subCategory_menu">
                <a href="#subCategory" data-toggle="collapse">
                    <i class="fa fa-product-hunt new-aside-icon" aria-hidden="true"></i> Subcategory 
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="subCategory" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory/all_subcategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Brand -->
            <li id="brand_menu">
                <a href="#brand" data-toggle="collapse">
                    <i class="fa fa-product-hunt new-aside-icon" aria-hidden="true"></i> Brand
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="brand" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('brand/brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('brand/brand/all_brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Color -->
            <li id="colors_menu">
                <a href="#colors" data-toggle="collapse">
                    <i class="fa fa-product-hunt new-aside-icon" aria-hidden="true"></i> Color
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="colors" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('color/color/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('color/color'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Fixed assate -->
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart new-aside-icon"></i> Fixed assate
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="fixed_assate" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assate
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assate
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assate
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Product -->
            <li id="product_menu">
                <a href="#product" data-toggle="collapse">
                    <i class="fa fa-product-hunt new-aside-icon" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Product
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('product/product/allProduct'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Product
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Supplier -->
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o new-aside-icon"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('supplier/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Zone -->
            <li id="zone_menu">
                <a href="#zone" data-toggle="collapse">
                    <i class="fa fa-area-chart new-aside-icon"></i> Zone
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="zone" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('zone/zone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('zone/zone/allzone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Customer -->
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users new-aside-icon"></i> Customer
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('client/client'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Installment Collection
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Installment Collection
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Customer Com -->
            <li id="commitment_menu">
                <a href="#commitment" data-toggle="collapse" title="Customer Commitment">
                    <i class="fa fa-users new-aside-icon"></i> Customer Com.
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="commitment" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('client/commitment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/commitment/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Purchase -->
            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart new-aside-icon" aria-hidden="true"></i> Mobile Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('purchase/purchaseMobile'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Mobile Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Mobile Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('purchase/productReturn/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Return
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('purchase/productReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Return
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="purchase_menu_elec">
                <a href="#purchase_elec" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    Electronic Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase_elec" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('purchase_elec/purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Electro Purchase
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('purchase_elec/purchase/show_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Electro Purchase
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('purchase_elec/purchase/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('purchase_elec/productReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Purchase Return
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('purchase_elec/productReturn/allReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase Return
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Stock -->
            <li id="raw_stock_menu">
                <a href="<?php echo site_url('stock/stock'); ?>">
                    <i class="fa fa-bar-chart new-aside-icon" aria-hidden="true"></i> Mobile Stock
                </a>
            </li>
            
            <li id="raw_stock_menu_elec">
                <a href="<?php echo site_url('stock/stock/stock_elec'); ?>">
                    <i class="fa fa-bar-chart new-aside-icon" aria-hidden="true"></i> Electronic Stock
                </a>
            </li>
            
            <!--Sale -->
            <li id="sale_menu">
                <a href="#sales" data-toggle="collapse">
                    <i class="fa fa-shopping-cart new-aside-icon"></i> Mobile Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sale/mobile_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Mobile Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/search_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale/hire_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Sale
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Item Wise
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/mobile_sale_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Mobile Sale Return
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/all_sale_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Sale Return
                        </a>
                    </li>
                </ul>
            </li>
            
            
            <li id="sale_menu_elec">
                <a href="#sales_elec" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Electronic Sale 
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales_elec" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sale_elec/retail_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Retail Sale
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/hire_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Sale
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/dealerSale'); ?>">
			                <i class="fa fa-angle-right"></i>
			                Dealer Sale
		                </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/DealerChalan'); ?>">
			                <i class="fa fa-angle-right"></i>
			                Dealer Chalan
		                </a>
                    </li>

                    <li>
                        <a href="<?php echo site_url('sale_elec/search_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Sale
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/search_sale/hireSale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Hire Sale
                        </a>
                    </li>
                    
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/client_search'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client Wise
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/multiSaleReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sale Return
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/multiSaleReturn/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Sale Return
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Income -->
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                
                <ul id="income" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Cost -->
            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Cost
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cost" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('cost_category/cost_category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cost Category
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Cost
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost/newcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Cost
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost/allcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Cost
                        </a>
                    </li>
                </ul>
            </li>
            
             <li id="md_transaction_menu">
                <a href="#md_transaction" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Showroom Transaction
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="md_transaction" class="sidebar-nav collapse">
                    
                     <li>
                        <a href="<?php echo site_url('md_transaction/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('md_transaction/md_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Showroom Transaction
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('md_transaction/md_transaction/allMd_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Showroom Transaction
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('md_transaction/md_transaction/balance_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Balance Report
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Due List -->
            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male new-aside-icon"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('due_list/due_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Retail Due
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/retail_due_collection'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Retail Due Colle.
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/dealer_due'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Party Due
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Due
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Banking -->
            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university new-aside-icon"></i> Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="bank" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Bank
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Employee -->
            <li id="employee_menu">
                <a href="#employee" data-toggle="collapse">
                    <i class="fa fa-male new-aside-icon"></i> Employee
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="employee" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('employee/employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('employee/employee/show_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Salary -->
            <li id="salary_menu">
                <a href="#salary" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Salary
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="salary" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('salary/salary'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Basic
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/salary/bonus'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bonus
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/salary/advanced'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Advanced
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Payment
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/payment/all_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Payment
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Loan -->
            <li id="loan-menu">
                <a href="#loan" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon" aria-hidden="true"></i> Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="loan" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Loan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Loan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/add_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/all_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Ledger -->
            <li id="ledger">
                <a href="#ledger-menu" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="ledger-menu" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Ledger
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Dealer Ledger
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('ledger/hireclientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Ledger
                        </a>
                    </li>
                    
                    <!--<li>
                        <a href="<?php /*echo site_url('ledger/clientLedger?type=dealer'); */?>">
                            <i class="fa fa-angle-right"></i>
                            Dealer Ledger
                        </a>
                    </li>-->

                    <li>
                        <a href="<?php echo site_url('ledger/brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Brand Ledger
                        </a>
                    </li>
                </ul>
            </li>
            
           

            <!-- Report -->
            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="report" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('report/purchase_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/sales_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/income_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Income Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/cost_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cost Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/client_profit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Profit / Loss
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/sale_profit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sale Profit
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/balance_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Book
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Analytical Report -->
            <li id="analytical_report_menu">
                <a href="#analytical_report" data-toggle="collapse">
                    <i class="fa fa-money new-aside-icon"></i> Analytical Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="analytical_report" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('report/analytical_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/client_collection'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Collection Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/supplier_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/supplier_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Payment Report
                        </a>
                    </li>
                </ul>
            </li>
            
             <li id="barcode_menu">
                <a href="#barcode" data-toggle="collapse">
                   <i class="fa fa-money"></i>
                        &nbsp; Barcode
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="barcode" class="sidebar-nav collapse">
                    
                    <li>
                        <a href="<?php echo site_url('barcode/barcodeSetting'); ?>">
                            <i class="fa fa-tags" aria-hidden="true" style="font-size: 15px;"></i>
                            Barcode Setting
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('barcode/barcodeGenerate'); ?>">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            Barcode Print
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('barcode/barcodeGenerate/show_purchase'); ?>">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                           Barcode Genarate
                        </a>
                    </li>                    
                    
                    <li>
                        <a href="<?php echo site_url('barcode/barcodeGenerate/purchase_wise'); ?>">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                          Purchase Wise Barcode
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Mobile SMS -->
            <li id="sms_menu">
                <a href="#sms" data-toggle="collapse">
                    <i class="fa fa-envelope-o new-aside-icon"></i> Mobile SMS
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sms" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sms/sendSms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Send SMS
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/send_custom_sms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Custom SMS
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/sms_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            SMS Report
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="complain_menu">
                <a href="#complain" data-toggle="collapse">
                    <i class="fa fa-calendar-times-o new-aside-icon"></i> Complain
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="complain" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('new_complain/new_complain'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Complain
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('new_complain/new_complain/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All complain
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Access Info -->
            <li id="access_info">
                <a href="<?php echo site_url('access_info/access_info'); ?>">
                    <i class="fa fa-cog new-aside-icon"></i> Access Info
                </a>
            </li>

            <!-- Privilege -->
            <li id="privilege-menu">
                <a href="<?php echo site_url('privilege/privilege'); ?>">
                    <i class="fa fa-cog new-aside-icon"></i> Privilege
                </a>
            </li>

            <!-- Settings -->
            <li id="theme_menu">
                <a href="#theme" data-toggle="collapse">
                    <i class="fa fa-cog new-aside-icon"></i> Settings
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="theme" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('theme/themeSetting'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Banner/Icons
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('theme/themeSetting/theme_tools'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Theme Tools
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Data Backup -->
            <li id="backup_menu">
                <a href="#backup" data-toggle="collapse">
                    <i class="fa fa-database new-aside-icon"></i> Data Backup
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="backup" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('data_backup'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Export Data
                        </a>
                    </li>
                </ul>
            </li>

            <li>&nbsp;</li>
            <li>&nbsp;</li>
        </ul>
    </nav>
</aside>
<!-- sidebar-wrapper -->


<style>
    .warning {
        background: rgba(255, 255, 255, 0.85);
        justify-content: center;
        align-items: center;
        z-index: 99999;
        height: 100vh;
        display: flex;
        width: 100%;
        top: 0;
        left: 0;
        color: red;
        display: none;
        position: fixed;
        user-select: none;
        font-family: serif;
    }
</style>

<div class="warning">
    <div>
        <h1>YOU'R OFFLINE</h1>
    </div>
</div>

<script>
    if (typeof navigator.connection !== 'undefined') {
        navigator.connection.onchange = function () {
            var warning = document.querySelector('.warning');
            if (navigator.onLine) {
                warning.style.display = 'none';
            } else {
                warning.style.display = 'flex';
            }
        }
    }
</script>