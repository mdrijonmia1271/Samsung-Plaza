app.controller("allDealerDueCtrl", function($scope, $http) {
   
    $scope.reverse = false;
    $scope.clientList = [];

    $scope.$watch('godown_code', function(godown_code) {
        
        // Get Cleient List Showroom Wise 
        $scope.clientList = [];
        var clientWhere = {
            table: 'parties',
            cond: {
                'customer_type': 'dealer',
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