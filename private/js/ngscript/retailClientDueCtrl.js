// sale controller
app.controller('retailClientDueCtrl', function($scope, $http) {
    
    $scope.allParties = [];

    $scope.$watch('godown_code', function(godown_code) {


        if (typeof godown_code != 'undefined') {

            // Get all products initial godown wise
            $scope.allParties = [];
            var partyWhere = {
                table: 'saprecords',
                cond: {
                    'sap_type'   : 'cash',
                    'trash'      : '0',
                    'due >'      : 0
                },
                select: ['party_code', 'address'],
                orderBy: 'ASC'
            }

            if(godown_code !== "all"){
                partyWhere.cond.godown_code = godown_code;
            }

            $http({
                method: 'POST',
                url: url + 'result',
                data: partyWhere
            }).success(function(parties) {

                if (parties.length > 0) {

                    angular.forEach(parties, function(row, i) {
                        var partyInfo = JSON.parse(row.address);
                        var newItem = {
                            name   : (row.party_code != '') ? row.party_code : 'N/A',
                            mobile : partyInfo.mobile,
                            address: partyInfo.address,
                        }

                        $scope.allParties.push(newItem);
                    });

                } else {
                    $scope.allParties = [];
                }

            });
        }

    });

});