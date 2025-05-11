// sale controller
app.controller('retailSaleEntryCtrl', function($scope, $http) {

    $scope.cart = [];

    $scope.godown_code = '';
    $scope.allProducts = [];

    //$scope.isDisabled = false;
    // Get all products
    $scope.$watch('godown_code', function(godown_code) {
        if (typeof godown_code !== 'undefined') {
            $scope.allProducts = [];
            var productWhere = {
                table: 'stock',
                cond: {
                    'godown_code': godown_code,
                    'quantity >': 0,
                    'category !=': 'mobile',
                },
                select: ['code', 'name', 'godown_code', 'product_model','product_serial']
            }

            $http({
                method: 'POST',
                url: url + 'result',
                data: productWhere
            }).success(function(products) {
                if (products.length > 0) {
                    $scope.allProducts = products;
                }else{
                    $scope.allProducts = [];
                }
            });
        }
    });


    // add product in card
    $scope.addNewProductFn = function() {
        
        var productCode;
	    if(($scope.product_barcode != '') && ($scope.product_barcode != undefined)){
	        productCode = $scope.product_barcode;
	    }else{
	        productCode = $scope.product_code;
	    } 
	    
	    console.log(productCode);
	    
		//if(productCode !== '' && productCode !== undefined){
        
        
        
        if (productCode !== '' && productCode !== undefined && typeof $scope.godown_code !== 'undefined'){

            var condition = {
                table: 'stock',
                cond: {
                    code: productCode,
                    godown_code: $scope.godown_code
                }
            };

            $http({
                method: 'POST',
                url: url + 'result',
                data: condition
            }).success(function(response) {

                if (response.length > 0) {

                    var newItem = {
                        product       : response[0].name,
                        category      : response[0].category,
                        product_code  : response[0].code,
                        product_model : response[0].product_model,
                        unit          : response[0].unit,
                        godown_code   : response[0].godown_code,
                        maxQuantity   : parseInt(response[0].quantity),
                        stock_qty     : parseInt(response[0].quantity),
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price    : parseFloat(response[0].sell_price),
                        quantity      : 1,
                        subtotal      : 0,
                        discount      : 0,
                    };

                    $scope.cart.push(newItem);
                    $scope.product_barcode = '';
                }
            });
        }
    }

    // item wise discount
    $scope.setDiscountFn = function(index) {
        var total = 0;
        total = (($scope.cart[index].sale_price * $scope.cart[index].quantity) * $scope.cart[index].discount) / 100;
        $scope.cart[index].discount_amount = Math.abs(total.toFixed(2));
        return $scope.cart[index].discount_amount;
    }

    // item wise sub total
    $scope.setSubtotalFn = function(index) {
        var total = 0;
        total = ($scope.cart[index].sale_price * $scope.cart[index].quantity);
        $scope.cart[index].subtotal = total - $scope.cart[index].discount_amount;
        return $scope.cart[index].subtotal.toFixed(2);
    }


    // item wise total discount
    $scope.getItemWiseTotalDiscountFn = function() {

        var total = 0;
        var flat_discount = (!isNaN(parseFloat($scope.flat_discount)) ? parseFloat($scope.flat_discount) : 0);

        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.discount_amount);
        });
        return Math.abs((total + flat_discount).toFixed(2));
    }


    // get total amount
    $scope.getTotalFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.subtotal);
        });

        return Math.abs(total.toFixed(2));
    }


    // get total quantity
    $scope.getTotalQtyFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.quantity);
        });

        return Math.abs(total.toFixed(2));
    }


    // calculate total disocunt
    $scope.getTotalDiscountFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.discount);
        });
        $scope.amount.totalDiscount = total.toFixed(2);
        return $scope.amount.totalDiscount;
    }



    // get grand total
    $scope.getGrandTotalFn = function() {

        var grand_total = 0;

        var flat_discount = (!isNaN(parseFloat($scope.flat_discount)) ? parseFloat($scope.flat_discount) : 0);

        grand_total = parseFloat($scope.getTotalFn()) - flat_discount;

        return Math.abs(grand_total.toFixed(2));
    }


    // get full paid fn
    $scope.getFullPaidFn = function(){
        $scope.paid = $scope.getGrandTotalFn();
    }


    // get paid fn
    $scope.getPaidFn = function(){
        var paid = 0;

        var paidAmount = (!isNaN(parseFloat($scope.paid)) ? parseFloat($scope.paid) : 0);

        if (paidAmount > 0 && paidAmount <= $scope.getGrandTotalFn()){
            paid = paidAmount;
        }else if(paidAmount > 0 && paidAmount >= $scope.getGrandTotalFn()){
            paid = $scope.getGrandTotalFn();
        }else {
            paid = 0;
        }

        return Math.abs(parseFloat(paid).toFixed(2));
    }


    $scope.labelName = 'Due';

    // calculate current balance
    $scope.getCurrentTotalFn = function() {

        var total = 0;

        var paidAmount = (!isNaN(parseFloat($scope.paid)) ? parseFloat($scope.paid) : 0);

        total = $scope.getGrandTotalFn() - paidAmount;

        $scope.labelName = (total < 0 ? 'Return' : 'Due');

        return Math.abs(total.toFixed(2));
    }



    $scope.deleteItemFn = function(index) {
        $scope.cart.splice(index, 1);
    }
});