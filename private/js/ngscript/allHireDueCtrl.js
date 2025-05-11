app.controller("allHireDueCtrl", function($scope, $http) {
    $scope.perPage = "25";
    $scope.reverse = false;
    $scope.allParty = [];
    $scope.godown_code = '';
    $scope.balance = 0;


    $scope.$watch('godown_code', function(godown_code) {
        
        // Get Cleient List Showroom Wise 
        $scope.clientList = [];
        var clientWhere = {
            table: 'parties',
            cond: {
                'customer_type': 'hire',
                'status'       : 'active',
                'type'         : 'client',
                'trash'        : 0
            },
            select: ['code', 'name', 'mobile']
        }
        
        if ($scope.godown_code != 'all') {
            clientWhere.cond['parties.godown_code'] = godown_code;
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
        

        // loading
        $("#loading").fadeOut("fast", function() {
            $("#data").fadeIn('slow');
        });

    });
});