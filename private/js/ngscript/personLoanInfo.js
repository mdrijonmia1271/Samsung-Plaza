// company transaction controller start here
app.controller('personLoanInfo', ['$scope', '$http', function ($scope, $http) {


        $scope.status = '';
        $scope.totalBalance = 0.0;

        $scope.personInfo = function () {

            var condition = {
                table: "loan_new",
                cond: {
                    person_code: $scope.code
                }
            };


            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function (response) {

                console.log(response);
                if (response.length > 0) {
                    $scope.person_code = response[0].person_code;
                    $scope.mobile = response[0].mobile;
                    $scope.address = response[0].address;
                    $scope.type = response[0].type;
                    $scope.balance = response[0].balance;


                    var condition = {
                        table: "add_trx",
                        cond: {
                            person_code: $scope.person_code
                        }
                    };

                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condition
                    }).success(function (rest) {
                        $scope.receive = 0;
                        $scope.paid = 0;

                        angular.forEach(rest, function (row, index) {
                            if (row.type == 'Received') {
                                $scope.receive += parseFloat(row.amount);
                            } else {
                                $scope.paid += parseFloat(row.amount);
                            }
                        });

                        var total = 0.0;
                        if ($scope.type == 'Received') {
                            total = (parseFloat($scope.balance) + parseFloat($scope.receive)) - parseFloat($scope.paid);

                            if (total > 0) {
                                $scope.status = 'Received';
                            } else {
                                $scope.status = 'Paid';
                            }
                            $scope.totalBalance = Math.abs(total);
                        } else {
                            total = (parseFloat($scope.balance) + parseFloat($scope.paid)) - parseFloat($scope.receive);

                            if (total > 0) {
                                $scope.status = 'Paid';
                            } else {
                                $scope.status = 'Received';
                            }
                            $scope.totalBalance = Math.abs(total);
                        }
                    });

                } else {
                    $scope.person_code = '';
                    $scope.mobile = '';
                    $scope.address = '';
                    $scope.type = '';
                    $scope.balance = '';
                    $scope.totalBalance = 0.0;
                }

            });

        };

}]);
