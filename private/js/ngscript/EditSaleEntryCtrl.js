//  Edit Sale Ctrl
app.controller('EditSaleEntryCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.info = {};
	$scope.records = [];
	$scope.oldLabourCost = 0.00;
	$scope.newDiscount = 0.00;

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
		// get sale record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no = sapitems.voucher_no',
			where: {'saprecords.voucher_no': voucherNo}
		};

    	//console.log(transmit);

		// take action
		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response) {
			//console.log(response);
			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					response[index].discount       = parseFloat(row.discount);
					response[index].paid           = parseFloat(row.paid);
					response[index].oldQuantity    = parseInt(row.quantity);
					response[index].newQuantity    = parseInt(row.quantity);
					response[index].purchase_price = parseFloat(row.purchase_price);
					response[index].newSalePrice   = parseFloat(row.sale_price);
					response[index].oldSalePrice   = parseFloat(row.sale_price);
					response[index].oldSubtotal    = 0.00;
					response[index].newSubtotal    = 0.00;
					response[index].godown         = row.godown_code;

					var where = {
						table : "stock",
						cond : {code   : row.product_code}
					};

					$http({
						method : "POST",
						url : url + "read",
						data : where
					}).success(function(product){
						if(product.length > 0){
							response[index].product= product[0].name;
						}
					});
				});

				//get party information
				var party_where = {
					table:'parties',
					cond:{code: response[0].party_code}
				}

				$http({
					method: 'POST',
					url: url + 'read',
					data: party_where
				}).success(function(info){
					if(info.length > 0){
						$scope.initial_balance = info[0].initial_balance;

						$scope.info.partyName = info[0].name;
						$scope.info.partyCode = info[0].code;
						$scope.info.partyMobile = info[0].mobile;
						$scope.info.partyAddress = info[0].address;
					}else{

						$scope.initial_balance = 0.00;

						$scope.info.partyName = response[0].party_code;
						$scope.info.partyCode = response[0].party_code;

						var jsonObj = JSON.parse(response[0].address);

						$scope.info.partyMobile = jsonObj.mobile;
						$scope.info.partyAddress = jsonObj.address;
					}
				});

			   	// fetch partytransaction records
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
			   	}).success(function(records){
			   		var total_debit = total_credit = total_balance = 0.00;
			   		if (records.length > 0) {
			   			angular.forEach(records,function(item,index){
			   				total_credit += parseFloat(item.credit);
			   				total_debit	+= parseFloat(item.debit);
			   			});

			   			total_balance  = total_debit - total_credit + parseFloat($scope.initial_balance);
						$scope.info.previousBalance = Math.abs(total_balance);
						if(total_balance < 0) {
							$scope.info.sign = 'Payable';
						} else {
							$scope.info.sign = 'Receivable';
						}
			   		}else{
			   			$scope.info.previousBalance = 0.00;
			   		}
			   	});


				$scope.info.date = response[0].sap_at;
				$scope.info.sapType = response[0].sap_type;
				$scope.info.voucher = response[0].voucher_no;
				$scope.info.partyCode = response[0].party_code;
				$scope.amount.previousPaid = response[0].paid;

				$scope.total_commission_amount = parseFloat(response[0].total_discount);

				$scope.amount.oldTotal = parseFloat(response[0].total_bill) + parseFloat(response[0].total_discount);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);
				$scope.amount.newTotalDiscount = parseFloat(response[0].total_discount);
				$scope.amount.oldGrandTotal = parseFloat(response[0].total_bill);
				$scope.amount.oldPaid = parseFloat(response[0].paid);

				$scope.records = response;
			}		
		});
	});

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.newSalePrice * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getTotalQtyFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item){
			total += parseFloat(item.newQuantity);
		});

		$scope.amount.totalqty = total;
		return $scope.amount.totalqty;
	}

	$scope.getTotalDiscountFn = function() {
		var total = 0;
		total = $scope.amount.oldTotalDiscount + $scope.newDiscount;
		$scope.amount.newTotalDiscount = total.toFixed(2);
		return $scope.amount.newTotalDiscount;
	}
	
	//Here Commission Will Minus from total 
	/*$scope.getGrandTotalFn = function(){
		var grand_total = 0.0;

		grand_total = parseFloat($scope.amount.total)  - parseFloat($scope.amount.newTotalDiscount);
		return $scope.amount.grandTotal = grand_total.toFixed(2);
	}*/


	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += (item.newSubtotal) + $scope.amount.labour;
		});

		$scope.amount.newTotal = total;
		return $scope.amount.newTotal;
	}

	$scope.getNewGrandTotalFn = function() {
		$scope.amount.newGrandTotal = parseFloat($scope.amount.newTotal) - parseFloat($scope.amount.newTotalDiscount);
		return $scope.amount.newGrandTotal;
		
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;
		console.log($scope.amount.newGrandTotal);
		
		total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
		$scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference;
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
			$scope.info.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable'){
			total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
			if(total >= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
			if(total <= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else {
			total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
			if(total > 0){
				$scope.info.csign = 'Payable';
			} else {
				$scope.info.csign = 'Receivable';
			}
		}

		return Math.abs(total);
	}

	$scope.getTotalPaidFn = function(){
		var total = 0.00;

		total = $scope.amount.oldPaid + parseFloat($scope.amount.paid);
		return total.toFixed(2);
	}


	$scope.totalQuantityFn = function() {
		var total = 0;

		angular.forEach($scope.records, function(item, index){
			total += item.newQuantity;
		});

		$scope.truck.quantity = total;
		$scope.commission.quantity = total;

		return $scope.truck.quantity;
	}


}]);


