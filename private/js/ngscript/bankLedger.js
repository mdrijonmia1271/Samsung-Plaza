// All Bank Transaction Ctrl
app.controller("bankLedger", ["$scope", "$http", function($scope, $http) {
	$allAccount = [];

	$scope.getAccountFn = function() {
		var where = {
			table: 'bank_account',
			cond: {bank_name: $scope.bank}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response) {
			if(response.length > 0) {
				$scope.allAccount = response;
			}

			//console.log(response);
		});
	}

}]);