// company transaction controller start here
app.controller('SupplierTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.balance = 0;
	$scope.reallyBalance = 0;
	$scope.reallyTotal = 0;
	$scope.sign = "Receivable";

	$scope.csign = "Receivable";

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

	// get supplier Banlance information
	$scope.getCompanyInfo = function(){
	    
		// get suppplier info
		var partiCond = {
		   	table : "parties",
			cond :{
				code : $scope.code
			},
			select: ['code', 'initial_balance']
	   	};
	   	
	   	$http({
	   		method : 'POST',
	   		url    : url + 'result',
	   		data   : partiCond
	   	}).success(function(response){
	   	    
	   		if (response.length > 0) {
	   		    
	   		    // get all supplier transaction
        		var tranCond = {
        		   	table : "partytransaction",
        			cond :{
        				party_code : response[0].code,
        				trash      : 0
        			},
        			select: ['credit', 'debit']
        	   	};
        	   	
                var transaction= {
                    debit          : 0,
                    credit         : 0,
                    currentBalance : 0,
        	   	};
        
        	   	$http({
        	   		method : 'POST',
        	   		url    : url + 'result',
        	   		data   : tranCond
        	   	}).success(function(tranResponse){

        	   	    if(tranResponse.length > 0){
        	   	        
        	   	        angular.forEach(tranResponse, function(row, i) {
        	   				transaction.credit += parseFloat(row.credit);
        	   				transaction.debit	+= parseFloat(row.debit);
        	   			});

        	   			if(parseFloat(response[0].initial_balance) > 0){
                           transaction.currentBalance = (parseFloat(response[0].initial_balance) + parseFloat(transaction.debit)) - parseFloat(transaction.credit);
                           $scope.balance             = Math.abs(transaction.currentBalance.toFixed(2));
        	   			}else{
                           transaction.currentBalance = parseFloat(transaction.debit) - (parseFloat(transaction.credit) + Math.abs(parseFloat(response[0].initial_balance)));
                           $scope.balance             = Math.abs(transaction.currentBalance.toFixed(2));
        	   			}
        	   			
        	   			$scope.sign = (parseFloat(transaction.currentBalance) >= 0) ? 'Receivable' : 'Payable'; 
        	   	        
        	   	    }else{
                         $scope.balance = Math.abs(parseFloat(response[0].initial_balance).toFixed(2));
                         $scope.sign    = (parseFloat(response[0].initial_balance) >= 0) ? 'Receivable' : 'Payable'; 
        	   	    }
        	   	    
        	   	    if($scope.sign == 'Receivable'){
        	   	        $scope.reallyBalance = $scope.balance;
        	   	    }else{
        	   	        $scope.reallyBalance = -$scope.balance;
        	   	    }
        	   	    
        	   	});
	   		}
	   		
	   	});
	};

	$scope.getTotalFn = function() {
		var total = 0.00;

		if($scope.sign == 'Receivable') {
			total = $scope.balance + $scope.payment;
			$scope.csign = "Receivable";
		} else {
			total = $scope.balance - $scope.payment;

			if(total > 0) {
				$scope.csign = "Payable";
			} else {
				$scope.csign = "Receivable";
			}
		}
		
		if($scope.csign == 'Receivable'){
   	        $scope.reallyTotal = total.toFixed(2);
   	    }else{
   	        $scope.reallyTotal = total.toFixed(2);
   	    }

		return Math.abs(total.toFixed(2));
	}
}]);
