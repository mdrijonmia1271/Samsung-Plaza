
//show all Category
app.controller("showzoneCtrl", function($scope, $http){
	$scope.reverse = false;
	$scope.perPage = "20";
	$scope.categories = [];

	var obj = { 'table': 'zone' };

	$http({
		method : 'POST',
		url    : url+'read',
		data   : obj
	}).success(function(response) {
		angular.forEach(response, function(values, index) {
			values['sl'] = index + 1;
			$scope.categories.push(values);
		});

		 //Pre Loader
		  $("#loading").fadeOut("fast",function(){
			  $("#data").fadeIn('slow');
		  });
	});
});
