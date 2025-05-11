// Bonus Controller
app.controller("BonusCtrl", ["$scope", "$http", function($scope, $http){
	$scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response){
			// get data
			if(response.length == 1){
				$scope.profile.eid     = response[0].emp_id;
				$scope.profile.name    = response[0].name;
				$scope.profile.post    = response[0].designation;
				$scope.profile.mobile  = response[0].mobile;
				$scope.profile.email   = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image   = siteurl + response[0].path;

				$scope.profile.active = true;
				//console.log(response);

				// get bonus info
				var transmit = {
					table: "salary_structure",
					cond: {eid: $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					if(response.length > 0) {
						if(response[0].bonus === "yes") {
							// get bonus records
							var transmit = {
								table: "bonus_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0){
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
									});

									$scope.bonuses = response;
								} else {
									$scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
								}
							});
						}
					}
				});
			} else {
				//console.log("Employee not found!");
				$scope.profile = {};
				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
			}

		});
	}

	$scope.createRowFn = function() {
		var obj = {fields: "", percentage: 0, remarks: ""};
		$scope.bonuses.push(obj);
	}

	$scope.deleteRowFn = function(index) {
		$scope.bonuses.splice(index, 1);
	}

}]);
