app.controller('PrintBarcodeCtrl', ['$scope', '$window','$http', function($scope, $window,$http){
	//$scope.codes = [{code: 0, quantity: 0,sale_price : 0.00}];
	$scope.codes = [{code: '', quantity: '',sale_price : 0.00}];
	


	$scope.getSalePriceFn = function(i,code){
	    var where = {
	        table  : "stock",
	        cond   : {
	            code : code
	        }
	    };

	    $http({
	        method  : "POST",
	        url     : url + "read",
	        data    : where
	    }).success(function(response){
	        if(response.length > 0 ){
	            $scope.codes[i].sale_price = parseFloat(response[0].sell_price);
	            $scope.codes[i].quantity   = parseInt(response[0].quantity);
	        }else{
	            $scope.codes[i].sale_price = 0.00;
	            $scope.codes[i].quantity   = 0;
	        }
	    });
	};

	$scope.addCodeFn = function() {
		var codeObj = {code: 0, quantity: 0,sale_price : 0.00};
		$scope.codes.push(codeObj);
	}

	$scope.removeRowFn = function(i) {
		if($window.confirm("Are you sure want to delete this Row?")){
			$scope.codes.splice(i, 1);
		}
	}
	//console.log($scope.codes);
}]);