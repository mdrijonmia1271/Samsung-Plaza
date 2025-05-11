// sale controller
app.controller('mobileSaleEntryCtrl', function ($scope, $http) {

    $scope.partyName = '';  
    $scope.partyMobile = '';
    $scope.partyAddress = '';
    $scope.partyBalance = 0;
    $scope.previousBalance = 0;
    $scope.previousSign = 'Receivable';
    $scope.currentBalance = 0;
    $scope.currentSign = 'Receivable';


    $scope.buttonOne = 'btn btn-success';
    $scope.buttonTwo = 'btn btn-default';
    $scope.sapType = 'cash';
    $scope.setSaleType = function (type) {

        $scope.partyName = '';
        $scope.partyMobile = '';
        $scope.partyAddress = '';
        $scope.partyBalance = 0;
        $scope.previousBalance = 0;
        $scope.previousSign = 'Receivable';

        if (typeof type !== 'undefined' && type == 'dealer') {
            $scope.buttonOne = 'btn btn-default';
            $scope.buttonTwo = 'btn btn-success';
        } else {
            $scope.buttonOne = 'btn btn-success';
            $scope.buttonTwo = 'btn btn-default';
        }

        $scope.sapType = type;
    };


    // Get all products
    $scope.cart = [];
    $scope.productList = [];
    $scope.partyList = [];
    $scope.$watch('godownCode', function (godownCode) {
        $scope.cart = [];
        $scope.productList = [];
        $scope.productListElec = [];
        $scope.partyList = [];
        if (typeof godownCode !== 'undefined' && godownCode != '') {

            // get client list
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'parties',
                    cond: {type: 'client'},
                    select: ['code', 'name', 'mobile', 'address']
                }
            }).success(function (response){
                if (response.length > 0) {
                    $scope.partyList = response;
                }
            });

            
            // get mobile product list
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        'godown_code': $scope.godownCode,
                        'category' : 'mobile',
                        'quantity >': 0
                    },
                    select: ['code', 'name', 'product_model', 'product_serial']
                }
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.productList = response;
                }
            });
            
            // get electronics product list
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        'godown_code': $scope.godownCode,
                        'category' : 'electronics',
                        'quantity >': 0
                    },
                    select: ['code', 'name', 'product_model', 'product_serial']
                }
            }).success(function (responseelec) {
                if (responseelec.length > 0) {
                    $scope.productListElec = responseelec;
                }
            });
            
            
            
        }
    });


    // add product in card
    $scope.addNewProductFn = function () {

        var productSerial = '';
        var productCodeElec = '';
        
        if (typeof $scope.productSerial !== 'undefined' && $scope.productSerial != '') {
            productSerial = $scope.productSerial;
        }
        
        if (typeof $scope.productCode !== 'undefined' && $scope.productCode != '') {
            productSerial = $scope.productCode;
        }
        
         if (typeof $scope.productCodeElec !== 'undefined' && $scope.productCodeElec != '') {
            productCodeElec = $scope.productCodeElec;
        }
        
       
        
        if (typeof productCodeElec !== 'undefined' && productCodeElec != '' && typeof $scope.godownCode !== 'undefined' && $scope.godownCode != '') {
             //alert(productCodeElec);
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        code: productCodeElec,
                        'quantity >': 0,
                        godown_code: $scope.godownCode
                    }
                }
            }).success(function (responseelec) {
                
                if (responseelec.length > 0) {

                    var itemelec = {
                        stock_id: 'na',
                        product: responseelec[0].name,
                        category: responseelec[0].category,
                        product_code: responseelec[0].code,
                        product_model: responseelec[0].product_model,
                        color: responseelec[0].color,
                        unit: responseelec[0].unit,
                        godown_code: responseelec[0].godown_code,
                        stock_qty: parseInt(responseelec[0].quantity),
                        purchase_price: parseFloat(responseelec[0].purchase_price),
                        product_serial: responseelec[0].product_serial,
                        sale_price: parseFloat(responseelec[0].sell_price),
                        quantity: 1,
                        subtotal: 0,
                        discount_percentage: 0,
                        discount: 0,
                    };
                    
                    $scope.cart.push(itemelec);
                    $scope.productSerial = '';
                    $scope.productCodeElec = '';
                    $scope.productCode = '';
                }
            });
        }
    

    if (typeof productSerial !== 'undefined' && productSerial != '' && typeof $scope.godownCode !== 'undefined' && $scope.godownCode != '') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        product_serial: productSerial,
                        'quantity >': 0,
                        godown_code: $scope.godownCode
                    }
                }
            }).success(function (response) {
                //alert(response);
                if (response.length > 0) {

                    var item = {
                        stock_id: response[0].id,
                        product: response[0].name,
                        category: response[0].category,
                        product_code: response[0].code,
                        product_model: response[0].product_model,
                        color: response[0].color,
                        unit: response[0].unit,
                        godown_code: response[0].godown_code,
                        stock_qty: parseInt(response[0].quantity),
                        purchase_price: parseFloat(response[0].purchase_price),
                        product_serial: response[0].product_serial,
                        sale_price: parseFloat(response[0].sell_price),
                        quantity: 1,
                        subtotal: 0,
                        discount_percentage: 0,
                        discount: 0,
                    };

                    $scope.cart.push(item);
                    $scope.productSerial = '';
                    $scope.productCodeElec = '';
                    $scope.productCode = '';
                }
            });
        }
    };

    // item wise discount
    $scope.setDiscountFn = function (index) {
        var itemDiscount = (($scope.cart[index].sale_price * $scope.cart[index].quantity) * $scope.cart[index].discount_percentage) / 100;
        $scope.cart[index].discount = Math.abs(itemDiscount.toFixed(2));
        return $scope.cart[index].discount;
    };

    // item wise sub total
    $scope.setSubtotalFn = function (index) {
        var totalAmount = ($scope.cart[index].sale_price * $scope.cart[index].quantity);
        $scope.cart[index].subtotal = totalAmount - $scope.cart[index].discount;
        return $scope.cart[index].subtotal.toFixed(2);
    };

    // get total amount
    $scope.isDisabled = true;
    $scope.totalQuantity = 0;
    $scope.totalItemDiscount = 0;
    $scope.getTotalFn = function () {
        var totalAmount = totalQuantity = totalItemDiscount = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += parseFloat(item.quantity);
            totalItemDiscount += parseFloat(item.discount);
        });

        $scope.totalQuantity = totalQuantity;
        $scope.totalItemDiscount = totalItemDiscount;
        $scope.isDisabled = (totalQuantity > 0 ? false : true);

        return Math.abs(totalAmount.toFixed(2));
    };

    // calculate total disocunt
    $scope.getTotalDiscountFn = function () {
        var flatDiscount = !isNaN(parseFloat($scope.flatDiscount)) ? parseFloat($scope.flatDiscount) : 0;
        var totalDiscount =  flatDiscount;
        return Math.abs(totalDiscount.toFixed(2));
    };

    // get grand total
    $scope.getGrandTotalFn = function () {
        var grandTotal = parseFloat($scope.getTotalFn()) - parseFloat($scope.getTotalDiscountFn());
        return Math.abs(grandTotal.toFixed(2));
    };

    // calculate current balance
    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0);
        var balance = $scope.previousBalance + parseFloat($scope.getGrandTotalFn()) - payment;

        $scope.currentBalance = balance;
        $scope.currentSign = (balance < 0 ? 'Payable' : 'Receivable');

        return Math.abs(balance.toFixed(2));
    };

    // get party info
    $scope.setPartyInfoFn = function(partyCode){

        $scope.partyName = '';
        $scope.partyMobile = '';
        $scope.partyAddress = '';
        $scope.partyBalance = 0;
        $scope.previousBalance = 0;
        $scope.previousSign = 'Receivable';

        if (typeof partyCode !== 'undefined' && partyCode != ''){

            $http({
                method: 'post',
                url: url + 'result',
                data: {
                    table: 'parties',
                    cond: {code: partyCode},
                    select: ['code', 'name', 'mobile', 'address']
                }
            }).success(function (response) {
                if (response.length > 0){

                    $scope.partyName = response[0].name;
                    $scope.partyMobile = response[0].mobile;
                    $scope.partyAddress = response[0].address;

                    $http({
                        method: 'post',
                        url: url + 'client_balance',
                        data: {party_code: response[0].code}
                    }).success(function (balanceInfo) {
                        $scope.partyBalance = Math.abs(parseFloat(balanceInfo.balance));
                        $scope.previousBalance = parseFloat(balanceInfo.balance);
                        $scope.previousSign = balanceInfo.status;
                    });
                }
            });
        }
    };

    // remove item
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});