app.controller('productEditCtrl',['$scope','$http',function($scope,$http){
	$scope.$watch("id",function(){
		$scope.product = [];
		$scope.category = "";
		$scope.subcategory = "";
		$scope.unit = "";
		$scope.status = "";

		var where = {
			table  : "products",
			cond   : {
				id  : $scope.id
			}
		};

		$http({
			method  : "POST",
			url     : url + "read",
			data    : where
		}).success(function(response){
			if(response.length == 1){
				response[0].purchase_price = parseFloat(response[0].purchase_price);
				response[0].sale_price     = parseFloat(response[0].sale_price);

				$scope.product = response[0];				
				$scope.category = response[0].product_cat;
				$scope.subcategory = response[0].subcategory;
				$scope.unit = response[0].unit;
				$scope.status = response[0].status;

				// get all SubCategories
				getSubcategories();

			}else{
				$scope.product = [];
				$scope.category = "";
				$scope.subcategory = "";
				$scope.allSubCategory = [];
				$scope.unit = "";
				$scope.status = "";
			}
		});


		$scope.getAllSubcategory = function (){
			getSubcategories();
		}


		function getSubcategories(){
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

	});
}]);
