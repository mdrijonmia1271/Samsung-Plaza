// sale controller
app.controller('mobileSaleReturnEntryCtrl', function ($scope, $http) {

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
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.partyList = response;
                }
            });

            // get product list
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        'godown_code': $scope.godownCode,
                        'category': 'mobile',
                        'quantity =': 0
                    },
                    select: ['code', 'name', 'product_model', 'product_serial']
                }
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.productList = response;
                }
            });
        }
    });


    // add product in card
    $scope.addNewProductFn = function () {

        var productSerial = '';
        if (typeof $scope.productSerial !== 'undefined' && $scope.productSerial != '') {
            productSerial = $scope.productSerial;
        }
        if (typeof $scope.productCode !== 'undefined' && $scope.productCode != '') {
            productSerial = $scope.productCode;
        }

        if (productSerial !== '' && productSerial !== undefined && typeof $scope.godownCode !== 'undefined' && $scope.godownCode != '') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        product_serial: productSerial,
                        quantity: 0,
                        godown_code: $scope.godownCode
                    }
                }
            }).success(function (response) {

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
                }else{
                    alert("This product has already been stocked.");
                    $scope.productSerial = '';
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

        return Math.abs(totalAmount.toFixed(2));
    };

    // calculate total disocunt
    $scope.getTotalDiscountFn = function () {
        var flatDiscount = !isNaN(parseFloat($scope.flatDiscount)) ? parseFloat($scope.flatDiscount) : 0;
        var totalDiscount = $scope.totalItemDiscount + flatDiscount;
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
        var balance = $scope.previousBalance - parseFloat($scope.getGrandTotalFn()) + payment;

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