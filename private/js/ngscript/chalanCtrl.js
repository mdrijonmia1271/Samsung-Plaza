//ChalanCtrL  start here
app.controller("chalanCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.chalan = [];
	// Table
	var obj = {
		table: "chalan",
		cond: {trash: 0},
		group_by: "chalan_no"
	};

	$http({
		method : "POST",
		url : url + "readGroupByData",
		data : obj
	}).success(function(response){
		if(response.length>0){

			angular.forEach(response, function(values, index){
				// get client info
				var where = {
					table: 'parties',
					cond: {code: values.party_code}
				};

				$http({
					method: 'POST',
					url: url + 'read',
					data: where
				}).success(function(party) {
					values['sl'] = index + 1;
					values['party'] = party[0].name;

					$scope.chalan.push(values);
				});

				console.log($scope.chalan);
			});
		}else{
			$scope.chalan = [];
		}
	});

}]);

