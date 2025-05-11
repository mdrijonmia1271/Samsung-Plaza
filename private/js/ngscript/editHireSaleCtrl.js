//  Edit Sale Ctrl
app.controller('editHireSaleCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.info = {};
	$scope.card = [];
	$scope.oldLabourCost = 0.00;
	$scope.newDiscount = 0.00;
	$scope.currentBalance = 0;
    $scope.voucher_due = 0;

	$scope.amount = {
		labour : 0.00,
		oldTotal: 0.00,
		discount: 0.00,
		newTotal: 0.00,
		totalqty: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00,
		due: 0.00,
		added_percentage: 0,
		totalAddedAmount: 0,
		prevoiusPaid: 0.00,
		truck_rent : 0.00
	};

	// get commission total
	$scope.commission = {
		quantity : 0,
		amount : 0,
		total: 0.0
	};

	// get Truck total
	$scope.truck = {
		quantity : 0,
		amount : 0,
		total:0.00
	};

	$scope.$watch('info.vno', function(voucherNo) {
	    // get voucher and party info
        var sapWhere= {
            tableFrom   : 'saprecords',
            tableTo     : 'parties',
            joinCond    : 'parties.code=saprecords.party_code AND parties.godown_code=saprecords.godown_code',
            cond        : {'saprecords.voucher_no': voucherNo},
            select      : ['saprecords.voucher_no', 'saprecords.total_bill',  'saprecords.godown_code', 'saprecords.installment_type', 'saprecords.installment_no', 'saprecords.installment_date', 'saprecords.hire_price', 'saprecords.commission_percentage', 'saprecords.total_discount', 'saprecords.paid', 'saprecords.party_balance', 'saprecords.sap_at','saprecords.sap_type', 'parties.code', 'parties.name', 'parties.mobile', 'parties.address','parties.initial_balance','parties.credit_limit']
		};
		$http({
			method: 'POST',
			url: url + 'join',
			data: sapWhere
		}).success(function(response) {
		    if(response.length > 0){
		        
        	    //get all product in voucher wise
        		var itemsWhere = {
                    table : 'sapitems',
                    cond  : {
                    	'sapitems.voucher_no': response[0].voucher_no,
                    	'sapitems.godown_code': response[0].godown_code,
                    	'sapitems.trash': 0,
					},
        		};
        		$http({
        			method: 'POST',
        			url: url + 'result',
        			data: itemsWhere
        		}).success(function(itemResponse) {
        		        if(itemResponse.length > 0){
        		            angular.forEach(itemResponse, function(row, index) {
        		                
            					itemResponse[index].quantity       = parseInt(row.quantity);
            					itemResponse[index].old_quantity   = parseInt(row.quantity);
            					itemResponse[index].product_serial = row.product_serial;
            					itemResponse[index].purchase_price = parseFloat(row.purchase_price);
            					itemResponse[index].sale_price     = parseFloat(row.sale_price);
            					itemResponse[index].newSalePrice   = parseFloat(row.sale_price);
            					itemResponse[index].oldSalePrice   = parseFloat(row.sale_price);
            					itemResponse[index].oldSubtotal    = 0;
            					itemResponse[index].newSubtotal    = 0;
            					itemResponse[index].godown         = row.godown_code;
            					itemResponse[index].discount_percentage = parseFloat(row.discount_percentage);
            					itemResponse[index].commission     = 0.00;
            					itemResponse[index].oldcommission  = parseFloat(row.discount);
            					
            					
            					// stock info
        		                var stockWhere = {
                                    table : 'stock',
                                    cond  : {
                                    	code: row.product_code,
										product_group: row.product_group,
										godown_code: row.godown_code
									},
                                    select: ['name', 'quantity', 'product_model', 'category']
                        		};
                        		$http({
                        			method: 'POST',
                        			url: url + 'result',
                        			data: stockWhere
                        		}).success(function(stockResponse) { 
                        		    if(stockResponse.length > 0){
                        		        itemResponse[index].product = stockResponse[0].name;
                        		        itemResponse[index].category = stockResponse[0].category;
                        		        itemResponse[index].product_model = stockResponse[0].product_model;
                        		        itemResponse[index].purchase_price = stockResponse[0].purchase_price;
                        		        itemResponse[index].stock_qty = parseFloat(stockResponse[0].quantity);
                        		        itemResponse[index].maxQuantity = parseFloat(stockResponse[0].quantity) + 1;
                        		    }
                        		});
                        		
            				});
            				
            				// card info
            				$scope.card = itemResponse;
        		        }
        		});
        		
        		
                // get current balance and status
        		var condition = {
                    table : "partytransaction",
                    cond  :{
                        party_code : response[0].code,
						godown_code : response[0].godown_code,
                        trash : 0
                    },
            		select: ['credit', 'debit', 'remission']
        		};
        		
        		$http({
        			method : "POST",
        			url    : url + "result",
        			data   : condition
        		}).success(function(tranResponse){
        		    
        			var transaction= {
                        debit          : 0,
                        credit         : 0,
                        remission      : 0,
                        currentBalance : 0,
            	   	};
        			
        			if(tranResponse.length > 0){
           	        
        	   	        angular.forEach(tranResponse, function(row, i) {
        	   				transaction.debit  += parseFloat(row.debit);
        	   				transaction.credit += parseFloat(row.credit);
        	   				transaction.remission += parseFloat(row.remission);
        	   			});
        	   			
        	   			if(parseFloat(response[0].initial_balance) > 0){
                            transaction.currentBalance  = parseFloat(response[0].initial_balance) + parseFloat(response[0].paid) + parseFloat(transaction.debit) - parseFloat(transaction.credit) - parseFloat(response[0].hire_price);
                            $scope.info.previousBalance = Math.abs(transaction.currentBalance.toFixed(2));
        	   			}else{
                            transaction.currentBalance  = parseFloat(transaction.debit) - parseFloat(transaction.credit) + parseFloat(response[0].paid) + Math.abs(parseFloat(response[0].initial_balance)) - parseFloat(response[0].hire_price);
                            $scope.info.previousBalance = Math.abs(transaction.currentBalance.toFixed(2));
        	   			}
        	   			
                        $scope.info.sign = (parseFloat(transaction.currentBalance) < 0) ? 'Payable' : 'Receivable'; 
        	   	        
        	   	    }else{
                        $scope.info.previousBalance = Math.abs(parseFloat(response[0].initial_balance).toFixed(2));
                        $scope.info.sign   = (parseFloat(response[0].initial_balance) < 0) ? 'Payable' : 'Receivable'; 
        	   	    }
        			
        		});
        		
        		// party and voucher info
                $scope.info.partyName    = response[0].name;
                $scope.info.partyCode    = response[0].code;
                $scope.info.partyMobile  = response[0].mobile;
                $scope.info.partyAddress = response[0].address;
                $scope.info.date         = response[0].sap_at;
                $scope.info.sapType      = response[0].sap_type;
                $scope.info.voucher      = response[0].voucher_no;
                $scope.amount.paid       = parseFloat(response[0].paid);
        		$scope.amount.added_percentage = parseFloat(response[0].commission_percentage);
        		
        		// installment info
                $scope.installment_date   = (response[0].installment_date);
                $scope.installment_number = parseInt(response[0].installment_no);
                $scope.installment_type   = response[0].installment_type;
                
		    }
        			
        });	
        
        
    	// item wise sale sub total
    	$scope.setSubtotalFn = function(index){
    	    var total = 0;
    	    var discount = (typeof $scope.card[index].discount !== 'undefined') ? parseFloat($scope.card[index].discount) : 0;
    	    total = ($scope.card[index].sale_price * $scope.card[index].quantity) - discount;
    		$scope.card[index].subtotal = Math.abs(total.toFixed(2));
    		return $scope.card[index].subtotal;
    	}
    	
    	// item wise purchase sub total
    	$scope.purchaseSubtotalFn = function(index){
    		$scope.card[index].purchase_subtotal = $scope.card[index].purchase_price * $scope.card[index].quantity;
    		return $scope.card[index].purchase_subtotal.toFixed();
    	}
    	
    	// item wise discount
    	$scope.setDiscountFn = function(index){
    		var total = 0;
    	    total = (($scope.card[index].sale_price * $scope.card[index].quantity) * $scope.card[index].discount_percentage) / 100;
    		$scope.card[index].discount_amount = Math.abs(total.toFixed(2));
    		return $scope.card[index].discount_amount;
    	}
    	
    	// calculate total quantity
    	$scope.getTotalQtyFn = function(){
    		var total = 0;
    		angular.forEach($scope.card, function(item){
    			total += parseFloat(item.quantity);
    		});
    		$scope.amount.totalqty = total;
    		return $scope.amount.totalqty;
    	}
    	
    	// get item wise total discount
    	$scope.getItemWiseTotalDiscountFn = function(){
    		var total = 0;
    		angular.forEach($scope.card, function(item){
    			total += parseFloat(item.discount_amount);
    		});
    		$scope.amount.itemWiseTotalDiscount = Math.abs(total.toFixed(2));
    		return $scope.amount.itemWiseTotalDiscount;
    	}
    	
    	// calculate total same price
    	$scope.getTotalFn = function(){
    		var total = 0;
    		angular.forEach($scope.card, function(item){
    			total += parseFloat(item.subtotal);
    		});
    		$scope.amount.total = Math.abs(total.toFixed(2));
    		return $scope.amount.total;
    	}
    	
    	// calculate total purchase price
    	$scope.getPurchaseTotalFn = function(){
    		var total = 0;
    		angular.forEach($scope.card, function(item){
    			total += parseFloat(item.purchase_subtotal);
    		});
    
    		$scope.amount.purchase_total = total.toFixed();
    		return $scope.amount.purchase_total;
    	}
        	
        	
        // get current balance
        $scope.getCurrentTotalFn = function() {
	    
    	    var total = 0.00;
    
    		if($scope.info.sign == 'Receivable') {
    			total = (parseFloat($scope.info.previousBalance) + parseFloat($scope.amount.total)) - $scope.amount.paid;
    			if(total > 0) {
    				$scope.info.csign = "Receivable";
    			} else if(total < 0) {
    				$scope.info.csign = "Payable";
    			} else {
    				$scope.info.csign = "Receivable";
    			}
    		} else {
    			total = (parseFloat($scope.info.previousBalance) + $scope.amount.paid) - parseFloat($scope.amount.total);
    
    			if(total > 0) {
    				$scope.info.csign = "Payable";
    			} else if(total < 0) {
    				$scope.info.csign = "Receivable";
    			} else {
    				$scope.info.csign = "Receivable";
    			}
    		}
    
            //total due amount
    		$scope.amount.due = total.toFixed(2);
    		
    		// total voucher due
    		$scope.voucher_due = $scope.amount.total - $scope.amount.paid;
    		
    		// calculate installment
    		var vou_total = $scope.voucher_due * ($scope.amount.added_percentage/ 100);
    	    $scope.amount.totalAddedAmount = Math.abs(vou_total.toFixed(2));
    		
    		
    		$scope.currentBalance = Math.abs(total.toFixed(2));
    		return $scope.currentBalance;
    	}
    	
    	// calculate hire outstanding
    	$scope.calculateHirePrice = function(){
    	    var total = 0;
    	    total = parseFloat($scope.amount.total) + parseFloat($scope.amount.totalAddedAmount);
    	    return total.toFixed(2);
    	}
    	
    	//Here Commission Will Plus with total
    	$scope.getGrandTotalFn = function(){
    		var grand_total = 0.0;
    		grand_total = parseFloat($scope.amount.due)  + parseFloat($scope.amount.totalAddedAmount);
    		return $scope.amount.grandTotal = Math.abs(grand_total.toFixed(2));
    	}
    	
    	/*// get install data
    	var where = {
	        table : 'installment',
	        cond  : {voucher_no : voucherNo},
	        select: ['installment_type', 'installment_no', 'installment_date']
	    };
	    $http({
	        method: "POST",
	        url : url + 'result',
	        data : where
	    }).success(function(installment){
	        if(installment.length > 0){
	            $scope.installment_type = installment[0].installment_type;
	            $scope.installment_number = parseInt(installment[0].installment_no);
	            $scope.installment_date = (installment[0].installment_date);
	        }else{
	            $scope.installment_type = '';
	            $scope.installment_number = 0;
	            $scope.installment_date = '';
	        }
	    });*/
	    
	    // calculate install amount
    	$scope.getInstallAmountFn = function(){
    		var total = 0.00;
    		if($scope.voucher_due > 0){
    		total = ($scope.voucher_due + $scope.amount.totalAddedAmount)/$scope.installment_number;
    		    $scope.installment_amount = Math.abs(total.toFixed(2));
    		}else{
    		    $scope.installment_amount = 0;
    		}
    		
    		return $scope.installment_amount;
    	};
    });	
}]);
