// show Stock Ctl
app.controller("showStockCtl",['$scope','$http',function($scope,$http){
	$scope.perPage = "20";
	$scope.allStocks = [];

	var where = {
		table : "stock"
	};

	$http({
		method  : "POST",
		url     : url + "read",
		data    : where
	}).success(function(response){
		if(response.length > 1){
			angular.forEach(response,function(row,key){
				row['sl'] = key + 1;
				$scope.allStocks.push(row);
			});
		}else{
			$scope.allStocks = [];
		}

		// loading
		$("#loading").fadeOut("fast", function(){
			$("#data").fadeIn('slow');
		});
	});
}]);
