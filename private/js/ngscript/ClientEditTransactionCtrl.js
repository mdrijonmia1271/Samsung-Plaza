//Edit Client Transaction
app.controller('ClientEditTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	
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
	    var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
	    var remission = !isNaN(parseFloat($scope.remission)) ? parseFloat($scope.remission) : 0;
	    var adjustment = !isNaN(parseFloat($scope.adjustment)) ? parseFloat($scope.adjustment) : 0;
	    var previousBalance = !isNaN(parseFloat($scope.previousBalance)) ? parseFloat($scope.previousBalance) : 0;
	    
		var balance = previousBalance - (payment + remission) + adjustment;
		$scope.csign = (balance < 0) ? "Payable" : "Receivable";

		return Math.abs(balance);
	}
}]);
