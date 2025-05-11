// sale controller
app.controller('dealerSaleEntryCtrl', function($scope, $http) {

    $scope.active = true;
    $scope.active1 = false;
    $scope.cart = [];

    $scope.payment_label = 'Paid';

    $scope.stype = "cash";
    $scope.presentBalance = 0.00;

    $scope.isDisabled = false;

    $scope.remaining_commission = 0;
    $scope.total_commission_amount = 0.00;

    $scope.amount = {
        labour: 0,
        total: 0,
        totalqty: 0,
        totalDiscount: 0,
        discount_percentage: 0,
        truck_rent: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    $scope.$watch('godown_code', function(godown_code) {

        if (typeof $scope.godown_code != 'undefined') {
			
            // Get all products initial godown wise
            $scope.allProducts = [];
            var productWhere = {
                table: 'stock',
                cond: {
                    'godown_code': godown_code,
                    'quantity >': 0,
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
                    'godown_code': godown_code,
                    'customer_type': 'dealer',
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
            }).success(function(response) {
                if (response.length > 0) {
                    $scope.clientList = response;
                } else {
                    $scope.clientList = [];
                }
            });
        }
    });


    $scope.addNewProductFn = function() {
        // console.log($scope.product_code);
        if (typeof $scope.product_code !== 'undefined') {
            var condition = {
                table: 'stock',
                cond: {
                    code: $scope.product_code,
                    godown_code: (typeof $scope.godown_code != 'undefined') ? $scope.godown_code : $scope.select_godown_code
                }
            };
            //console.log(condition);

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function(response) {
                // console.log(response);
                if (response.length > 0) {
                    var newItem = {
                        product: response[0].name,
                        category: response[0].category,
                        product_code: response[0].code,
                        product_serial: response[0].product_serial,
                        product_model: response[0].product_model,
                        unit: response[0].unit,
                        godown_code: response[0].godown_code,
                        maxQuantity: parseInt(response[0].quantity),
                        stock_qty: parseInt(response[0].quantity),
                        quantity: 1.00,
                        bags: 0.00,
                        subtotal: 0.00,
                        discount: 0.00,
                        com_per: 0.00,
                        subcommission: 0.00,
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price: parseFloat(response[0].sell_price),
                    };

                    $scope.cart.push(newItem);
                    $scope.product_serial = '';
                }
            });
        }
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


    $scope.subCommissionFn = function(index) {
        var total = 0.0;
        $scope.cart[index].subcommission = $scope.cart[index].quantity * $scope.cart[index].sale_price * parseFloat($scope.cart[index].com_per / 100);
        return $scope.cart[index].subcommission.toFixed(2);
    }

    $scope.setSubtotalFn = function(index) {
        var total = 0.0;
        total = parseFloat($scope.cart[index].sale_price * $scope.cart[index].quantity);
        $scope.cart[index].subtotal = total - $scope.cart[index].subcommission;
        return $scope.cart[index].subtotal.toFixed(2);
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

        $scope.amount.total = total.toFixed();
        return $scope.amount.total;
    }


    $scope.calculateDiscountFn = function() {
        var total = 0.00;
        total = $scope.amount.total * ($scope.amount.discount_percentage / 100);
        $scope.amount.totalDiscount = total;
        return total.toFixed(2);
    }


    $scope.getTotalQtyFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.quantity);
        });

        $scope.amount.totalqty = total;
        return $scope.amount.totalqty;
    }


    $scope.getPurchaseTotalFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total.toFixed();
        return $scope.amount.purchase_total;
    }


    $scope.getTotalCommissionFn = function() {
        var total = 0;
        angular.forEach($scope.cart, function(item) {
            total += parseFloat(item.subcommission);
        });
        $scope.amount.totalCommission = total.toFixed(2);
        return $scope.amount.totalCommission;
    }

    //Here Commission Will Minus from total
    $scope.getGrandTotalFn = function() {
        var grand_total = 0.0;

        grand_total = parseFloat($scope.amount.total) - parseFloat($scope.amount.totalDiscount);
        return $scope.amount.grandTotal = grand_total.toFixed(2);
    }


    $scope.getCurrentTotalFn = function() {
        var total = 0.00;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = (parseFloat($scope.partyInfo.balance) + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

            if (total > 0) {
                $scope.partyInfo.csign = "Receivable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Payable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        } else {
            total = (parseFloat($scope.partyInfo.balance) + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

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


        if ($scope.stype == "credit") {
            if ($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.cl) {
                $scope.isDisabled = false;
                $scope.message = "";
            } else if ($scope.partyInfo.csign == "Payable") {
                $scope.isDisabled = false;
                $scope.message = "";
            } else {
                $scope.isDisabled = true;
                $scope.message = "Total is being crossed the Credit Limit!";
            }
        }

        return $scope.presentBalance;
    }



    // calculate_installment_amount
    $scope.calculate_installment_amount = function(installment_number) {
        var total = 0.00;
        if ($scope.partyInfo.csign == "Receivable") {
            //total = (installment_number > 0) ? ($scope.amount.grandTotal - $scope.amount.paid)/installment_number:0.00;
            total = (installment_number > 0) ? ($scope.presentBalance / installment_number) : 0.00;
            $scope.installment_amount = total.toFixed(2);
        } else {
            $scope.installment_amount = 0.00;
        }
        return $scope.installment_amount;
    };

    // get party previous balance
    $scope.partyInfo = {
        code: '',
        name: '',
        contact: '',
        address: '',
        balance: 0,
        payment: 0,
        cl: 0,
        sign: '',
        csign: ''
    };
    $scope.findPartyFn = function() {
        if (typeof $scope.partyCode != 'undefined') {
            var condition = {
                table: "parties",
                cond: {
                    code: $scope.partyCode,
					godown_code: $scope.godown_code
                },
                select: ['code', 'name', 'mobile', 'address', 'initial_balance', 'credit_limit']
            };

            $http({
                method: 'POST',
                url: url + 'result',
                data: condition
            }).success(function(partyResponse) {
				
                if (partyResponse.length > 0) {

                    $scope.partyInfo.code = partyResponse[0].code;
                    $scope.partyInfo.name = partyResponse[0].name;
                    $scope.partyInfo.contact = partyResponse[0].mobile;
                    $scope.partyInfo.address = partyResponse[0].address;
                    $scope.partyInfo.cl = parseFloat(partyResponse[0].credit_limit);

                    // get all current balance and status
                    var condition = {
                        table: "partytransaction",
                        cond: {
                            party_code: partyResponse[0].code,
							godown_code: $scope.godown_code,
                            trash: 0
                        },
                        select: ['credit', 'debit', 'remission']
                    };

                    $http({
                        method: "POST",
                        url: url + "result",
                        data: condition
                    }).success(function(tranResponse) {

                        var transaction = {
                            debit: 0,
                            credit: 0,
                            remission: 0,
                            currentBalance: 0,
                        };

                        if (tranResponse.length > 0) {
							
                            angular.forEach(tranResponse, function(row, i) {
                                transaction.debit += parseFloat(row.debit);
                                transaction.credit += parseFloat(row.credit);
                                transaction.remission += parseFloat(row.remission);
                            });

                            if (parseFloat(partyResponse[0].initial_balance) >= 0) {
                                transaction.currentBalance = (parseFloat(partyResponse[0].initial_balance) + parseFloat(transaction.debit)) - (parseFloat(transaction.credit) + parseFloat(transaction.remission));
                                $scope.partyInfo.balance = Math.abs(transaction.currentBalance.toFixed(2));
                            } else {
                                transaction.currentBalance = parseFloat(transaction.debit) - (parseFloat(transaction.credit) + Math.abs(parseFloat(partyResponse[0].initial_balance)) + parseFloat(transaction.remission));
                                $scope.partyInfo.balance = Math.abs(transaction.currentBalance.toFixed(2));
                            }

                            $scope.partyInfo.sign = (parseFloat(transaction.currentBalance) < 0) ? 'Payable' : 'Receivable';

                        } else {
                            $scope.partyInfo.balance = Math.abs(parseFloat(partyResponse[0].initial_balance).toFixed(2));
                            $scope.partyInfo.sign = (parseFloat(partyResponse[0].initial_balance) < 0) ? 'Payable' : 'Receivable';
                        }
						
						console.log($scope.partyInfo.balance);

                    });
                }
            });
        }
    }


    $scope.deleteItemFn = function(index) {
        $scope.cart.splice(index, 1);
    }
});