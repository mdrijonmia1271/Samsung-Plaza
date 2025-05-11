// chalan Contrller start here
app.controller("chalanAddCtrl", ["$scope","$http",function($scope,$http){
	$scope.items = [];
	$scope.products = []

	// add new row fn
	$scope.addRowFn = function(){
		if(typeof $scope.productGiven !== "undefined"){
			if($scope.products.indexOf($scope.productGiven) < 0) {
				var where = {
					table: "stock",
					cond: {code: $scope.productGiven}
				};

				$http({
					method : "POST",
					url    : url + "read",
					data   : where
				}).success(function(response) {
					if(response.length > 0) {
						var item = {
							product : response[0].name,
							code: response[0].code,
							unit: response[0].unit,
			 				quantity: $scope.quantityGiven
			 			};

						$scope.items.push(item);
						$scope.products.push(response[0].code);
					}
				});
			}
	   }
	};

	//remove row start where
	$scope.deleteItemFn = function(i){
		$scope.items.splice(i, 1);
		$scope.products.splice(i, 1);
	};
}]);