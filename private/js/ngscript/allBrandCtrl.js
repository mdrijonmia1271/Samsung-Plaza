//show all Sub Category
app.controller("allBrandCtrl", function($scope, $http, $log){
	$scope.reverse=false;
	$scope.perPage="20";
	$scope.brands=[];
	
	var obj ={
	    'table'    : 'brand',
	    'group_by' : 'brand',
	    cond       : {trash : '0'}
	};
	$http({
		method : 'POST',
		url    : url+'readGroupByData',
		data   : obj
	}).success(function(response){
		angular.forEach(response,function(values,index){
		    values['sl'] = index+1;
		    $scope.brands.push(values);
		});

		//Pre Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});
	});
});