//cost controller start here
app.controller("costCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.fields  = [];

	var obj = {
		table : "cost_field"
	};

	$http({
        method : "POST",
        url    : url + "read",
        data   : obj
	}).success(function(response){
		if(response.length>0){
			angular.forEach(response,function(values,index){
				values['sl'] = index + 1;
				$scope.fields.push(values);
			});
		}else{
			$scope.fields = [];
		}
	});
	
	$scope.category = '';
	$scope.field = '';
	$scope.id = '';
	$scope.editCostFieldFn = function(id){
	    
	    
	    var obj = {
    		table : "cost_field",
    		cond  : {id : id}
    	};
    
    	$http({
            method : "POST",
            url    : url + "read",
            data   : obj
    	}).success(function(response){
    	    
    		if(response.length > 0){
    		    $scope.category = response[0].cost_category;
            	$scope.field = response[0].cost_field;
            	$scope.id = response[0].id;
    		}else{
    			$scope.category = '';
	            $scope.field = '';
	            $scope.id = '';
    		}
    	});
	}
	
}]);
