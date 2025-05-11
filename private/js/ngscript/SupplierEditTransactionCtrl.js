//Edit Supplier Transaction
app.controller('SupplierEditTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.payment = 0.00;

	$scope.$watchGroup(['id', 'transactionBy'], function(input) {
		if(input[1] == 'cheque') {

			$http({
				method: 'POST',
				url: url + "read",
				data: {
					table: 'partytransactionmeta',
					cond: {transaction_id: input[0]}
				}
			}).success(function(response) {
				if(response.length > 0) {
					angular.forEach(response, function(row) {
						if(row.meta_key == 'bankname') {$scope.bankname = row.meta_value;}
						if(row.meta_key == 'branchname') {$scope.branchname = row.meta_value;}
						if(row.meta_key == 'account_no') {$scope.accountno = row.meta_value;}
						if(row.meta_key == 'chequeno') {$scope.chequeno = row.meta_value;}
						if(row.meta_key == 'passdate') {$scope.passdate = row.meta_value;}
					});
				}				
			});
		}
	});

	$scope.getTotalFn = function() {
		var total = parseFloat($scope.balance) + (parseFloat($scope.payment) - parseFloat($scope.prevPayment));
		$scope.csign = (total >= 0) ? "Receivable" : "Payable";

		return Math.abs(total);
	}

}]);
