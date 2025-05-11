// Client Ledger Controller
app.controller('clientLedgerCtrl', function($scope, $http) {

    $scope.$watch('godown_code', function(godown_code) {


        if (typeof $scope.godown_code != 'undefined') {

            // Get Cleient List Showroom Wise 
            $scope.clientList = [];

            var clientWhere = {
                table: 'parties',
                cond: {
                    'godown_code': godown_code,
                    'status': 'active',
                    'customer_type': 'dealer',
                    'type': 'client',
                    'trash': 0
                },
                select: ['code', 'name', 'godown_code', 'mobile']
            }

            if(typeof $scope.client_type != "undefined" && $scope.client_type != ""){
                clientWhere.cond.customer_type = $scope.client_type;
            }

            $http({
                method: 'POST',
                url: url + 'result',
                data: clientWhere
            }).success(function(response) {

                if (response.length > 0) {
                    $scope.clientList = response;
                } else {
                    $scope.clientList = [];
                }

            });
        }
    });
});