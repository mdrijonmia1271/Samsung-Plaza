// production Contrller start here
app.controller("clientSearchCtrl", ["$scope", "$http", function($scope, $http) {
    
    $scope.$watchCollection('[godown_code, customer_type]', function(searchItem){
        
        $scope.clientList = [];
        
	    if(typeof searchItem[0] !== 'undefined'){
	        
	        var condition = {
    			table: "parties",
    			cond: {godown_code: searchItem[0]},
    			select: ['code', 'name', 'mobile']
    		};
    		
    		if(typeof searchItem[1] !== 'undefined'){
    		    condition.cond['customer_type'] = searchItem[1];
    		}
    		
    		$http({
    			method : "POST",
    			url    : url + "result",
    			data   : condition
    		}).success(function(response) {
    			if(response.length > 0) {
    	            $scope.clientList = response;
    	        }   
    	    });
	    }
    });
}]);