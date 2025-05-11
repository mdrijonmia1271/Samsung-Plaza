// sale controller
app.controller('multiSaleReturn', function($scope, $http) {
    $scope.active = true;
    $scope.active1 = false;
    $scope.cart = [];

    $scope.stype = "cash";

    $scope.presentBalance = 0.00;
    $scope.isDisabled = false;

    $scope.remaining_commission = 0;
    $scope.total_commission_amount = 0.00;
    $scope.extra_commission_amount = 0.00;
    $scope.total_discount = 0.00;

    $scope.amount = {
        labour: 0,
        total: 0,
        truck_rent: 0,
        grandTotal: 0,
        totalgrandTotal: 0,
        paid: 0,
        due: 0
    };



    //get sale type
    $scope.getsaleType = function(type) {
        if (type == "cash") {
            $scope.active = true;
            $scope.active1 = false;
            $scope.partyInfo.balance = 0.00;
            $scope.partyInfo.sign = "Receivable";
        } else {
            $scope.active = false;
            $scope.active1 = true;
            $scope.partyCode = "";
            $scope.partyInfo.code = "";
            $scope.partyInfo.contact = "";
            $scope.partyInfo.address = "";
        }
    };


    $scope.$watch('godown_code', function() {

        if (typeof $scope.godown_code != 'undefined') {
            // Get all products initial godown wise
            $scope.allProducts = [];
            var productWhere = {
                table: 'stock',
                cond: {
                    'godown_code': $scope.godown_code,
                    //'quantity >': 0,
                },
                select: ['code', 'name', 'product_model']
            }
            $http({
                method: 'POST',
                url: url + 'result',
                data: productWhere
            }).success(function(products) {
                //console.log(products);
                if (products.length > 0) {
                    $scope.allProducts = products;
                } else {
                    $scope.allProducts = [];
                }
            });

            // Get Cleient List Showroom Wise 
            $scope.clientList = [];
            var clientWhere = {
                table: 'parties',
                cond: {
                    'godown_code': $scope.godown_code,
                    'status': 'active',
                    'type': 'client',
                    'trash': 0
                },
                select: ['code', 'name', 'godown_code', 'mobile']
            }
            $http({
                method: 'POST',
                url: url + 'result',
                data: clientWhere
            }).success(function(clients) {
                if (clients.length > 0) {
                    $scope.clientList = clients;
                } else {
                    $scope.clientList = [];
                }
            });

        } else {

            // Get all products in select godown wise
            $scope.getAllProductsFn = function() {
                $scope.allProducts = [];
                var productWhere = {
                    table: 'stock',
                    cond: {
                        'godown_code': $scope.godown_code
                    },
                    select: ['code', 'name', 'godown_code', 'product_model']
                }
                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: productWhere
                }).success(function(products) {

                    if (products.length > 0) {
                        $scope.allProducts = products;
                    } else {
                        $scope.allProducts = [];
                    }
                });

                // Get Cleient List Showroom Wise 
                $scope.clientList = [];
                var clientWhere = {
                    table: 'parties',
                    cond: {
                        'godown_code': $scope.select_godown_code,
                        'status'     : 'active',
                        'type'       : 'client',
                        'trash'      : 0
                    },
                    select: ['code', 'name', 'godown_code', 'mobile']
                }
                $http({
                    method : 'POST',
                    url    : url + 'result',
                    data   : clientWhere
                }).success(function(clients) {
                    if (clients.length > 0) {
                        $scope.clientList = clients;
                    } else {
                        $scope.clientList = [];
                    }
                });
            }
        }

    });



    $scope.addNewProductFn = function() {

        if (typeof $scope.product_code !== 'undefined') {

            var condition = {
                table: 'stock',
                cond: {
                    code: $scope.product_code,
                    godown_code: $scope.godown_code,
                }
            };

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function(response) {
                console.log(response);
                if (response.length > 0) {
                    var newItem = {
                        product: response[0].name,
                        product_model: response[0].product_model,
                        category: response[0].category,
                        product_code: response[0].code,
                        stock_qty: parseInt(response[0].quantity),
                        quantity: 1.00,
                        godown_code: response[0].godown_code,
                        unit: response[0].unit,
                        subtotal: 0.00,
                        srcommpercent: 0,
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price: parseFloat(response[0].sell_price),
                        godown: response[0].godown
                    };

                    $scope.cart.push(newItem);

                } else {

                    // read product info
                    var condd = {
                        table: 'products',
                        cond: {
                            code: $scope.product,
                            trash: '0'
                        }
                    };

                    //console.log(condd);

                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condd
                    }).success(function(product_info) {
                        //console.log(product_info);
                        var newItem = {
                            product: product_info[0].name,
                            product_code: product_info[0].code,
                            stock_qty: 0,
                            quantity: 1.00,
                            unit: product_info[0].unit,
                            subtotal: 0.00,
                            purchase_price: parseFloat(product_info[0].purchase_price),
                            sale_price: parseFloat(product_info[0].sale_price),
                        };

                        $scope.cart.push(newItem);

                    });
                }

            });

            //console.log($scope.cart);
        }

        //$scope.product = "";
    }


    //calculate Bags no
    $scope.calculateBags = function(i, size) {
        var bag_no = 0.00;
        bag_no = parseFloat($scope.cart[i].quantity) / parseFloat(size);
        $scope.cart[i].bags = bag_no.toFixed(2);
        return $scope.cart[i].bags;
    };


    //calculate commission
    $scope.calculateTotalCommission = function() {
        var total = parseFloat($scope.amount.total),
            totalCommission = 0.00,
            remainingCommission = 0;

        remainingCommission = parseInt(6 - $scope.commission);
        $scope.remaining_commission = remainingCommission;

        totalCommission = parseFloat(total * (parseFloat($scope.commission) / 100));
        $scope.total_commission_amount = totalCommission.toFixed(2);

        return $scope.total_commission_amount;
    };


    //calculate extra commission
    $scope.calculateExtraTotalCommission = function() {
        var total = parseFloat($scope.amount.grandTotal),
            totalCommission = 0.00,

            totalCommission = parseFloat(total * (parseFloat($scope.extraCommission) / 100));
        $scope.extra_commission_amount = totalCommission.toFixed(2);

        return $scope.extra_commission_amount;
    };


    $scope.setSubtotalFn = function(index) {
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal;
    }

    $scope.getTotalQtyFn = function(index) {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.quantity);
        });

        return total;
    }

    $scope.setSRCommSubTotalFn = function(index) {
        $scope.cart[index].SRCommSubTotal = ($scope.cart[index].subtotal * $scope.cart[index].srcommpercent) / 100;
        return $scope.cart[index].SRCommSubTotal.toFixed();
    }


    $scope.purchaseSubtotalFn = function(index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal.toFixed();
    }

    $scope.getTotalFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.subtotal);
        });

        //$scope.amount.total = total.toFixed();
        $scope.amount.total = total;
        return $scope.amount.total;
    }

    $scope.getPurchaseTotalFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.purchase_subtotal);
        });

        //	$scope.amount.purchase_total = total.toFixed();
        $scope.amount.purchase_total = total;
        return $scope.amount.purchase_total;
    }

    $scope.getGrandTotalFn = function() {
        var grand_total = 0.0;

        grand_total = (parseFloat($scope.amount.total) - parseFloat($scope.total_discount) - $scope.total_commission_amount) + parseFloat($scope.amount.labour);
        return $scope.amount.grandTotal = grand_total.toFixed(2);
    }

    $scope.GrandTotalFn = function() {
        var grand_total = 0.0;

        grand_total = parseFloat($scope.amount.grandTotal) - parseFloat($scope.extra_commission_amount);
        return $scope.amount.totalgrandTotal = grand_total.toFixed(2);
    }

    $scope.getCurrentTotalFn = function() {
        var total = 0.00;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = ($scope.partyInfo.balance - parseFloat($scope.amount.totalgrandTotal)) + $scope.amount.paid;

            if (total > 0) {
                $scope.partyInfo.csign = "Receivable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Payable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        } else {
            total = ($scope.partyInfo.balance - $scope.amount.paid) + parseFloat($scope.amount.totalgrandTotal);

            if (total > 0) {
                $scope.partyInfo.csign = "Payable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Receivable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        }

        $scope.amount.due = total.toFixed(2);
        $scope.presentBalance = Math.abs(total.toFixed(2));


        /*
		if($scope.stype == "credit"){
			if($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.cl){
			   $scope.isDisabled = false;
			   $scope.message = "";
		   }else if($scope.partyInfo.csign == "Payable"){
			   $scope.isDisabled = false;
			   $scope.message = "";
		   }else{
			   $scope.isDisabled = true;
			   $scope.message = "Total is being crossed the Credit Limit!";
		   }
		}*/

        return $scope.presentBalance;
    }

    $scope.partyInfo = {
        code: '',
        name: '',
        contact: '',
        address: '',
        balance: 0.00,
        payment: 0.00,
        cl: 0.00,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.findPartyFn = function() {
        if (typeof $scope.partyCode != 'undefined') {
            var total_debit = total_credit = total_balance = 0.00;
            var condition = {
                table: "parties",
                cond: {
                    code: $scope.partyCode
                }
            };

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function(response) {
                if (response.length > 0) {
                    $scope.initial_balance = response[0].initial_balance;
                    total_balance = parseFloat(response[0].initial_balance);

                    $scope.partyInfo.balance = Math.abs(total_balance);
                    if (total_balance < 0) {
                        $scope.partyInfo.sign = 'Payable';
                    } else {
                        $scope.partyInfo.sign = 'Receivable';
                    }

                    $scope.partyInfo.code = response[0].code;
                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.contact = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;
                    $scope.partyInfo.cl = parseFloat(response[0].credit_limit);

                    // fetch partytransaction records
                    var transaction = {
                        table: 'partytransaction',
                        cond: {
                            party_code: response[0].code,
                            trash: '0'
                        }
                    };

                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: transaction
                    }).success(function(records) {
                        if (records.length > 0) {
                            angular.forEach(records, function(item, index) {
                                total_credit += parseFloat(item.credit);
                                total_debit += parseFloat(item.debit);
                            });

                            total_balance = total_debit - total_credit + parseFloat($scope.initial_balance);

                            $scope.partyInfo.balance = Math.abs(total_balance);
                            if (total_balance < 0) {
                                $scope.partyInfo.sign = 'Payable';
                            } else {
                                $scope.partyInfo.sign = 'Receivable';
                            }
                        }
                    });

                }
            });
        }
    }


    // get total sr commission total

    $scope.total_sr_amount = function() {
        var total = 0.00;

        angular.forEach($scope.cart, function(row, index) {
            total += parseFloat(row.SRCommSubTotal);
        });

        total = total.toFixed(2);
        return total;
    }


    $scope.deleteItemFn = function(index) {
        $scope.cart.splice(index, 1);
    }
});