// Client Ledger Controller
app.controller('supplierLedgerCtrl', function($scope, $http) {

    $scope.$watch('godown_code', function(godown_code) {

        if (typeof $scope.godown_code != 'undefined') {

            //Get Supplier List Showroom Wise 
            $scope.supplierList = [];
            var supplierWhere = {
                table: 'parties',
                cond: {
                    'godown_code': godown_code,
                    'status': 'active',
                    'type': 'supplier',
                    'trash': 0
                },
                select: ['code', 'name', 'godown_code', 'mobile', 'address']
            }
            $http({
                method: 'POST',
                url: url + 'result',
                data: supplierWhere
            }).success(function (supplier) {
                if (supplier.length > 0) {
                    $scope.supplierList = supplier;
                } else {
                    $scope.supplierList = [];
                }
            });
        }
    });
});