// add purchase entry
app.controller('PurchaseEntryMobile', function ($scope, $http) {

    $scope.cart = [];
    $scope.supplierList = [];
    $scope.$watch('godownCode', function (godownCode) {

        $scope.cart = [];
        $scope.supplierList = [];

        if (typeof godownCode !== 'undefined' && godownCode != '') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'parties',
                    cond: {
                        'godown_code': godownCode,
                        'status': 'active',
                        'type': 'supplier',
                        'trash': 0
                    },
                    select: ['code', 'name', 'godown_code', 'mobile', 'address']
                }
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.supplierList = response;
                }
            });
        }
    });


    // check voucher exists
    $scope.validation = true;
    $scope.exists = function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: "POST",
                url: url + "result",
                data: {
                    table: "saprecords",
                    cond: {voucher_no: $scope.voucherNo, trash: 0},
                    select: ['voucher_no']
                }
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.validation = true;
                } else {
                    $scope.validation = false;
                }
            });
        }
    };


    $scope.addNewProductFn = function () {

        if ($scope.productCode !== '' && $scope.productCode != '') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'products',
                    cond: {product_code: $scope.productCode}
                }
            }).success(function (response) {
                if (response.length > 0) {

                    var item = {
                        product: response[0].product_name,
                        product_code: response[0].product_code,
                        product_model: response[0].product_model,
                        product_cat: response[0].product_cat,
                        product_subcat: response[0].subcategory,
                        brand: response[0].brand,
                        unit: response[0].unit,
                        product_serial: '',
                        commission: 0.0,
                        purchase_price: parseFloat(response[0].purchase_price),
                        base_price:parseFloat(response[0].purchase_price),
                        sale_price: parseFloat(response[0].sale_price),
                        quantity: 1,
                        discount: 0,
                        subtotal: 0,
                    };

                    $scope.cart.push(item);
                }
            });
        }
    };
    
    
/*    $scope.numberWithCommasFn = function(index) {
        $scope.cart[index].product_serial =
        //return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }*/

    $scope.setQuantityFn = function (index) {

        var arrayLength = quantity = 0;
        
        if(typeof $scope.cart[index].product_serial !='undefined' && $scope.cart[index].product_serial !=''){
            $scope.cart[index].product_serial =  $scope.cart[index].product_serial +",";
        }
        
        var myArray = $scope.cart[index].product_serial.split(",");
        arrayLength = myArray.length;
        for (var i = 0; i < arrayLength; i++) {
            if (myArray[i] != '') {
                quantity++;
            }
        }

        $scope.cart[index].quantity = quantity;
    };
    
    $scope.setPurchasePrice = function(index) {
        var item = $scope.cart[index];
    
        var commission = parseFloat(item.commission) || 0;
        var base_price = parseFloat(item.base_price) || 0;
    
        // Calculate purchase price after commission
        var purchase_price = 0;
    
        if (commission > 0) {
            purchase_price = base_price - (base_price * commission / 100);
        } else {
            purchase_price = base_price;
        }
    
        item.price = parseFloat(purchase_price.toFixed(2));
    
        // Update subtotal using calculated purchase price
        $scope.setSubtotalFn(index);
    };
    
    $scope.setSubtotalFn = function(index) {
        var item = $scope.cart[index];
        var quantity = parseFloat(item.quantity) || 0;
        var price = parseFloat(item.price) || 0;
        
        if (price == '0') {
            item.subtotal = item.base_price;
        } else {
            item.subtotal = parseFloat((price * quantity).toFixed(2));
        }
        
        return item.subtotal;
    };
    
        // calculate purchase price
    // $scope.setPurchasePrice = function(index) {
    //     var total = 0;
        
    //     var comission = (!isNaN(parseFloat($scope.cart[index].commission)) ? parseFloat($scope.cart[index].commission) : 0);
        
    //     if(comission > 0){
    //         total = $scope.cart[index].base_price - parseFloat($scope.cart[index].base_price * parseFloat(comission / 100));
    //     }else{
    //         total = ($scope.cart[index].purchase_price > 0 ? $scope.cart[index].purchase_price : $scope.cart[index].sale_price);
    //     }
        
    //     $scope.cart[index].price = total.toFixed(2);
    //     return $scope.cart[index].price;
    // };

    // $scope.setSubtotalFn = function (index) {
    //     var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
    //     var subtotal = $scope.cart[index].price * quantity;
    //     $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
    //     return $scope.cart[index].subtotal;
    // };

    $scope.isDisabled = true;
    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {
        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });
        $scope.totalQuantity = totalQuantity;
        $scope.isDisabled = (totalQuantity > 0 ? false : true);
        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.getGrandTotalFn = function () {
        var totalDiscount = !isNaN(parseFloat($scope.totalDiscount)) ? parseFloat($scope.totalDiscount) : 0;
        var transportCost = !isNaN(parseFloat($scope.transportCost)) ? parseFloat($scope.transportCost) : 0;
        var grandTotal = parseFloat($scope.getTotalFn()) + transportCost - totalDiscount;
        return Math.abs(grandTotal.toFixed(2));
    };

    $scope.currentBalance = 0;
    $scope.currentSign = 'Receivable';
    $scope.getCurrentTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var balance = $scope.previousBalance - parseFloat($scope.getGrandTotalFn()) + payment;

        $scope.currentSign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.currentBalance = balance;

        return Math.abs(balance.toFixed(2));
    };

    // set party info
    $scope.partyName = '';
    $scope.partyMobile = '';
    $scope.partyAddress = '';
    $scope.balance = 0;
    $scope.previousBalance = 0;
    $scope.previousSign = 'Receivable';

    $scope.setPartyfn = function (partyCode) {

        $scope.partyName = '';
        $scope.partyMobile = '';
        $scope.partyAddress = '';
        $scope.balance = 0;
        $scope.previousBalance = 0;
        $scope.previousSign = 'Receivable';

        if (typeof partyCode != 'undefined' && partyCode != '') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: "parties",
                    cond: {code: partyCode},
                    select: ['code', 'name', 'mobile', 'address']
                }
            }).success(function (partyResponse) {

                if (partyResponse.length > 0) {

                    $scope.partyName = partyResponse[0].name;
                    $scope.partyMobile = partyResponse[0].mobile;
                    $scope.partyAddress = partyResponse[0].address;

                    // get balance info
                    $http({
                        method: "POST",
                        url: url + "supplier_balance",
                        data: {party_code: partyResponse[0].code}
                    }).success(function (balanceInfo) {
                        $scope.balance = parseFloat(balanceInfo.balance);
                        $scope.previousBalance = parseFloat(balanceInfo.balance);
                        $scope.previousSign = balanceInfo.status;
                    });
                }
            });
        }
    };

    // delete cart item
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});