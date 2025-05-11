// sale controller
app.controller('clientProfitReportCtrl', function($scope, $http) {

    $scope.$watch('godown_code', function() {

        if (typeof $scope.godown_code != 'undefined') {
            // Get Cleient List Showroom Wise 
            $scope.clientList = [];
            var clientWhere = {
                table: 'parties',
                cond: {
                    'godown_code': $scope.godown_code,
                    'status': 'active',
                    'type': 'client',
                    'trash': 0
                },
                select: ['code', 'name', 'mobile']
            }
            $http({
                method: 'POST',
                url: url + 'result',
                data: clientWhere
            }).success(function(clients) {
                if (clients.length > 0) {
                    $scope.clientList = clients;
                } else {
                    $scope.clientList = [];
                }
            });

        } else {

            $scope.getAllClientFn = function() {
                // Get Cleient List Showroom Wise 
                $scope.clientList = [];
                if ($scope.select_godown_code == 'all') {
                    var clientWhere = {
                        table: 'parties',
                        cond: {
                            'status': 'active',
                            'type': 'client',
                            'trash': 0
                        },
                        select: ['code', 'name', 'mobile']
                    }
                }
                else{
                    var clientWhere = {
                        table: 'parties',
                        cond: {
                            'godown_code': $scope.select_godown_code,
                            'status': 'active',
                            'type': 'client',
                            'trash': 0
                        },
                        select: ['code', 'name', 'mobile']
                    }
                }
                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: clientWhere
                }).success(function(clients) {
                    if (clients.length > 0) {
                        $scope.clientList = clients;
                    } else {
                        $scope.clientList = [];
                    }
                });
            }
        }

    });

});