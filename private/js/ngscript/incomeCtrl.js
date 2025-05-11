//Income Ctrl
app.controller("incomeCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.income = [];
    $scope.field_name = 'dasda';

	var obj = {
		table : "income_field"
	};

	$http({
		method : "POST",
		url : url + "read",
		data : obj
	}).success(function(response){
		if(response.length>0){
			angular.forEach(response,function(values,index){
				values['sl'] = index + 1;
				$scope.income.push(values);
			});
		}else{
			$scope.income = [];
		}
	});
	
	$scope.getFieldName = function(id){
	    console.log(id);
	    $scope.field_name = id;
	}
	
}]);
