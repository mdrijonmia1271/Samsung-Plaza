// sale controller
app.controller('mobileSaleEditCtrl', function ($scope, $http) {


    $scope.previousBalance = 0;
    $scope.currentBalance = 0;
    $scope.currentSign = 'Receivable';


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
                        'quantity >': 0
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

    $scope.totalDiscount = 0;
    $scope.flatDiscount = 0;
    $scope.$watch('voucherNo', function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: 'post',
                url: url + 'join',
                data: {
                    tableFrom: 'sapitems',
                    tableTo: 'stock',
                    joinCond: 'sapitems.stock_id=stock.id',
                    cond: {
                        'sapitems.voucher_no': voucherNo,
                        'sapitems.trash': 0,
                    },
                    select: ['sapitems.*', 'stock.name', 'stock.category', 'stock.quantity AS stock_qty']
                }
            }).success(function (response) {
                if (response.length > 0) {

                    var totalDiscount = 0;

                    angular.forEach(response, function (row) {

                        totalDiscount += parseFloat(row.discount);

                        var item = {
                            item_id: row.id,
                            stock_id: row.stock_id,
                            product: row.name,
                            category: row.category,
                            product_code: row.code,
                            product_model: row.product_model,
                            color: row.color,
                            unit: row.unit,
                            godown_code: row.godown_code,
                            stock_qty: parseInt(row.stock_qty),
                            purchase_price: parseFloat(row.purchase_price),
                            product_serial: row.product_serial,
                            sale_price: parseFloat(row.sale_price),
                            old_quantity: parseInt(row.quantity),
                            quantity: parseInt(row.quantity),
                            discount_percentage: parseInt(row.discount_percentage),
                            discount: 0,
                            subtotal: 0,
                        };

                        $scope.cart.push(item);
                    });

                    $scope.flatDiscount = parseFloat($scope.totalDiscount) - totalDiscount;
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
                        'quantity >': 0,
                        godown_code: $scope.godownCode
                    }
                }
            }).success(function (response) {

                if (response.length > 0) {

                    var item = {
                        item_id: '',
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
                        old_quantity: 0,
                        quantity: 1,
                        subtotal: 0,
                        discount_percentage: 0,
                        discount: 0,
                    };

                    $scope.cart.push(item);
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
        var balance = parseFloat($scope.previousBalance) + parseFloat($scope.getGrandTotalFn()) - payment;

        $scope.currentBalance = balance;
        $scope.currentSign = (balance < 0 ? 'Payable' : 'Receivable');

        return Math.abs(balance.toFixed(2));
    };


    // remove item
    $scope.deleteCart = [];
    $scope.deleteItemFn = function (index) {

        if ($scope.cart[index].item_id) {
            var alert = confirm('Do you want to delete this data?');
            if (alert) {

                $scope.deleteCart.push({
                    item_id: $scope.cart[index].item_id,
                    stock_id: $scope.cart[index].stock_id,
                    quantity: $scope.cart[index].old_quantity,
                });

                $scope.cart.splice(index, 1);
            }
        } else {
            $scope.cart.splice(index, 1);
        }
    };
});