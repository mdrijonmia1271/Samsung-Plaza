
app.controller("AdvancedPaymentCtrl", ["$scope", "$http", function($scope, $http) {
    $scope.advanced_payment = [];
    $scope.total_advanced_payment = 0.00;

	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false,
		incentive: false,
		deduction: false,
		bonus: false
	};



	$scope.getEmployeeInfoFn = function() {
		var where = {
			table: "employee",
			cond: {emp_id: $scope.eid}
		};

		$http({
			method: "POST",
			url: url + "read",
			data: where
		}).success(function(response) {
			if(response.length == 1){
				$scope.profile.eid     = response[0].emp_id;
				$scope.profile.name    = response[0].name;
				$scope.profile.post    = response[0].designation;
				$scope.profile.mobile  = response[0].mobile;
				$scope.profile.email   = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image   = siteurl + response[0].path;

				$scope.profile.active = true;

				// get advanced payment
				var d = new Date();
				var year = d.getFullYear();
				var month = d.getMonth()+1;
				month = (month < 10) ? "0"+month : month;

				var where = {
				    table  : "advanced_payment",
				    cond   : {
				        "emp_id"   : $scope.eid,
				        // "year"     : year,
				        // "month"    : month
				    }
				};

				$http({
				   method : "POST",
				   url    : url + "read",
				   data   : where
				}).success(function(response){
				    if(response.length > 0){
				         var total       = 0.00;
				         var fullMonths = {"01":"January","02":"February","03":"March","04":"April","05":"May","06":"June","07":"July","08":"August","09":"September","10":"October","11":"November","12":"December"};
				        angular.forEach(response,function(row,key){
				            response[key].month = fullMonths[row.month];
				            total += parseFloat(row.amount);
				        });

				        $scope.advanced_payment = response;
				        $scope.total_advanced_payment = total.toFixed(2);
				    }else{
				       $scope.advanced_payment = [];
				       $scope.total_advanced_payment = 0.00;
				    }
                    // console.log($scope.advanced_payment);
				});


			 } else {
				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
				$scope.profile.incentive = false;
				$scope.profile.deduction = false;
			}

		});
	}

}]);
