// production Contrller start here
app.controller("ChalanEditCtrl", ["$scope", "$http", function($scope, $http) {

	$scope.$watch("chalanNo", function(value) {
		$scope.items = [];

		var where = {
			from: "chalan",
			join: "products",
			cond: "chalan.code=products.product_code",
			where: {'chalan.chalan_no': value}
		};

		$http({
			method : "POST",
			url    : url + "readJoinData",
			data   : where
		}).success(function(response) {
			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					var item = {
						chalan_no: row.chalan_no,
						product: row.product_name,
						code: row.product_code,
						date: row.date,
						id: parseInt(row.id),
						party_code: row.party_code,
						quantity: parseFloat(row.quantity),
					};

					$scope.items.push(item);
				});

				console.log(response);
				// console.log($scope.items);
			}
		});
	});
}]);