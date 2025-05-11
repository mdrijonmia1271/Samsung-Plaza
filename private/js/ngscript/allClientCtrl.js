app.controller("allClientCtrl",function($scope, $http) {
    $scope.perPage     = "50";
    $scope.reverse     = false;
    $scope.allParty    = [];
    $scope.godown_code = '';
    $scope.balance     = 0;

    $scope.allClient = [];
   
    $scope.$watch('godown_code', function(godown_code) {


    	var where = {
            tableFrom : 'parties',
            tableTo   : 'godowns',
            joinCond  : 'godowns.code=parties.godown_code',
            cond      : {
    			'parties.type'        : 'client',
    			'parties.godown_code' : godown_code,
    			'parties.trash'       : '0'
    		},
    		select    : ['parties.*', 'godowns.name as godown_name']
    	};
    	
    
    	$http({
    		method : "POST",
    		url    : url + 'join',
    		data   : where
    	}).success(function(response) {
    	    
    		if(response.length > 0) {
    			angular.forEach(response, function(row, index) {
    				response[index].sl = index + 1;
    				response[index].balance = 0;
                   
                   // get all current balance and status
    				var condition = {
    						table  : "partytransaction",
                			cond   : {
                				party_code : row.code,
								godown_code : row.godown_code,
                				trash      : 0
                			},
                			select : ['credit', 'debit', 'remission']
    				};
    				
    				$http({
    					method : "POST",
    					url    : url + "result",
    					data   : condition
    				}).success(function(tranResponse){
    					
    					var transaction= {
                            debit          : 0,
                            credit         : 0,
                            remission      : 0,
                            currentBalance : 0,
                	   	};
    					
    					if(tranResponse.length > 0){
        	   	        
            	   	        angular.forEach(tranResponse, function(row, i) {
            	   				transaction.credit += parseFloat(row.credit);
            	   				transaction.debit	+= parseFloat(row.debit);
            	   				transaction.remission	+= parseFloat(row.remission);
            	   			});
            	   			
            	   			if(parseFloat(row.initial_balance) >= 0){
                                transaction.currentBalance = parseFloat(row.initial_balance) + parseFloat(transaction.debit) - (parseFloat(transaction.credit) + parseFloat(transaction.remission));
                                response[index].balance    = transaction.currentBalance.toFixed(2);
            	   			}else{
                                transaction.currentBalance = parseFloat(transaction.debit) - (parseFloat(transaction.credit) + Math.abs(parseFloat(row.initial_balance)) + parseFloat(transaction.remission));
                                response[index].balance    = transaction.currentBalance.toFixed(2);
            	   			}
            	   			
                            response[index].color          = (parseFloat(transaction.currentBalance) < 0) ? 'color: red; font-weight: bold;' : 'color: green; font-weight: bold;'; 
                            response[index].balance_status = (parseFloat(transaction.currentBalance) < 0) ? 'Payable' : 'Receivable'; 
            	   	        
            	   	    }else{
                            //response[index].balance        = Math.abs(parseFloat(row.initial_balance).toFixed(2));
                            response[index].balance        = parseFloat(row.initial_balance).toFixed(2);
                            response[index].color          = (parseFloat(row.initial_balance) < 0) ? 'color: red; font-weight: bold;' : 'color: green; font-weight: bold;'; 
                            response[index].balance_status = (parseFloat(row.initial_balance) < 0) ? 'Payable' : 'Receivable'; 
            	   	    }
    					
    				});
    			});
    			$scope.allParty = response;
    		}
    	});
        		

		// loading
		$("#loading").fadeOut("fast", function(){
	   	 	$("#data").fadeIn('slow');
	   	});
    	
    });
});
