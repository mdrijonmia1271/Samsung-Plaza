app.controller("lprAddCtrl", ["$scope", "$http", function($scope, $http){
    
    $scope.info = {
        name   : '',
        mobile : '',
        address: '',
        voucher_no: ''
    };
    
    $scope.amount = {
        voucher_bill    : 0.00,
        down_payment    : 0.00,
        total_paid      : 0.00,
        installment_paid: 0.00,
        due             : 0.00,
        remission       : 0.00,
        payment         : 0.0
    };
    
    
    /**
     * Read party information from database table.
     * :table : `parties`
     **/ 
    $scope.partyInfo = function(){
        
        var where = {
            table : 'parties',
            cond : {
                code : $scope.party_code
            }
        };
        
        $http({
            method : "POST",
            url : url + 'read',
            data : where
        }).success(function(info){
            //console.log(info);
            if(info.length > 0){
                $scope.info.name    = info[0].name;
                $scope.info.mobile  = info[0].mobile;
                $scope.info.address = info[0].address;
            }else{
                $scope.info.name    = '';
                $scope.info.mobile  = '';
                $scope.info.address = '';
            }
        });
    }
    
    
    /**
     * Read installment info from database.
     **/
    $scope.installmentInfo = function(){
        
        var where = {
            table : 'saprecords',
            cond : {
                party_code : $scope.party_code
            }
        };
        
        $http({
            method : 'POST',
            url : url +'read',
            data : where
        }).success(function(records){
            //console.log(records);
            if(records.length == 1){
                
                $scope.amount.voucher_bill = parseFloat(records[0].total_bill) - parseFloat(records[0].total_discount) + parseFloat(records[0].paid);
                $scope.amount.down_payment = parseFloat(records[0].paid);
                 
                 
                // read installment paid records from table
                var where = {
                    table : 'installment',
                    cond : {
                        voucher_no : records[0].voucher_no,
                        'installment_given !=' : '0',
                        'trash' : '0'
                    }
                };
                 
                $http({
                    method : "POST",
                    url : url + 'read',
                    data : where
                }).success(function(data){
                    //console.log(data);
                    if(data.length > 0){
                        var total = 0.0;
                        angular.forEach(data, function(value){
                            total += parseFloat(value.installment_amount);
                        });
                        
                        $scope.amount.installment_paid = total;
                    }
                    
                    //console.log($scope.amount.down_payment);
                    //console.log($scope.amount.installment_paid);
                    
                    $scope.amount.total_paid = $scope.amount.down_payment + $scope.amount.installment_paid;
                    $scope.amount.due = $scope.amount.voucher_bill - $scope.amount.total_paid + parseFloat(records[0].total_discount);
                    
                    $scope.amount.commission = parseFloat(records[0].total_discount);
                    
                    
                    // additional info
                    $scope.info.voucher_no = records[0].voucher_no;
                    
                });
                
                // read end here..
                
               
                
            }else{
                $scope.amount.voucher_bill = 0.00;
                $scope.amount.down_payment = 0.00;
                $scope.amount.total_paid   = 0.00;
                $scope.amount.payment      = 0.00;
            }
        });
    }
    
    
    $scope.getTotalBalanceFn = function(){
        var total = 0.0;
        total = parseFloat($scope.amount.due - $scope.amount.payment - $scope.amount.remission);
        return total.toFixed(2);
    }
    
}]);
