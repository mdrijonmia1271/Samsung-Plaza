app.controller('dueCollectCtrl',['$scope','$http',function($scope,$http){

	$scope.previousPaid = 0.00;
	$scope.grandTotal = 0.00;
	$scope.paid = 0.00;
	$scope.remission = 0.00;
	$scope.remissionDiff = 0.00;
	$scope.totalPaid = 0.00;

	$scope.getTotalFn = function(){
		var total = 0;
		total = parseFloat($scope.previousPaid) + parseFloat($scope.paid);
		$scope.totalPaid = total;
		return total;
	}

	$scope.getTotalRemissionFn = function(){
		var total = 0;
		total = parseFloat($scope.previousRemission) + parseFloat($scope.remission);
		return total;
	}

	$scope.getTotalDueFn = function(){
		var total = 0;
		total = parseFloat($scope.grandTotal) - parseFloat($scope.totalPaid) - parseFloat($scope.remission);
		return total;
	}
}]);