// Client transaction controller 
app.controller('ClientTransactionCtrl', ['$scope', '$http', function($scope, $http) {
    
    $scope.transactionType = 'false';
    $scope.voucherList = [];
    $scope.installment_type = '';
    

    $scope.godown_code = '';
    $scope.clientList = [];
    
    
    // Get Cleient List Showroom Wise 
    $scope.getAllPartiesFn = function() {
        
        // hide and active 
        if($scope.customer_type !== 'dealer'){
            $scope.transactionType = true;
        }else{
            $scope.transactionType = false;
        }
        
        // Get Cleient List Showroom Wise 
        var clientWhere = {
            table: 'parties',
            cond: {
                'godown_code': $scope.godown_code,
                'customer_type': $scope.customer_type,
                'status': 'active',
                'type': 'client',
                'trash': 0
            },
            select: ['code', 'name', 'godown_code', 'mobile']
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
    
    
    $scope.getMobileFn = function(){
        // Get Cleient Mobile Number 
        var clientMobile = {
            table: 'parties',
            cond: {
                'code': $scope.code,
                'godown_code': $scope.godown_code,
                'status': 'active',
                'type': 'client',
                'trash': 0
            },
            select: ['mobile']
        }
        $http({
            method: 'POST',
            url: url + 'result',
            data: clientMobile
        }).success(function(mobile) {
            if (mobile.length > 0) {
                $scope.mobile = mobile[0].mobile;
            } else {
                 $scope.mobile = '';
            }
        });
    }
    
    
    // get all voucher and client initial balance
    $scope.balance = 0;
    $scope.previous_balance = 0;
    $scope.sign = 'Receivable';
    $scope.getAllVoucherFn = function() {
        
        $scope.balance = 0;
        $scope.previous_balance = 0;
        $scope.sign = 'Receivable';
        
        if(typeof $scope.code !== 'undefined'){
        
            var voucherWhere = {
                table : 'saprecords',
                cond  : { 
                    'party_code': $scope.code,
					'godown_code': $scope.godown_code,
                    'due >'     : 0,
                    'trash'     : 0},
                select   : 'voucher_no',
                groupBy : 'voucher_no'
            };
            $http({
                method: 'POST',
                url: url + 'result',
                data: voucherWhere
            }).success(function(voucherRes) {
                if (voucherRes.length > 0) {

                    angular.forEach(voucherRes, function(row, i) {

                        $http({
                            method: 'POST',
                            url: url + 'voucher_due',
                            data: {voucher_no : row.voucher_no}
                        }).success(function(dueResult) {

                            if(parseFloat(dueResult.due) > 0){
                                $scope.voucherList.push({voucher_no: row.voucher_no, due : dueResult.due});
                            }

                        });
                    });
                }else{
                    $scope.voucherList = [];
                }
            });
            
            
            // get current balance and status
            $http({
                method: "POST",
                url: url + "client_balance",
                data: {party_code: $scope.code}
            }).success(function(balanceInfo) {
                
                $scope.balance = Math.abs(parseFloat(balanceInfo.balance));
                $scope.previous_balance = parseFloat(balanceInfo.balance);
                $scope.sign = balanceInfo.status;
            });
        }
    };
    
    
    
    // get voucher info
    $scope.getVoucherInfo = function() {
        
        if(typeof $scope.voucher_no !== 'undefined'){
           
            var vouInfoWhere = {
                table : 'saprecords',
                cond  : { 
                    'voucher_no': $scope.voucher_no,
					'godown_code': $scope.godown_code,
                    'due >'     : 0,
                    'trash'     : 0
                },
                select   : ['voucher_no', 'party_code', 'due', 'installment_type', 'installment_no', 'installment_amount']
            };
            $http({
                method: 'POST',
                url: url + 'result',
                data: vouInfoWhere
            }).success(function(voucherInfoRes) {
                if (voucherInfoRes.length > 0) {
                    $scope.due_amount         = parseFloat(voucherInfoRes[0].due);
                    $scope.installment_amount = parseFloat(voucherInfoRes[0].installment_amount);
                    $scope.installment_type   = voucherInfoRes[0].installment_type;
                }else{
                    $scope.due_amount         = 0;
                    $scope.installment_amount = 0;
                    $scope.installment_type   = '';
                }
            });
            
        }else{
            // reset value
            $scope.due_amount         = 0;
            $scope.installment_amount = 0;
            $scope.installment_type   = '';
        }
    };
   

    $scope.csign = 'Receivable';
    $scope.getTotalFn = function() {
        
        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var remission = !isNaN(parseFloat($scope.remission)) ? parseFloat($scope.remission) : 0;
        var adjustment = !isNaN(parseFloat($scope.adjustment)) ? parseFloat($scope.adjustment) : 0;
        
        var balance = $scope.previous_balance - (payment + remission) + adjustment;
        $scope.csign = (balance < 0) ? "Payable" : "Receivable";
      
        return Math.abs(balance.toFixed(2));
    }
}]);