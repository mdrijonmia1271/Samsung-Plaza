// payroll controller
app.controller("PayrollCtrl", ["$scope", "$http","$window","$interval", function($scope, $http,$window,$interval){
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.basic_salary = "";
    $scope.msg = {active: true, content: ""};

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.data.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response){
			// get data
			if(response.length == 1){
				$scope.profile.eid     = response[0].emp_id;
				$scope.profile.post    = response[0].designation;
				$scope.profile.mobile  = response[0].mobile;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.name    = response[0].name;
				$scope.profile.email   = response[0].email;
				$scope.profile.image   = siteurl + response[0].path;
				$scope.profile.active  = true;

				$scope.basic_salary = parseFloat(response[0].employee_salary);
			} else {
				//console.log("Employee not found!");
				$scope.msg.active = false;
				//$scope.msg.content = "Employee not found!";
				$scope.profile = {};
				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
				$scope.basic_salary = "";
			}

		});
	}

	$scope.saveDataFn = function(basic_salary) {
		// chack existance
		var transmit = {
			table: "salary_structure",
			where: {eid: $scope.data.eid}
		};
		$scope.data.basic = basic_salary;


		$http({
			method: "POST",
			url: siteurl + 'payroll/addBasicSalaryCtrl/exists',
			data: transmit
		}).success(function(response) {
			var transmit = {
				table: "salary_structure",
				dataset: $scope.data
			};

			// store the info
			if(parseInt(response) === 1){
				transmit.dataset = { basic: basic_salary };
				transmit.where =   { eid: $scope.data.eid };
			}

			$http({
				method: "POST",
				url: siteurl + 'payroll/addBasicSalaryCtrl/save',
				data: transmit
			}).success(function(response) {
				$scope.msg.active = true;
				$scope.msg.content = response;
				$interval(function(){$window.location.reload();},5000);
			});
		});
	}
}]);

