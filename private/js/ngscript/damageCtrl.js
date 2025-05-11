//show all SR from the database controller
app.controller("damageCtrl",function($scope, $http) {
   $scope.perPage 	= "50";
   $scope.reverse 	= false;
   $scope.allSr 	= [];

   $scope.damageQty =function(){
		var condition = {
			table: 'stock',
			cond : {
				code : $scope.damage,
			}
		};

		$http({
			method: "POST",
			url: url + "read",
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				$scope.quantity = response[0].quantity;
				$scope.unit = response[0].unit;
			}
		});
	}

});
