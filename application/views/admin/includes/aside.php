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
            

            <!--<?php if (ck_menu("category_menu")) { ?>
            <li id="category_menu">
                <a href="#category" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Category
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="category" class="sidebar-nav collapse">
                    <?php if (ck_action("category_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('category/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("category_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('category/category/allCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>-->


            <?php if (ck_menu("subCategory_menu")) { ?>
            <li id="subCategory_menu">
                <a href="#subCategory" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Subcategory
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="subCategory" class="sidebar-nav collapse">
                    <?php if (ck_action("subCategory_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("subCategory_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('subCategory/subCategory/all_subcategory'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("brand_menu")) { ?>
            <li id="brand_menu">
                <a href="#brand" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Brand
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="brand" class="sidebar-nav collapse">
                    <?php if (ck_action("brand_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('brand/brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("brand_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('brand/brand/all_brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("colors_menu")) { ?>
            <li id="colors_menu">
                <a href="#colors" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Color
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="colors" class="sidebar-nav collapse">
                    <?php if (ck_action("colors_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('color/color/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("colors_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('color/color'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("fixed_assate_menu")) { ?>
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Fixed assate
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="colors" class="sidebar-nav collapse">
                    <?php if (ck_action("fixed_assate_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assate
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("fixed_assate_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assate
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("fixed_assate_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assate
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("product_menu")) { ?>
            <li id="product_menu">
                <a href="#product" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product" class="sidebar-nav collapse">
                    <?php if (ck_action("product_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Product
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("product_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('product/product/allProduct'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Product
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("supplier-menu")) { ?>
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <?php if (ck_action("supplier-menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("supplier-menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("supplier-menu", "transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("supplier-menu", "all-transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("zone_menu")) { ?>
            <li id="zone_menu">
                <a href="#zone" data-toggle="collapse">
                    <i class="fa fa-area-chart"></i> Zone
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="zone" class="sidebar-nav collapse">
                    <?php if (ck_action("zone_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('zone/zone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("zone_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('zone/zone/allzone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("client_menu")) { ?>
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users"></i> Customer
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <?php if (ck_action("client_menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/client'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("client_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("client_menu", "transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Installment Collection
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("client_menu", "all-transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Installment Collection
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("commitment_menu")) { ?>
            <li id="commitment_menu">
                <a href="#commitment" data-toggle="collapse" title="Customer Commitment">
                    <i class="fa fa-users"></i> Customer Com.
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="commitment" class="sidebar-nav collapse">
                    <?php if (ck_action("commitment_menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/commitment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("commitment_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/commitment/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("purchase_menu")) { ?>
            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    <?php if (ck_action("purchase_menu", "add-new-mobile")) { ?>
                        <li>
                            <a href="<?php echo site_url('purchase/purchaseMobile'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Add  Purchase
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (ck_action("purchase_menu", "all")) { ?>
                        <li>
                            <a href="<?php echo site_url('purchase/purchase/show_purchase'); ?>">
                                <i class="fa fa-angle-right"></i>
                                All Purchase
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (ck_action("purchase_menu", "wise")) { ?>
                        <li>
                            <a href="<?php echo site_url('purchase/purchase/itemWise'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Item Wise
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (ck_action("purchase_menu", "createReturn")) { ?>
                        <li>
                            <a href="<?php echo site_url('purchase/productReturn/create'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Purchase Return
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (ck_action("purchase_menu", "allReturn")) { ?>
                        <li>
                            <a href="<?php echo site_url('purchase/productReturn'); ?>">
                                <i class="fa fa-angle-right"></i>
                                All Return
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
           <?php if (ck_menu("purchase_menu_elec")) { ?>    
            <li id="purchase_menu_elec">
                <a href="#purchase_elec" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    Electronic Purchase
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase_elec" class="sidebar-nav collapse">
                    
                    <?php if(ck_action("purchase_menu_elec","add-new")){ ?>
                            <li>
                                <a href="<?php echo site_url('purchase_elec/purchase'); ?>">
                                    <i class="fa fa-angle-right"></i>
                                    Add Electro Purchase
                                </a>
                            </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu_elec","all")){ ?>    
                        <li>
                            <a href="<?php echo site_url('purchase_elec/purchase/show_purchase'); ?>">
                                <i class="fa fa-angle-right"></i>
                                All Electro Purchase
                            </a>
                        </li>
                    <?php } ?>
                     
                    <?php if(ck_action("purchase_menu_elec","wise")){ ?>    
                        <li>
                            <a href="<?php echo site_url('purchase_elec/purchase/itemWise'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Item Wise
                            </a>
                        </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu_elec","return")){ ?>    
                        <li>
                            <a href="<?php echo site_url('purchase_elec/productReturn'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Add Purchase Return
                            </a>
                        </li>
                    <?php } ?>
                    
                    <?php if(ck_action("purchase_menu_elec","all_return")){ ?>   
                        <li>
                            <a href="<?php echo site_url('purchase_elec/productReturn/allReturn'); ?>">
                                <i class="fa fa-angle-right"></i>
                                All Purchase Return
                            </a>
                        </li>
                    <?php } ?>    
                </ul>
            </li>
         <?php } ?>

            <?php if (ck_menu("raw_stock_menu")) { ?>
            <li id="raw_stock_menu">
                <a href="<?php echo site_url('stock/stock'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Stock
                </a>
            </li>
            <?php } ?>
            
            <?php if (ck_menu("raw_stock_menu_elec")) { ?>
                <li id="raw_stock_menu_elec">
                    <a href="<?php echo site_url('stock/stock/stock_elec'); ?>">
                        <i class="fa fa-bar-chart new-aside-icon" aria-hidden="true"></i> Electronic Stock
                    </a>
                </li>
          <?php  } ?>

            <?php if (ck_menu("sale_menu")) { ?>
            <li id="sale_menu">
                <a href="#sales" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Mobile Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales" class="sidebar-nav collapse">
                    <?php if (ck_action("sale_menu", "mobile_sale")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/mobile_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Mobile Sale
                        </a>
                    </li>
                    <?php } ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale/hire_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Sale
                        </a>
                    </li>

                    <?php if (ck_action("sale_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/search_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sale_menu", "wise")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Item Wise
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sale_menu", "mobile_sale_return")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/mobile_sale_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Mobile Sale Return
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sale_menu", "all_sale_return")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/all_sale_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Sale Return
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            <?php if (ck_menu("sale_menu_elec")) { ?>
              <li id="sale_menu_elec">
                <a href="#sales_elec" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Electronic Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales_elec" class="sidebar-nav collapse">
                    
                    <?php if (ck_action("sale_menu_elec", "retail")) { ?>
                        <li>
                            <a href="<?php echo site_url('sale_elec/retail_sale'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Retail Sale
                            </a>
                        </li>
                    <?php } ?>    
                    
                    <?php if (ck_action("sale_menu_elec", "hire")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/hire_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Sale
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "dealer")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/dealerSale'); ?>">
			                <i class="fa fa-angle-right"></i>
			                Dealer Sale
		                </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "d_c")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/DealerChalan'); ?>">
			                <i class="fa fa-angle-right"></i>
			                Dealer Chalan
		                </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "all")) { ?>

                    <li>
                        <a href="<?php echo site_url('sale_elec/search_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "hire-all")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/search_sale/hireSale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Hire Sale
                        </a>
                    </li>
                    <?php } ?>
                    
                    
                    <?php if (ck_action("sale_menu_elec", "wise")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/sale/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Item Wise
                        </a>
                    </li>
                    
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "client_search")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/client_search'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Search Client Wise
                        </a>
                    </li>
                    
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "return")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/multiSaleReturn'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sale Return
                        </a>
                    </li>
                    
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu_elec", "return-all")) { ?>
                    
                    <li>
                        <a href="<?php echo site_url('sale_elec/multiSaleReturn/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Sale Return
                        </a>
                    </li>
                    
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>

            <?php if (ck_menu("income_menu")) { ?>
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="income" class="sidebar-nav collapse">
                    <?php if (ck_action("income_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("income_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("income_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("cost_menu")) { ?>
            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money"></i> Cost
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cost" class="sidebar-nav collapse">
                    <?php if (ck_action("cost_menu", "all_cost_category")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost_category/cost_category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cost Category
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("cost_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Cost
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("cost_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost/newcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Cost
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("cost_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost/allcost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Cost
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            <?php if (ck_menu("cost_menu")) { ?>
                 <li id="md_transaction_menu">
                    <a href="#md_transaction" data-toggle="collapse">
                        <i class="fa fa-bar-chart"></i> Showroom Transaction
                        <span class="icon"><i class="fa fa-sort-desc"></i></span>
                    </a>
                    <ul id="md_transaction" class="sidebar-nav collapse">
                        
                         <?php if(ck_action("md_transaction_menu","field")){ ?> 
                             <li>
                                <a href="<?php echo site_url('md_transaction/fixed_assate'); ?>">
                                    <i class="fa fa-angle-right"></i>
                                    Add New
                                </a>
                            </li>
                         <?php } ?>
                            
                        <?php if(ck_action("md_transaction_menu","new")){ ?>    
                            <li>
                                <a href="<?php echo site_url('md_transaction/md_transaction'); ?>">
                                    <i class="fa fa-angle-right"></i>
                                    New Showroom Transaction
                                </a>
                            </li>
                         <?php } ?>
                         
                         <?php if(ck_action("md_transaction_menu","all")){ ?>
                            <li>
                                <a href="<?php echo site_url('md_transaction/md_transaction/allMd_transaction'); ?>">
                                    <i class="fa fa-angle-right"></i>
                                    All Showroom Transaction
                                </a>
                            </li>
                         <?php } ?>
                         <?php if(ck_action("md_transaction_menu","balance")){ ?>
                            <li>
                                <a href="<?php echo site_url('md_transaction/md_transaction/balance_report'); ?>">
                                    <i class="fa fa-angle-right"></i>
                                    Balance Report
                                </a>
                            </li>
                         <?php } ?>    
                    </ul>
                </li>
            <?php } ?>


            <?php if (ck_menu("due_list_menu")) { ?>
            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <?php if (ck_action("due_list_menu", "cash")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Retail Due
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("due_list_menu", "retail_due_collection")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/retail_due_collection'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Retail Due Collections
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("due_list_menu", "dealer_list")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/dealer_due'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Party Due
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("due_list_menu", "supplier_list")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier Due
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("bank_menu")) { ?>
            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university"></i>
                    &nbsp;16. Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>

                <ul id="bank" class="sidebar-nav collapse">
                    <?php if (ck_action("bank_menu", "add-bank")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Bank
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "all-acc")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "all_transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("employee_menu")) { ?>
            <li id="employee_menu">
                <a href="#employee" data-toggle="collapse">
                    <i class="fa fa-male"></i> Employee
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="employee" class="sidebar-nav collapse">
                    <?php if (ck_action("employee_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("employee_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/employee/show_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("salary_menu")) { ?>
            <li id="salary_menu">
                <a href="#salary" data-toggle="collapse">
                    <i class="fa fa-money"></i> Salary
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="salary" class="sidebar-nav collapse">
                    <?php if (ck_action("salary_menu", "salary")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/salary'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Basic
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("salary_menu", "bonus")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/salary/bonus'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bonus
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("salary_menu", "advanced")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/salary/advanced'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Advanced
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("salary_menu", "payment")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Payment
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("salary_menu", "all_payment")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/payment/all_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Payment
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("loan-menu")) { ?>
            <li id="loan-menu">
                <a href="#loan" data-toggle="collapse">
                    <i class="fa fa-money" aria-hidden="true"></i> Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="loan" class="sidebar-nav collapse">
                    <?php if (ck_action("loan-menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Loan
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("loan-menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Loan
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("loan-menu", "trans")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/add_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("loan-menu", "all_trx")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan_new/loan_new/all_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("ledger")) { ?>
            <li id="ledger">
                <a href="#ledger-menu" data-toggle="collapse">
                    <i class="fa fa-money"></i>
                    &nbsp;18. Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>

                <ul id="ledger-menu" class="sidebar-nav collapse">
                    <?php if (ck_action("ledger", "company-ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("ledger", "client-ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Deler Ledger
                        </a>
                    </li>
                    <?php } ?>
                    
                    <li>
                        <a href="<?php echo site_url('ledger/hireclientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Hire Ledger
                        </a>
                    </li>

                    <?php if (ck_action("ledger", "brand")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/brand'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Brand Ledger
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("report_menu")) { ?>
            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-money"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>

                <ul id="report" class="sidebar-nav collapse">
                    <?php if (ck_action("report_menu", "purchase_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/purchase_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "sales_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/sales_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "income_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/income_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Income Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "cost_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/cost_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cost Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "product_profit")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/client_profit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Profit / Loss
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "sale_profit")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/sale_profit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sale Profit
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "balance_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/balance_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Book
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            

            <?php if (ck_menu("analytical_report_menu")) { ?>
            <li id="analytical_report_menu">
                <a href="#analytical_report" data-toggle="collapse">
                    <i class="fa fa-money"></i> Analytical Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="analytical_report" class="sidebar-nav collapse">
                    <?php if (ck_action("analytical_report_menu", "client_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("analytical_report_menu", "client_collection")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/client_collection'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Collection Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("analytical_report_menu", "supplier_purchase")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/supplier_purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("analytical_report_menu", "balance_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/analytical_report/supplier_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Payment Report
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("sms_menu")) { ?>
            <li id="sms_menu">
                <a href="#sms" data-toggle="collapse">
                    <i class="fa fa-envelope-o"></i> Mobile SMS
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>

                <ul id="sms" class="sidebar-nav collapse">
                    <?php if (ck_action("sms_menu", "send-sms")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Send SMS
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sms_menu", "custom-sms")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/send_custom_sms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Custom SMS
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sms_menu", "sms-report")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/sms_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            SMS Report
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("complain_menu")) { ?>
            <li id="complain_menu">
                <a href="#complain" data-toggle="collapse">
                    <i class="fa fa-calendar-times-o"></i> Complain
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="complain" class="sidebar-nav collapse">
                    <?php if (ck_action("complain_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('complain/complain'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Complain
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("complain_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('complain/complain/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All complain
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("access_info")) { ?>
            <li id="access_info">
                <a href="<?php echo site_url('access_info/access_info'); ?>">
                    <i class="fa fa-book"></i>
                    Access Info
                </a>
            </li>
            <?php } ?>


            <?php if (ck_menu("privilege-menu")) { ?>
            <li id="privilege-menu">
                <a href="<?php echo site_url('privilege/privilege'); ?>">
                    <i class="fa fa-book"></i>
                    Privilege
                </a>
            </li>
            <?php } ?>


            <?php if (ck_menu("theme_menu")) { ?>
            <li id="theme_menu">
                <a href="#theme" data-toggle="collapse">
                    <i class="fa fa-cog"></i> Settings
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="theme" class="sidebar-nav collapse">
                    <?php if (ck_action("theme_menu", "logo")) { ?>
                    <li>
                        <a href="<?php echo site_url('theme/themeSetting'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Banner/Icons
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("theme_menu", "tools")) { ?>
                    <li>
                        <a href="<?php echo site_url('theme/themeSetting/theme_tools'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Theme Tools
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>


            <?php if (ck_menu("backup_menu")) { ?>
            <li id="backup_menu">
                <a href="#backup" data-toggle="collapse">
                    <i class="fa fa-database"></i> Data Backup
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="backup" class="sidebar-nav collapse">
                    <?php if (ck_action("backup_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('data_backup'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Export Data
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>



            <li>&nbsp;</li>
            <li>&nbsp;</li>
            
        </ul>
    </nav>
</aside>
<!-- Sidebar Wrapper -->

<style>
    .warning {
        background: rgba(255, 255, 255, 0.85);
        justify-content: center;
        align-items: center;
        height: 100vh;
        display: flex;
        width: 100%;
        z-index: 99999;
        top: 0;
        left: 0;
        color: red;
        display: none;
        user-select: none;
        position: fixed;
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