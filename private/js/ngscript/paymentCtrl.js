app.controller("PaymentCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.basic_salary = 0.00;
	$scope.advanced_payment = 0.00;

	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false,
		incentive: false,
		deduction: false,
		bonus: false
	};

	$scope.insentives = [];
	$scope.deductions = [];
	$scope.bonuses = [];

	$scope.amount = {
		insentives: {extra: 0.00},
		deductions: {extra: 0.00},
		bonuses: {extra: 0.00}
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

				// get basic salary
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
						$scope.basic_salary = parseInt(response[0].basic);

						// incentives
						if(response[0].incentive === "yes"){
							// active incentives
							$scope.profile.incentive = true;

							// get incentives
							var transmit = {
								table: "incentive_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
										response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
										$scope.amount.insentives[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
									});

									$scope.insentives = response;
								} else {
									$scope.insentives = [];
									$scope.amount.insentives = {};
									$scope.amount.insentives.extra = 0.00;
								}

							});
						}

						// deduction
						if(response[0].deduction === "yes"){
							// active deduction
							$scope.profile.deduction = true;

							// get deduction
							var transmit = {
								table: "deduction_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].amount = parseFloat(row.amount);
										$scope.amount.deductions[response[index].fields] = parseFloat(row.amount);
									});

									$scope.deductions = response;
								} else {
									$scope.deductions = [];
									$scope.amount.deductions = {};
									$scope.amount.deductions.extra = 0.00;
								}

							});
						}

						// deduction
						if(response[0].bonus === "yes"){
							// active deduction
							$scope.profile.bonus = true;

							// get deduction
							var transmit = {
								table: "bonus_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
										response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
										$scope.amount.bonuses[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
									});

									$scope.bonuses = response;
								} else {
									$scope.bonuses = [];
									$scope.amount.bonuses = {};
									$scope.amount.bonuses.extra = 0.00;
								}

							});
						}
					} else {
						alert("This employee's basic info not found!");
						$scope.basic_salary = 0.00;
					}
				});



				// get advanced payment
				var d = new Date();
				var year = d.getFullYear();
				var month = d.getMonth()+1;
				month = (month < 10) ? "0"+month : month;

				var where = {
				    table  : "advanced_payment",
				    cond   : {
				        "emp_id"   : $scope.eid,
				        "year"     : year,
				        "month"    : month
				    }
				};

				$http({
				   method : "POST",
				   url    : url + "read",
				   data   : where
				}).success(function(response){
				    if(response.length > 0){
				        var total = 0.00;
				        angular.forEach(response,function(row,key){
				            total += parseFloat(row.amount);
				        });

				        $scope.advanced_payment = total.toFixed(2);
				    }

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

	$scope.totalFn = function() {
		var total = 0.00;
		var insentives = 0.00;
		var deductions = 0.00;
		var bonuses = 0.00;
		$scope.advanced_payment = 0.00;

		angular.forEach($scope.amount.insentives, function(value){
			insentives += value;
		});

		angular.forEach($scope.amount.deductions, function(value){
			deductions += value;
		});

		angular.forEach($scope.amount.bonuses, function(value){
			bonuses += value;
		});

		total = ($scope.basic_salary + insentives + bonuses) - deductions - $scope.advanced_payment;


		return total;
	}

}]);