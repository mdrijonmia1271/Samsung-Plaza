
// sale controller
app.controller('complainSaleTypeCtrl', function($scope, $http) {

	$scope.active = true;
	$scope.active1 = false;

	$scope.stype = "cash";
    
    $scope.partyInfo = {
        code    : '',
		name    : '',
		contact : '',
		address : ''
    };

	//get sale type
	$scope.getsaleType = function(type){
		if(type == "cash"){
			$scope.active = true;
			$scope.active1 = false;
		}else{
			$scope.active = false;
			$scope.active1 = true;
		}
	};
	
	$scope.findPartyFn = function() {
		if(typeof $scope.partyCode != 'undefined'){
			var condition = {
			   	table : "parties",
				cond :{
					name : $scope.partyCode
				}
		   	};
	
		   	$http({
		   		method : 'POST',
		   		url    : url + 'read',
		   		data   : condition
		   	}).success(function(response){
		   		if (response.length > 0) {
					//$scope.partyInfo.code    = response[0].code;
					$scope.partyInfo.name    = response[0].name;
					$scope.partyInfo.contact = response[0].mobile;
					$scope.partyInfo.address = response[0].address;
		   		}else{
		   		    //$scope.partyInfo.code    = '';
					$scope.partyInfo.name    = '';
					$scope.partyInfo.contact = '';
					$scope.partyInfo.address = '';
		   		}
		   	});
		}
	}

});