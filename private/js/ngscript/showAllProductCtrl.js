//show all Product Controller
app.controller("showAllProductCtrl", function($scope, $http){
	$scope.perPage	= "50";
	$scope.products	= [];

	$http({
		method : 'POST',
		url    : url+'result',
		data   : {
			table:'products',
			cond: {trash: 0}
		}
	}).success(function(response) {
		if(response.length > 0){
			$scope.products = response;
		}

		//Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});

		console.log($scope.products);
	});
});