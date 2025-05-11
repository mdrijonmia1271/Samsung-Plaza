// return Purchase Entry
app.controller('returnSaleCtrl', function($scope, $http) {
	$scope.partyInfo = {
		partyCode: '',
		previousBalance: 0.00,
		currentBalance: 0.00,
		sign: 'Receivable',
		csign: 'Payable'
	};

	$scope.amount = {
		oldTotal: 0.00,
		newTotal: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00
	};

	$scope.$watch('vno', function(voucherNo) {
		$scope.records = [];

		// get purchase record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no=sapitems.voucher_no',
			where: {
			    'saprecords.voucher_no': voucherNo,
			    'sapitems.trash': '0'
			}
		};

		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response){
			if(response.length > 0) {
				angular.forEach(response, function(row, index){
					var where = {
						table : "products",
						cond : { product_code : row.product_code}
					};

					$http({
						method : "POST",
						url    : url + "read",
						data   : where
					}).success(function(result){
						response[index].product_name = result[0].product_name;
					});

					response[index].discount = parseFloat(row.discount);
					response[index].paid = parseFloat(row.paid);
					response[index].sale_price = parseFloat(row.sale_price);
					response[index].old_sale_price = parseFloat(row.sale_price);
					response[index].oldQuantity = parseInt(row.quantity);
					response[index].newQuantity = 0.00;
					response[index].maxQuantity = parseInt(row.quantity);
					response[index].sale_price = parseFloat(row.sale_price);
					response[index].godown = row.godown_code;
					response[index].oldSubtotal = 0.00;
					response[index].newSubtotal = 0.00;
				});


				// get party balance info
				
				var total_debit = total_credit = total_balance = 0.00;

				var condition = {
				   	table : "parties",
					cond :{
						code : response[0].party_code
					}
			   	};

			   	$http({
			   		method : 'POST',
			   		url    : url + 'read',
			   		data   : condition
			   	}).success(function(info){
			   		if (info.length > 0) {
			   			$scope.initial_balance = info[0].initial_balance;
			   		}

			   	});

			   	// fetch partytransaction record
			   	var transaction = {
			   		table: 'partytransaction',
			   		cond : {
			   			party_code : response[0].party_code,
			   			trash      : '0'
			   		}
			   	};

			   	$http({
			   		method : 'POST',
			   		url    : url + 'read',
			   		data   : transaction
			   	}).success(function(record){
			   		if (record.length > 0) {
			   			//console.log(record);
			   			angular.forEach(record,function(item,index){
			   				total_credit += parseFloat(item.credit);
			   				total_debit	+= parseFloat(item.debit);
			   			});
			   			total_balance  = total_debit - total_credit + parseFloat($scope.initial_balance);
			   			$scope.partyInfo.previousBalance = Math.abs(total_balance);
						if(total_balance < 0) {
							$scope.partyInfo.sign = 'Payable';
						} else {
							$scope.partyInfo.sign = 'Receivable';
						}
			   		}
			   	});

				$scope.amount.date = response[0].sap_at;
				$scope.amount.voucher = response[0].voucher_no;
				$scope.amount.partyCode = response[0].party_code;
				
				$scope.amount.old_paid = parseFloat(response[0].paid);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);
				$scope.amount.newTotalDiscount = parseFloat(response[0].total_discount);
				$scope.amount.oldTotal = parseFloat(response[0].total_bill) + $scope.amount.oldTotalDiscount;

				$scope.records = response;
			}
		});
	});

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.old_sale_price * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.sale_price * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getOldGrandTotalFn = function() {
		$scope.amount.oldGrandTotal = $scope.amount.oldTotal - $scope.amount.oldTotalDiscount;
		return $scope.amount.oldGrandTotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += item.newSubtotal;
		});
		$scope.amount.newTotal = total;
		$scope.amount.sign = 'Payable';
		return $scope.amount.newTotal;
	}
	/*
	$scope.getNewTotalDiscountFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item){
			total += item.discount;
		});

		$scope.amount.newTotalDiscount = total;
		return $scope.amount.newTotalDiscount;
	}
	*/

	$scope.getNewGrandTotalFn = function() {
		$scope.amount.newGrandTotal = $scope.amount.oldGrandTotal - $scope.amount.newTotal;
		return $scope.amount.newGrandTotal;
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;

		total = $scope.amount.newGrandTotal - $scope.amount.oldGrandTotal;
		$scope.amount.sign = (total < 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference;
	}


	$scope.getTotalPaidFn = function(){
		var total = 0.00;

		total = $scope.amount.old_paid + parseFloat($scope.amount.paid);
		return total.toFixed(2);
	}

	$scope.getCurrentTotalFn = function() {
	    
		var total = 0.00;
		if($scope.partyInfo.sign == 'Receivable'){
			total = $scope.partyInfo.previousBalance - $scope.amount.newTotal;
			if(total >= 0){
				$scope.partyInfo.csign = 'Receivable';
			} else {
				$scope.partyInfo.csign = 'Payable';
		    }
			
		}else{
		    	total = $scope.partyInfo.previousBalance + $scope.amount.newTotal ;
		    	$scope.partyInfo.csign = 'Payable';
		}
        /*
		if($scope.amount.sign == 'Receivable' && $scope.partyInfo.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.amount.paid) + $scope.partyInfo.previousBalance;
			$scope.partyInfo.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.partyInfo.sign == 'Payable'){
			total = ($scope.amount.difference + $scope.amount.paid) - $scope.partyInfo.previousBalance;
			if(total >= 0){
				$scope.partyInfo.csign = 'Receivable';
			} else {
				$scope.partyInfo.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.partyInfo.sign == 'Receivable'){
			total = $scope.amount.difference - ($scope.amount.paid + $scope.partyInfo.previousBalance);
			if(total <= 0){
				$scope.partyInfo.csign = 'Receivable';
			} else {
				$scope.partyInfo.csign = 'Payable';
			}
		} else {
			total = $scope.amount.difference + ($scope.partyInfo.previousBalance - $scope.amount.paid);
			if(total > 0){
				$scope.partyInfo.csign = 'Payable';
			} else {
				$scope.partyInfo.csign = 'Receivable';
			}
		}
		
		*/

		return Math.abs(total);
	}
});

