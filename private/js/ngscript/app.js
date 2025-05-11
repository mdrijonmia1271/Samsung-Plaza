var app = angular.module("MainApp", ['ui.select2', 'angularUtils.directives.dirPagination', 'ngSanitize']);

// var url = window.location.origin + '/ajax/';
// var siteurl = window.location.origin + '/';

// Split pathname into parts
var pathParts = window.location.pathname.split('/');

// Check if running in subfolder (like localhost/bakulinternational.xyz)
var folder = pathParts[1];
var isLocalWithFolder = window.location.hostname === 'localhost' && folder !== '';

// Build base URL dynamically
var baseUrl = window.location.origin + (isLocalWithFolder ? '/' + folder : '') + '/ajax/';

// Final result URL
var url = baseUrl;

// var url = window.location.origin + '/nehal/ajax/';
// var siteurl = window.location.origin + '/nehal/';

app.constant('select2Options', 'allowClear:true');

// custom filter in Angular js
app.filter('removeUnderScore', function() {
	return function(input) {
		return input.replace(/_/gi, " ");
	}
});

app.filter('textToLower', function() {
	return function(input) {
		return input.replace(/_/gi, " ").toLowerCase();
	}
});

//remove underscore and ucwords
app.filter("textBeautify", function(){
	return function (str) {
		var str = str.replace(/_/gi, " ").toLowerCase(),
        	txt = str.replace(/\b[a-z]/g, function(letter) {
        		return letter.toUpperCase();
    		});

    	return txt;
    }
});

//remove dash and ucwords
app.filter("removeDash",function(){
	return function (str) {
	  var str = str.replace(/-/gi, " ").toLowerCase();
          txt = str.replace(/\b[a-z]/g, function(letter) {
         return letter.toUpperCase();
     });
    return txt;
   }
});


app.filter('join', function(){
	return function(input) {
		console.log(typeof input);
		return (typeof input==='object') ? "" : input.join();
	}
});


app.filter("showStatus",function(){
	return function(input){
        if(input == 1){
        	return "Available";
        }else{
        	return "Not Available";
        }
	}
});


app.filter("status",function(){
	return function(input){
        if(input == "active"){
        	return "Running";
        }else{
        	return "Blocked";
        }
	}
});


app.filter("fNumber",function(){
	return function(input){
		var myNum = new Intl.NumberFormat('en-IN').format(input);
		return  myNum;
	}
});

//SMS Controller
app.controller("CustomSMSCtrl", ["$scope", "$log", function($scope, $log){
	$scope.msgContant = "";
	$scope.totalChar = 0;
	$scope.msgSize = 1;

	$scope.$watch(function(){
		var charLength = $scope.msgContant.length,
			message = $scope.msgContant,
			messLen = 0;

		var english = /^[~!@#$%^&*(){},.:/-_=+A-Za-z0-9 ]*$/;

		if (english.test(message)){
			if( charLength <= 160){ messLen = 1; }
			else if( charLength <= 306){ messLen = 2; }
			else if( charLength <= 459){ messLen = 3; }
			else if( charLength <= 612){ messLen = 4; }
			else if( charLength <= 765){ messLen = 5; }
			else if( charLength <= 918){ messLen = 6; }
			else if( charLength <= 1071){ messLen = 7; }
			else if( charLength <= 1080){ messLen = 8; }
			else { messLen = "Equal to an MMS!"; }

		}else{
			if( charLength <= 63){ messLen = 1; }
			else if( charLength <= 126){ messLen = 2; }
			else if( charLength <= 189){ messLen = 3; }
			else if( charLength <= 252){ messLen = 4; }
			else if( charLength <= 315){ messLen = 5; }
			else if( charLength <= 378){ messLen = 6; }
			else if( charLength <= 441){ messLen = 7; }
			else if( charLength <= 504){ messLen = 8; }
			else { messLen = "Equal to an MMS!"; }
		}


		$scope.totalChar = charLength;
		$scope.msgSize = messLen;
	});
}]);


app.controller("AdvancedPaymentCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.advanced_payment = [];
    $scope.total_advanced_payment = 0.00;

    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false,
        incentive: false,
        deduction: false,
        bonus: false
    };

    $scope.getEmployeeInfoFn = function (emp_id) {

        var employeeWhere = {
            table: "employee",
            cond: {emp_id: emp_id}
        };

        $http({
            method: "POST",
            url: url + "result",
            data: employeeWhere
        }).success(function (response) {

            if (response.length > 0) {
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.salary = response[0].employee_salary;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;
                $scope.profile.active = true;

                // get all advance salary info
                $scope.getAllAdvance();

            } else {
                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
                $scope.profile.incentive = false;
                $scope.profile.deduction = false;
            }

        });
    }

    $scope.getAllAdvance = function () {

        if (typeof $scope.emp_id !== 'undefined' && typeof $scope.month !== 'undefined' && typeof $scope.year !== 'undefined') {

            var where = {
                table: "advanced_payment",
                cond: {
                    'emp_id': $scope.emp_id,
                    'YEAR(payment_date)': $scope.year,
                    'MONTH(payment_date)': $scope.month,
                    'trash': '0'
                }
            };

            $http({
                method: "POST",
                url: url + "result",
                data: where
            }).success(function (advanceRes) {

                $scope.advanced_payment = [];
                $scope.total_advanced_payment = 0;

                if (advanceRes.length > 0) {
                    var total = 0.00;
                    var fullMonths = {
                        "01": "January",
                        "02": "February",
                        "03": "March",
                        "04": "April",
                        "05": "May",
                        "06": "June",
                        "07": "July",
                        "08": "August",
                        "09": "September",
                        "10": "October",
                        "11": "November",
                        "12": "December"
                    };
                    angular.forEach(advanceRes, function (row, key) {

                        var date = advanceRes[0].payment_date.split("-");

                        advanceRes[key].year = date[0];
                        advanceRes[key].month = fullMonths[date[1]];

                        total += parseFloat(row.amount);
                    });

                    $scope.advanced_payment = advanceRes;
                    $scope.total_advanced_payment = Math.abs(total.toFixed(2));
                }
            });
        }
    }

}]);