app.controller("addCommitmentCtrl", function($scope, $http) {
   
    $scope.clientList = [];
    $scope.userList = [];

    $scope.$watch('godown_code', function(godown_code) {
        
        
        // Get Cleient List Showroom Wise 
        var clientWhere = {
            table: 'parties',
            cond: {
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
        
        // Get User List Showroom Wise 
        var userWhere = {
            table: 'users',
            cond:{},
            select: ['id', 'name', 'mobile']
        }
        
        if ($scope.godown_code != 'all') {
            userWhere.cond['branch'] = godown_code;
        }
        
        $http({
            method: 'POST',
            url: url + 'result',
            data: userWhere
        }).success(function(users) {
            if (users.length > 0) {
                $scope.userList = users;
            } else {
                $scope.userList = [];
            }
        });
        
        
        
        $scope.partyInfo = [
            mobile = '',
            address = ''
        ];
        
        // default party data 
        if(typeof $scope.party_code !== 'undefined'){
            var partyWhere = {
                table: 'parties',
                cond: {
                    'code'  : $scope.party_code,
                    'trash' : 0
                },
                select: ['mobile', 'address']
            }
            
            if ($scope.godown_code != 'all') {
                clientWhere.cond['parties.godown_code'] = godown_code;
            }
            
            $http({
                method: 'POST',
                url: url + 'result',
                data: partyWhere
            }).success(function(partyResponse) {
                if (partyResponse.length > 0) {
                    $scope.partyInfo.mobile = partyResponse[0].mobile;
                    $scope.partyInfo.address = partyResponse[0].address;
                } 
            });
        }
        
        // get party info
        $scope.getUserInfoFn = function(){
            
            if(typeof $scope.party_code !== 'undefined'){
                
                var partyWhere = {
                    table: 'parties',
                    cond: {
                        'code'  : $scope.party_code,
                        'trash' : 0
                    },
                    select: ['mobile', 'address']
                }
                
                if ($scope.godown_code != 'all') {
                    clientWhere.cond['parties.godown_code'] = godown_code;
                }
                
                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: partyWhere
                }).success(function(partyResponse) {
                    if (partyResponse.length > 0) {
                        $scope.partyInfo.mobile = partyResponse[0].mobile;
                        $scope.partyInfo.address = partyResponse[0].address;
                    } 
                });
            }
        }
    });
});