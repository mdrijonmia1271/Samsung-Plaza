app.controller('productAddCtrl',['$scope','$http',function($scope,$http){
	
	$scope.getAllSubcategory = function (){
		$scope.allSubCategory = [];
		var where = {
			table : 'subcategory',
			cond  :{
				category : $scope.category
			} 
		};
		$http({
			method : "POST",
			url    : url + 'read',
			data   : where
		}).success(function(response){			
			if (response.length > 0) {				
				$scope.allSubCategory = response;
			}else{
				$scope.allSubCategory = [];
			}
		});

		
	}
	
	$scope.validation = false;
	$scope.exists = function(code) {

        if (typeof code !== 'undefined'){
            $scope.code = code;

            var where = {
                table: "products",
                cond: {product_code: code}
            };

            $http({
                method: "POST",
                url: url + "read",
                data: where
            }).success(function(response) {
                if (response.length > 0) {
                    $scope.validation = true;
                } else {
                    $scope.validation = false;
                }
            });
        }
    }
    
}]);