// add purchase entry
app.controller('returnPurchaseCtrl', function ($scope, $http) {

	$scope.isDisabled = true;

	$scope.cart = [];
	$scope.supplierList = [];
	$scope.$watch('godownCode', function (godownCode) {

		$scope.cart = [];
		$scope.supplierList = [];

		if (typeof godownCode != 'undefined' && godownCode != '') {

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
			}).success(function (supplier) {
				if (supplier.length > 0) {
					$scope.supplierList = supplier;
				}
			});
		}
	});


	$scope.addNewProductFn = function () {
		if (typeof $scope.productSerial !== 'undefined' && $scope.productSerial != '' && typeof $scope.godownCode !== 'undefined' && $scope.godownCode != '') {

			$http({
				method: 'POST',
				url: url + 'result',
				data: {
					table: 'stock',
					cond: {
						product_serial: $scope.productSerial,
						godown_code: $scope.godownCode,
						'quantity >': 0
					}
				}
			}).success(function (response) {

				if (response.length > 0) {
					var item = {
						stock_id: response[0].id,
						product_code: response[0].code,
						product: response[0].name,
						product_serial: response[0].product_serial,
						product_model: response[0].product_model,
						category: response[0].category,
						subcategory: response[0].subcategory,
						brand: response[0].brand,
						color: response[0].color,
						unit: response[0].unit,
						purchase_price: parseFloat(response[0].purchase_price),
						sale_price: parseFloat(response[0].sell_price),
						quantity: 1,
						discount: 0,
						subtotal: 0,
					};
					$scope.cart.push(item);
				}

				$scope.productSerial = '';
			});
		}
	};

	$scope.setSubtotalFn = function (index) {
		$scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
		return $scope.cart[index].subtotal.toFixed(2);
	};

	$scope.totalQuantity = 0;
	$scope.getTotalFn = function () {
		var totalAmount = totalQuantity = 0;
		angular.forEach($scope.cart, function (item) {
			totalAmount += parseFloat(item.subtotal);
			totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
		});

		$scope.isDisabled = (totalQuantity > 0 ? false : true);
		$scope.totalQuantity = totalQuantity;
		return Math.abs(totalAmount.toFixed(2));
	};

	$scope.getCurrentTotalFn = function () {

		var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
		var balance = $scope.partyInfo.previous_balance + (parseFloat($scope.getTotalFn()) + payment);

		$scope.partyInfo.csign = (balance < 0 ? 'Payable' : 'Receivable');
		$scope.partyInfo.current_balance = balance.toFixed(2);

		return Math.abs(balance.toFixed(2));
	};

	$scope.partyInfo = {
		balance: 0,
		previous_balance: 0,
		current_balance: 0,
		sign: 'Receivable',
		csign: 'Receivable'
	};

	$scope.setPartyfn = function(partyCode){

		$scope.partyInfo = {
			balance: 0,
			previous_balance: 0,
			current_balance: 0,
			sign: 'Receivable',
			csign: 'Receivable'
		};

		if (typeof partyCode !== 'undefined' && partyCode != ''){

			$http({
				method: 'post',
				url: url + 'supplier_balance',
				data: {party_code: partyCode}
			}).success(function (response) {
				$scope.partyInfo.balance = Math.abs(parseFloat(response.balance));
				$scope.partyInfo.previous_balance = parseFloat(response.balance);
				$scope.partyInfo.sign = response.status;
			});
		}
	};

	$scope.deleteItemFn = function (index) {
		$scope.cart.splice(index, 1);
	};
});