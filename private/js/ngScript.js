var app = angular.module("MainApp", ['angularUtils.directives.dirPagination','ngSanitize']);

// var url = window.location.origin + '/ajax/';
// var siteurl = window.location.origin + '/';

// Split pathname into parts
var pathParts = window.location.pathname.split('/');

// Check if running in subfolder (like localhost/bakulinternational.xyz)
var folder = pathParts[1];
var isLocalWithFolder = window.location.hostname === 'localhost' && folder !== '';

// Build base URL dynamically
var baseUrl = window.location.origin + (isLocalWithFolder ? '/' + folder : '') + '/ajax/';

// Final result URL
var url = baseUrl;

//var url = window.location.origin + '/ajax/';
//var siteurl = window.location.origin + '/';

// custom filter in Angular js
app.filter('removeUnderScore', function() {
	return function(input) {
		return input.replace(/_/gi, " ");
	}
});

app.filter('textToLower', function() {
	return function(input) {
		return input.replace(/_/gi, " ").toLowerCase();
	}
});

//remove underscore and ucwords
app.filter("textBeautify", function(){
	return function (str) {
		var str = str.replace(/_/gi, " ").toLowerCase(),
        	txt = str.replace(/\b[a-z]/g, function(letter) {
        		return letter.toUpperCase();
    		});

    	return txt;
    }
});

//remove dash and ucwords
app.filter("removeDash",function(){
	return function (str) {
	  var str = str.replace(/-/gi, " ").toLowerCase();
          txt = str.replace(/\b[a-z]/g, function(letter) {
         return letter.toUpperCase();
     });
    return txt;
   }
});


app.filter('join', function(){
	return function(input) {
		console.log(typeof input);
		return (typeof input==='object') ? "" : input.join();
	}
});


app.filter("showStatus",function(){
	return function(input){
        if(input == 1){
        	return "Available";
        }else{
        	return "Not Available";
        }
	}
});


app.filter("status",function(){
	return function(input){
        if(input == "active"){
        	return "Running";
        }else{
        	return "Blocked";
        }
	}
});


app.filter("fNumber",function(){
	return function(input){
		var myNum = new Intl.NumberFormat('en-IN').format(input);
		return  myNum;
	}
});



// show All Materials Ctrl
app.controller("showAllMaterials",['$scope','$http',function($scope,$http){
	$scope.allMaterials = [];
	$scope.perPage = "20";
	var where = {
		table : "materials",
		cond  : {
			type : "raw",
			trash : "0"
		}
	};

	$http({
		method : "POST",
		url    : url + "read",
		data   : where
	}).success(function(response){
		if(response.length > 0){
			angular.forEach(response,function(row,key){
				row['sl'] = key +1;
				$scope.allMaterials.push(row);
			});
		}else{
			$scope.allMaterials = [];
		}

		//Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});
	});
}]);


//show all Category
app.controller("showcategoryCtrl", function($scope, $http, $log){
	$scope.reverse = false;
	$scope.perPage = "20";
	$scope.categories = [];

	var obj = { 'table': 'category' };

	$http({
		method:'POST',
		url:url+'read',
		data:obj
	}).success(function(response) {
		angular.forEach(response, function(values, index) {
			values['sl'] = index + 1;
			$scope.categories.push(values);
		});

		 //Pre Loader
			  $("#loading").fadeOut("fast",function(){
				  $("#data").fadeIn('slow');
			 });

		//$log.log($scope.categories);
	});
});

//show all Sub Category
app.controller("showsubcategoryCtrl",function($scope,$http,$log){
	$scope.reverse=false;
	$scope.perPage="20";
	$scope.subcategorys=[];
	var obj={'table':'subcategory'};
	$http({
		method:'POST',
		url:url+'read',
		data:obj
	}).success(function(response){
		angular.forEach(response,function(values,index){
		  values['sl']=index+1;
		  $scope.subcategorys.push(values);
		});

		 //Pre Loader
			  $("#loading").fadeOut("fast",function(){
				  $("#data").fadeIn('slow');
			 });

	  //$log.log($scope.subcategorys);
	});

});



//show all Product Controller
app.controller("showAllProductCtrl", function($scope, $http){
	$scope.perPage	= "20";
	$scope.products	= [];

	var where = {
		table:'materials',
		cond : {
			type  : "finish_product",
			trash : "0"
		}
	};


	$http({
		method : 'POST',
		url    : url+'read',
		data   : where
	}).success(function(response) {
		if(response.length > 0){
			angular.forEach(response,function(values, index){
				values['sl'] = index + 1;
				$scope.products.push(values);
			});
		} else {
			$scope.products = [];
		}

		//Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});
	});
});



//show all Party from the database controller
app.controller("allCompanyCtrl",function($scope,$http){
   $scope.perPage="10";
   $scope.reverse=false;
   $scope.allParty=[];

	var where = {
		table: "parties",
		cond:{type: "company"}
	};

	$http({
		method: "POST",
		url: url + "read",
		data: where
	}).success(function(response) {
		if(response.length > 0) {
			angular.forEach(response, function(row, index) {
				response[index].sl = index + 1;

               var where = {
				   	table: "partybalance",
					cond:{code: row.code}
			   	};

				$http({
					method: "POST",
					url:	url + "read",
					data:	where
				}).success(function(item){

					response[index].initial_balance=Math.abs(item[0].initial_balance);
					response[index].balance=Math.abs(item[0].balance);

					if (item[0].balance < 0) {
						response[index].color = 'color: red; font-weight: bold;';
						response[index].status = 'Payable';
					}else{
						response[index].color = 'color: green; font-weight: bold;';
						response[index].status = 'Receivable';
					}

				});

			});

			$scope.allParty = response;
			console.log(response);
		}
		//loading
		$("#loading").fadeOut("fast",function(){
	   	 	$("#data").fadeIn('slow');
	   	 });

	});

});



//show all Party from the database controller
app.controller("allClientCtrl",function($scope, $http) {
   $scope.perPage 	= "50";
   $scope.reverse 	= false;
   $scope.allParty 	= [];

	var condition = {
		from : "parties",
		join : "partybalance",
		cond : "parties.code = partybalance.code",
		where : {
			'parties.type'  : "client",
			'parties.trash' : "0"
		}
	};




	$http({
		method: "POST",
		url: url + "readJoinData",
		data: condition
	}).success(function(response) {
		if(response.length > 0) {
			angular.forEach(response, function(row, index) {
				row.sl = index + 1;
				row.security_money = 0.00;

				row.balanceColor = (row.balance >= 0) ? "green" : "red";
				row.clColor = (row.credit_limit >= 0) ? "green" : "red";

				row.balance = Math.abs(row.balance);
				row.credit_limit = Math.abs(row.credit_limit);


				// get meta info
				var metaWhere = {
					table: 'partymeta',
					cond: {"party_code": row.code, "meta_key": "security"}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: metaWhere
				}).success(function(metaData) {
					if(metaData.length > 0) {
						var data = angular.fromJson(metaData[0].meta_value);

						angular.forEach(data, function(item) {
							row.security_money += parseFloat(item.amount);
						});
					}
				});

        		$scope.allParty.push(row);

				console.log($scope.allParty);
			});

		}


		// loading
		$("#loading").fadeOut("fast", function(){
	   	 	$("#data").fadeIn('slow');
	   	});

		console.log(response);

	});

});





//clientalltransaction ctrl
app.controller("clientAllTransactionCtrl",function($scope,$http){
    $scope.getPartyInfo = function(){

      var where = {
         table : "parties",
         cond : {
             type: "client",
             code : $scope.party_code,
             trash : 0
          }
       };

       console.log(where);

       $http({
         method : "POST",
         url : url + "read",
         data : where
       }).success(function(response){
         if(response.length == 1){
           $scope.name = response[0].name + " [ " + response[0].address+ " ]";
           console.log($scope.name);
         }else{
           $scope.name = "";
         }
       });
    };
});





//client ledger ctrl
app.controller("clientLedgerCtrl",function($scope,$http){
    $scope.getPartyInfo = function(){

      var where = {
         table : "parties",
         cond : {
             type: "client",
             code : $scope.party_code,
             status : "active",
             trash : 0
          }
       };

       console.log(where);

       $http({
         method : "POST",
         url : url + "read",
         data : where
       }).success(function(response){
         if(response.length == 1){
           $scope.name = response[0].name + " [ " + response[0].address+ " ]";
           console.log($scope.name);
         }else{
           $scope.name = "";
         }
       });
    };
});










// add purchase entry
app.controller('PurchaseEntry', function($scope, $http){
	$scope.active = true;
	$scope.cart = [];
	$scope.amount = {
		total: 0,
		totalDiscount: 0,
		grandTotal: 0,
		paid: 0,
		due: 0
	};
	$scope.validation = false;

	$scope.exists = function() {
		var where = {
			table: "saprecords",
			cond: {voucher_no: $scope.voucherNo}
		};

		$http({
			method: "POST",
			url: url + "read",
			data: where
		}).success(function(response) {
			if(response.length > 0) {
				$scope.validation = true;
			} else {
				$scope.validation = false;
			}
		});
	}

	$scope.partyInfo = {
		balance: 0.00,
		payment: 0.00,
		sign: 'Receivable',
		csign: 'Receivable'
	};

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.partyInfo.sign == 'Receivable'){
			total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

			if(total >= 0) {
				$scope.partyInfo.csign = "Receivable";
			} else {
				$scope.partyInfo.csign = "Payable";
			}
		} else {
			total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

			if(total > 0) {
				$scope.partyInfo.csign = "Payable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		}

		return Math.abs(total.toFixed(2));
	}

	$scope.setPartyfn = function() {
		var condition = {
			from: 'parties',
			join: 'partybalance',
			cond: 'parties.code=partybalance.code',
			where: {'parties.code': $scope.partyCode}
		};

		$http({
			method: "POST",
			url: url + "readJoinData",
			data: condition
		}).success(function(response){
			if(response.length > 0){
				$scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

				if(parseFloat(response[0].balance) >= 0) {
					$scope.partyInfo.sign = "Receivable";
				} else {
					$scope.partyInfo.sign = "Payable";
				}

				console.log(response);
			}
		});
	}

	$scope.addNewProductFn = function(){
		if(typeof $scope.product !== 'undefined'){
			$scope.active = false;

			var condition = {
				table: 'materials',
				cond: {
					code   : $scope.product,
					status : "available"
				}
			};

			$http({
				method: 'POST',
				url: url + 'read',
				data: condition
			}).success(function(response){
				if(response.length == 1){
					var name = response[0].name;
					var str = name.replace(/_/gi, " ").toLowerCase();
						name = str.replace(/\b[a-z]/g, function(letter) {
					           return letter.toUpperCase();
				         });

					var item = {
						product: name,
						product_code: response[0].code,
						price: parseFloat(response[0].price),
						quantity: (typeof $scope.quantity === 'undefined') ? 0 : $scope.quantity,
						discount: 0.00,
						subtotal: 0.00,
						godown: 1
					};

					$scope.cart.push(item);
				}else{
					$scope.cart = [];
				}

				console.log($scope.cart);
			});
		}
	}


	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
		return $scope.cart[index].subtotal.toFixed(2);
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});

		$scope.amount.total = total.toFixed(2);
		return $scope.amount.total;
	}

	$scope.getTotalDiscountFn = function() {
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.discount);
		});

		$scope.amount.totalDiscount = total.toFixed(2);
		return $scope.amount.totalDiscount;
	}

	$scope.getGrandTotalFn = function(){
		$scope.amount.grandTotal = parseFloat($scope.amount.total - $scope.amount.totalDiscount);
		return $scope.amount.grandTotal.toFixed(2);
	}

	$scope.getTotalDueFn = function() {
		$scope.amount.due = $scope.amount.grandTotal - $scope.amount.paid;
		return $scope.amount.due.toFixed(2);
	}

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	}

});






// Edit Purchase Entry
app.controller('EditPurchaseEntry', function($scope, $http) {
	$scope.partyInfo = {
		partyCode: '',
		previousBalance: 0.00,
		currentBalance: 0.00,
		sign: 'Receivable',
		csign: 'Payable'
	};

	$scope.amount = {
		oldTotal: 0.00,
		newTotal: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00
	};

	$scope.$watch('vno', function(voucherNo) {
		$scope.records = [];

		// get purchase record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no=sapitems.voucher_no',
			where: {'saprecords.voucher_no': voucherNo}
		};

		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response){
			if(response.length > 0) {
				angular.forEach(response, function(row, index){

					var where = {
						table : "materials",
						cond : { code : row.product_code}
					};

					$http({
						method : "POST",
						url    : url + "read",
						data   : where
					}).success(function(result){
						response[index].product_name = result[0].name;
					});


					response[index].discount = parseFloat(row.discount);
					response[index].paid = parseFloat(row.paid);
					response[index].purchase_price = parseFloat(row.purchase_price);
					response[index].old_purchase_price = parseFloat(row.purchase_price);
					response[index].oldQuantity = parseInt(row.quantity);
					response[index].newQuantity = parseInt(row.quantity);
					response[index].sale_price = parseFloat(row.sale_price);
					response[index].oldSubtotal = 0.00;
					response[index].newSubtotal = 0.00;
				});

				// get party balance info
				$scope.partyInfo.partyCode = response[0].party_code;

				$http({
					method: 'POST',
					url: url + 'read',
					data: {
						table: 'partybalance',
						cond: {code: response[0].party_code}
					}
				}).success(function(info){
					var balance = parseFloat(info[0].balance);

					$scope.partyInfo.previousBalance = Math.abs(balance);
					$scope.partyInfo.sign = (balance > 0) ? 'Receivable' : 'Payable';

					//console.log(info);
				});

				$scope.amount.date = response[0].sap_at;
				$scope.amount.voucher = response[0].voucher_no;
				$scope.amount.partyCode = response[0].party_code;
				$scope.amount.sapType = response[0].sap_type;

				$scope.amount.oldTotal = parseFloat(response[0].total_bill);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);

				$scope.records = response;
			}

			console.log($scope.records);
		});
	});

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.old_purchase_price * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.purchase_price * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getOldGrandTotalFn = function() {
		$scope.amount.oldGrandTotal = $scope.amount.oldTotal - $scope.amount.oldTotalDiscount;
		return $scope.amount.oldGrandTotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += item.newSubtotal;
		});

		$scope.amount.newTotal = total;
		return $scope.amount.newTotal;
	}

	$scope.getNewTotalDiscountFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item){
			total += item.discount;
		});

		$scope.amount.newTotalDiscount = total;
		return $scope.amount.newTotalDiscount;
	}

	$scope.getNewGrandTotalFn = function() {
		$scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.amount.newTotalDiscount;
		return $scope.amount.newGrandTotal;
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;

		total = $scope.amount.newGrandTotal - $scope.amount.oldGrandTotal;
		$scope.amount.sign = (total < 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference;
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.amount.sign == 'Receivable' && $scope.partyInfo.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.amount.paid) + $scope.partyInfo.previousBalance;
			$scope.partyInfo.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.partyInfo.sign == 'Payable'){
			total = ($scope.amount.difference + $scope.amount.paid) - $scope.partyInfo.previousBalance;
			if(total >= 0){
				$scope.partyInfo.csign = 'Receivable';
			} else {
				$scope.partyInfo.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.partyInfo.sign == 'Receivable'){
			total = $scope.amount.difference - ($scope.amount.paid + $scope.partyInfo.previousBalance);
			if(total <= 0){
				$scope.partyInfo.csign = 'Receivable';
			} else {
				$scope.partyInfo.csign = 'Payable';
			}
		} else {
			total = $scope.amount.difference + ($scope.partyInfo.previousBalance - $scope.amount.paid);
			if(total > 0){
				$scope.partyInfo.csign = 'Payable';
			} else {
				$scope.partyInfo.csign = 'Receivable';
			}
		}

		return Math.abs(total);
	}
});




// show Raw Stock Ctl
app.controller("showRawStockCtl",['$scope','$http',function($scope,$http){
	$scope.perPage = "20";
	$scope.allRawStocks = [];

	var where = {
		table : "stock",
		cond  : {
			 'type': "raw",
			 'quantity >': '0'
		 }
	};

	$http({
		method  : "POST",
		url     : url + "read",
		data    : where
	}).success(function(response){
		if(response.length > 1){
			angular.forEach(response,function(row,key){
				row['sl'] = key + 1;
				$scope.allRawStocks.push(row);
			});
		}else{
			$scope.allRawStocks = [];
		}

		// loading
		$("#loading").fadeOut("fast", function(){
			$("#data").fadeIn('slow');
		});
	});
}]);




// show Finish Product Stock Ctl
app.controller("showFinishProductStockCtl",['$scope','$http',function($scope,$http){
	$scope.perPage = "20";
	$scope.allfinishProduct = [];

	var where = {
		table : "stock",
		cond  : {
			 type : "finish_product"
		 }
	};

	$http({
		method  : "POST",
		url     : url + "read",
		data    : where
	}).success(function(response){
		if(response.length > 0){
			angular.forEach(response,function(row,key){
				row['sl'] = key + 1;
				$scope.allfinishProduct.push(row);
			});
		}else{
			$scope.allfinishProduct = [];
		}

		// loading
		$("#loading").fadeOut("fast", function(){
			$("#data").fadeIn('slow');
		});
	});
}]);





// get product name
app.directive("productName", ['$http', function($http) {
	return {
		template: "<span>{{name}}</span>",
		scope: {
			productCode: "="
		},
		link: function(scope) {
			var where = {
				table: 'products',
				cond: {'product_code': scope.productCode}
			};

			$http({
				method: 'POST',
				url: url + 'read',
				data: where
			}).success(function(response) {
				scope.name = response[0].product_name;
				console.log(response);
			});
		}
	}
}]);










// do sale controller
app.controller('DOSaleEntryCtrl', function($scope, $http) {
	$scope.active = true;
	$scope.cart = [];

	$scope.amount = {
		labour : 0,
		total: 0,
		discount: 0,
		truck_rent : 0,
		grandTotal: 0,
		paid: 0,
		due: 0
	};

	$scope.doNo = [];

	$scope.setAllBrand = function(){
		var condition = {
			table: 'stock',
			cond: {
				category: $scope.category,
				type: 'do'
			},
			column: 'subcategory'
		};

		$http({
			method: 'POST',
			url: url + 'readDistinct',
			data: condition
		}).success(function(response){
			$scope.allSubcategory = response;
		});
	}

	$scope.setAllProducts = function() {
		var condition = {
			table: 'stock',
			cond: {
				category: $scope.category,
				subcategory: $scope.subcategory,
				type: 'do'
			},
			column: 'product_name'
		};

		$http({
			method: 'POST',
			url: url + 'readDistinct',
			data: condition
		}).success(function(response){
			$scope.allProducts = response;
		});
	}


    //set all do no
	$scope.setAllDONoFn = function(){
		$scope.allDONO = [];

		var condition = {
			table: 'stock',
			cond: {
				category: $scope.category,
				subcategory: $scope.subcategory,
				product_name: $scope.product,
				type: 'do'
			}
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			if(response.length > 0){
				angular.forEach(response, function(items, key){
					if((items.do_in - items.do_out) > 0){
						$scope.allDONO.push(items);
					}
				 });
		     }else{
			  $scope.allDONO = [];
		   }
		});
	}



	//get all available do stock from db
	$scope.getdoStockFn = function(){

		var where = {
			table : "stock",
			cond : { do_no : $scope.do_no}
		};

		$http({
			method : "POST",
			url : url + "read",
			data : where
		}).success(function(response){
			$scope.unit = response[0].unit;
			$scope.available = (response[0].do_in - response[0].do_out) + " " + response[0].unit + "s   Available!";
		    $scope.remainingStock = (response[0].do_in - response[0].do_out);
		});
	};

	$scope.addNewProductFn = function(){
		if(typeof $scope.product !== 'undefined' && $scope.remainingStock >0){
			$scope.active = false;
			var condition = {
				table: 'stock',
				cond: {
					do_no : $scope.do_no,
					category: $scope.category,
					subcategory: $scope.subcategory,
					product_name: $scope.product,
					unit: $scope.unit,
					godown: $scope.showroom_id,
					showroom_id: $scope.showroom_id,
					type: 'do'
				}
			};

			$http({
				method: 'POST',
				url: url + 'read',
				data: condition
			}).success(function(response){
				angular.forEach(response, function(item){
					//Getting purchase price Start here
					var condd = {
						table: 'products',
						cond: {product_name: item.product_name}
					};

					$http({
						method: 'POST',
						url: url + 'read',
						data: condd
					}).success(function(product_info){
						//Getting purchase price End here
						var brand  =  (item.subcategory).replace(/_/gi, " ").toLowerCase();
						var newItem = {
							do_no : item.do_no,
							product: item.product_name,
							product_code: item.product_code,
							category: item.category,
							subcategory: item.subcategory,
							brand : brand,
							godown: item.godown,
							price: parseFloat(item.sell_price),
							maxQuantity: (parseInt(item.do_in) - parseInt(item.do_out)),
							stock_qty: item.do_in,
							quantity: 1.00,
							unit: $scope.unit,
							discount: 0.00,
							subtotal: 0.00,
							godown: item.godown,
							purchase_price: parseFloat(item.purchase_price)
						};


					// for single product sale
						if($scope.cart.length == 0){
							$scope.cart.push(newItem);
						}else{
							console.log($scope.cart.indexOf(brand));
						  if($scope.cart.indexOf(brand) > 0){
							$scope.cart.push(newItem);
						  }
						}



					});
				});
			});
		}
	}

	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
		return $scope.cart[index].subtotal;
	}

	$scope.purchaseSubtotalFn = function(index){
		$scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
		return $scope.cart[index].purchase_subtotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});

		$scope.amount.total = total;
		return $scope.amount.total;
	}

	$scope.getPurchaseTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.purchase_subtotal);
		});

		$scope.amount.purchase_total = total;
		return $scope.amount.purchase_total;
	}

	/* $scope.getGrandTotalFn = function(){
		var grand_total = 0.0;
		grand_total = parseFloat($scope.amount.total - $scope.amount.discount - $scope.commission.total) + parseFloat($scope.amount.truck_rent) + parseFloat($scope.amount.labour);
		return $scope.amount.grandTotal = grand_total.toFixed(2);
	}*/

	$scope.getGrandTotalFn = function(){
		var grand_total = 0.0;


		grand_total = (parseFloat($scope.amount.total) - parseFloat($scope.amount.truck_rent)) + parseFloat($scope.amount.labour);
		return $scope.amount.grandTotal = grand_total.toFixed(2);
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.partyInfo.sign == 'Receivable'){
			total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

			if(total > 0) {
				$scope.partyInfo.csign = "Receivable";
			} else if(total < 0) {
				$scope.partyInfo.csign = "Payable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		} else {
			total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

			if(total > 0) {
				$scope.partyInfo.csign = "Payable";
			} else if(total < 0) {
				$scope.partyInfo.csign = "Receivable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		}

		$scope.amount.due = total.toFixed(2) ;

		console.log($scope.stype, 1);
		if($scope.stype == "cash") {
			$scope.isDisabled = (Math.abs(total.toFixed(2)) > 0) ? true : false;
		}

		return Math.abs(total.toFixed(2));
	}

	console.log($scope.amount.due);

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	}

	$scope.partyInfo = {
		code: '',
		name: '',
		contact: '',
		address: '',
		balance: 0.00,
		payment: 0.00,
		limit : 0.00,
		sign: 'Receivable',
		csign: 'Receivable'
	};

	$scope.findPartyFn = function(){
		if(typeof $scope.partyCode != 'undefined'){
			var condition = {
				from: 'parties',
				join: 'partybalance',
				cond: 'parties.code=partybalance.code',
				where: {'parties.code': $scope.partyCode , 'partybalance.brand' : $scope.cart[0].brand}
			};
		//console.log(condition);

			$http({
				method: 'POST',
				url: url + 'readJoinData',
				data: condition
			}).success(function(response){

				if(response.length > 0){
					$scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

					if(parseFloat(response[0].balance) > 0) {
						$scope.partyInfo.sign = "Payable";
					} else if(parseFloat(response[0].balance) < 0) {
						$scope.partyInfo.sign = "Receivable";
					} else {
						$scope.partyInfo.sign = "Receivable";
					}

					$scope.partyInfo.code = response[0].code;
					$scope.partyInfo.name = response[0].name;
					$scope.partyInfo.contact = response[0].contact;
					$scope.partyInfo.address = response[0].address;
					$scope.partyInfo.limit = response[0].credit_limit;
				} else {
					$scope.partyInfo = {};

					$scope.partyInfo.balance = 0.00;
					$scope.partyInfo.sign = "Receivable";
				}

				console.log($scope.partyInfo);
			});
		}
	}

	// get commission total
	$scope.commission = {
		quantity : 0,
		amount : 0,
		total: 0.0
	};

	// get less total
	$scope.less = {
		quantity : 0,
		amount : 0
	};

	// get Truck total
	$scope.truck = {
		quantity : 0,
		amount : 0
	};

	$scope.totalQuantityFn = function() {
		var total = 0;

		angular.forEach($scope.cart, function(item, index){
			total += item.quantity;
		});

		$scope.truck.quantity = total;
		$scope.commission.quantity = total;

		return $scope.truck.quantity;
	}

	$scope.getTruckTotal = function(){
		return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
	};

	$scope.getCommissionTotal = function(){
		return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
	};

	$scope.getLessTotal = function(){
		return $scope.amount.discount = (parseFloat($scope.less.quantity) * parseFloat($scope.less.amount)).toFixed(2);
	};


});










// sale controller
app.controller('SaleEntryCtrl', function($scope, $http) {

	$scope.active = true;
	$scope.active1 = false;
	$scope.cart = [];

	$scope.stype = "cash";

        $scope.presentBalance = 0.00;
        $scope.isDisabled = false;

	$scope.remaining_commission = 0;
	$scope.total_commission_amount = 0.00;



	$scope.amount = {
		labour : 0,
		total: 0,
		totalqty: 0,
		truck_rent : 0,
		grandTotal: 0,
		paid: 0,
		due: 0
	};


	//get sale type
	$scope.getsaleType = function(type){
		if(type == "cash"){
			$scope.active = true;
			$scope.active1 = false;
			$scope.partyInfo.balance = 0.00;
			$scope.partyInfo.sign = "Receivable";
		}else{
			$scope.active = false;
			$scope.active1 = true;
			$scope.partyCode = "";
			$scope.partyInfo.code = "";
			$scope.partyInfo.contact = "";
			$scope.partyInfo.address = "";
		}
	};





	$scope.addNewProductFn = function(){
		if(typeof $scope.product !== 'undefined'){

			var condition = {
				table: 'stock',
				cond: {
					code   : $scope.product.trim(),
					unit   : "Kg",
					godown : $scope.showroom_id,
					type   : 'finish_product'
				}
			};

			//console.log(condition);

			$http({
				method: 'POST',
				url: url + 'read',
				data: condition
			}).success(function(response){
				angular.forEach(response, function(item){
					//Getting production cost  Start here
					var condd = {
						table: 'materials',
						cond: {
							code        : item.code,
							type        : 'finish_product',
							status      : 'available',
							trash       : 0
						}
					};
					
					//console.log(condd);

					var name = item.name,
					    str = name.replace(/_/gi, " ").toLowerCase();
						name = str.replace(/\b[a-z]/g, function(letter) {
					   return letter.toUpperCase();
				   });


					$http({
						method: 'POST',
						url: url + 'read',
						data: condd
					}).success(function(product_info){
						//Getting production cost End here
						var newItem = {
							product              : name,
							product_code         : item.code,
							godown               : item.godown,
							maxQuantity          : parseInt(item.quantity),
							stock_qty            : parseInt(item.quantity),
							quantity             : 1.00,
							bags                 : 0.00,
							unit                 : "Kg",
							subtotal             : 0.00,
							purchase_price       : parseFloat(product_info[0].production_cost),
							sale_price           : parseFloat(product_info[0].price),
						};

						$scope.cart.push(newItem);
						//console.log($scope.cart);
					});
				});
			});
		}
	}


	//calculate Bags no
	$scope.calculateBags = function(i,size){
		var bag_no = 0.00;
        bag_no = parseFloat($scope.cart[i].quantity) / parseFloat(size);
		$scope.cart[i].bags = bag_no.toFixed(2);
		return $scope.cart[i].bags;
	};



	//calculate commission
	$scope.calculateTotalCommission = function(){
		var total = parseFloat($scope.amount.total),
		    totalCommission = 0.00,
			remainingCommission = 0;

		remainingCommission  = parseInt(6 - $scope.commission);
		$scope.remaining_commission = remainingCommission;

		totalCommission = parseFloat(total * (parseFloat($scope.commission)/100));
		$scope.total_commission_amount = totalCommission.toFixed(2);

        return $scope.total_commission_amount;
	};




	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
		return $scope.cart[index].subtotal.toFixed();
	}

	$scope.purchaseSubtotalFn = function(index){
		$scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
		return $scope.cart[index].purchase_subtotal.toFixed();
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});

		$scope.amount.total = total.toFixed();
		return $scope.amount.total;
	}

	$scope.getTotalQtyFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.quantity);
		});

		$scope.amount.totalqty = total;
		return $scope.amount.totalqty;
	}

	$scope.getPurchaseTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.purchase_subtotal);
		});

		$scope.amount.purchase_total = total.toFixed();
		return $scope.amount.purchase_total;
	}

	$scope.getGrandTotalFn = function(){
		var grand_total = 0.0;

		grand_total = (parseFloat($scope.amount.total)  - parseFloat($scope.amount.truck_rent) - $scope.total_commission_amount) + parseFloat($scope.amount.labour);
		return $scope.amount.grandTotal = grand_total.toFixed(2);
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.partyInfo.sign == 'Receivable') {
			total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

			if(total > 0) {
				$scope.partyInfo.csign = "Receivable";
			} else if(total < 0) {
				$scope.partyInfo.csign = "Payable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		} else {
			total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

			if(total > 0) {
				$scope.partyInfo.csign = "Payable";
			} else if(total < 0) {
				$scope.partyInfo.csign = "Receivable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		}

		$scope.amount.due = total.toFixed(2);
		$scope.presentBalance = Math.abs(total.toFixed(2));

	     /*
		  console.log("Current Balance =>" +  $scope.presentBalance);
	      console.log("Current Sign =>" + $scope.partyInfo.csign);
		  console.log("Credit Limit =>" + $scope.partyInfo.cl);
		 */

		if($scope.stype == "credit"){
			if($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.cl){
			   $scope.isDisabled = false;
			   $scope.message = "";
		   }else if($scope.partyInfo.csign == "Payable"){
			   $scope.isDisabled = false;
			   $scope.message = "";
		   }else{
			   $scope.isDisabled = true;
			   $scope.message = "Total is being crossed the Credit Limit!";
		   }
		}

		return $scope.presentBalance;
	}

	$scope.partyInfo = {
		code: '',
		name: '',
		contact: '',
		address: '',
		balance: 0.00,
		payment: 0.00,
		cl : 0.00,
		sign: 'Receivable',
		csign: 'Receivable'
	};

	$scope.findPartyFn = function() {
		if(typeof $scope.partyCode != 'undefined'){
			var condition = {
				from: 'parties',
				join: 'partybalance',
				cond: 'parties.code=partybalance.code',
				where: {'parties.code': $scope.partyCode}
			};

			$http({
				method: 'POST',
				url: url + 'readJoinData',
				data: condition
			}).success(function(response){
				if(response.length > 0){
					$scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

					if(parseFloat(response[0].balance) > 0) {
						$scope.partyInfo.sign = "Receivable";
					} else if(parseFloat(response[0].balance) < 0) {
						$scope.partyInfo.sign = "Payable";
					} else {
						$scope.partyInfo.sign = "Receivable";
					}

					$scope.partyInfo.code = response[0].code;
					$scope.partyInfo.name = response[0].name;
					$scope.partyInfo.contact = response[0].mobile;
					$scope.partyInfo.address = response[0].address;
					$scope.partyInfo.cl = parseFloat(response[0].credit_limit);
				} else {
					$scope.partyInfo = {};

					$scope.partyInfo.balance = 0.00;
					$scope.partyInfo.sign = "Receivable";
					$scope.partyInfo.cl = 0.00;
				}
				//console.log($scope.partyInfo);
			});
		}
	}


	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	}
});







//  Edit Sale Ctrl
app.controller('EditSaleEntryCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.info = {};
	$scope.records = [];
	$scope.oldLabourCost = 0.00;

	$scope.amount = {
		labour : 0.00,
		oldTotal: 0.00,
		discount: 0.00,
		newTotal: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00,
		prevoiusPaid: 0.00,
		truck_rent : 0.00
	};




	// get commission total
	$scope.commission = {
		quantity : 0,
		amount : 0,
		total: 0.0
	};

	// get Truck total
	$scope.truck = {
		quantity : 0,
		amount : 0,
		total:0.00
	};




	$scope.$watch('info.vno', function(voucherNo) {
		// get sale record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no = sapitems.voucher_no',
			where: {'saprecords.voucher_no': voucherNo}
		};

    	//console.log(transmit);

		// take action
		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response) {

			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					response[index].discount = parseFloat(row.discount);
					response[index].paid = parseFloat(row.paid);
					response[index].oldQuantity = parseInt(row.quantity);
					response[index].newQuantity = parseInt(row.quantity);
					response[index].purchase_price = parseFloat(row.purchase_price);
					response[index].newSalePrice = parseFloat(row.sale_price);
					response[index].oldSalePrice = parseFloat(row.sale_price);
					response[index].oldSubtotal = 0.00;
					response[index].newSubtotal = 0.00;



					var where = {
						table : "stock",
						cond : {
							code   : row.product_code,
							unit   : "Kg",
							type   : "finish_product",
							godown : 1
						}
					};

					$http({
						method : "POST",
						url : url + "read",
						data : where
					}).success(function(info){
						if(info.length > 0){
							response[index].product= info[0].name;
						}
					});
				});





				// get sapmeta info
				var condition = {
					table: 'sapmeta',
					cond: {'sapmeta.voucher_no': voucherNo}
				};

				$http({
					method: 'POST',
					url: url + 'read',
					data: condition
				}).success(function(result){
					//console.log(result);
				if(result.length > 0){
						angular.forEach(result, function(row, index){
							if(row.meta_key == "truck_fare"){
								$scope.amount.truck_rent = parseFloat(row.meta_value);
								$scope.oldTruckRent = parseFloat(row.meta_value);
							}
							if(row.meta_key == "commission"){$scope.commission = row.meta_value;}
							if(row.meta_key == "remaining_commission"){$scope.remaining_commission = row.meta_value;}
							if(row.meta_key == "labour_cost"){
								$scope.amount.labour = parseFloat(row.meta_value);
								$scope.oldLabourCost = parseFloat(row.meta_value);
							}

						});
					}

				});




				//get party information
				var party_where = {
					table:'parties',
					cond:{code: response[0].party_code}
				}

				$http({
					method: 'POST',
					url: url + 'read',
					data: party_where
				}).success(function(response){
					$scope.info.partyName = response[0].name;
					$scope.info.partyCode = response[0].code;
					$scope.info.partyMobile = response[0].mobile;
					$scope.info.partyAddress = response[0].address;
				});


				// get party balance information

				$scope.info.partyCode = response[0].party_code;

				$http({
					method: 'POST',
					url: url + 'read',
					data: {
						table: 'partybalance',
						cond: {code: response[0].party_code}
					}
				}).success(function(info) {
					var balance = parseFloat(info[0].balance);

					$scope.info.previousBalance = Math.abs(balance);
					$scope.info.sign = (balance >= 0) ? 'Receivable' : 'Payable';

					console.log(info);
				});





				$scope.info.date = response[0].sap_at;
				$scope.info.sapType = response[0].sap_type;
				$scope.info.voucher = response[0].voucher_no;
				$scope.info.partyCode = response[0].party_code;
				$scope.amount.previousPaid = response[0].paid;

				$scope.total_commission_amount = parseFloat(response[0].total_discount);




				$scope.amount.oldTotal = parseFloat(response[0].total_bill) + parseFloat(response[0].total_discount);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);


				$scope.records = response;

			}

			console.log($scope.records);
		});
	});

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.newSalePrice * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getOldGrandTotalFn = function() {	      
		$scope.amount.oldGrandTotal = ($scope.amount.oldTotal - $scope.amount.oldTotalDiscount-$scope.amount.discount)+ $scope.oldLabourCost- $scope.oldTruckRent;
		return $scope.amount.oldGrandTotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += (item.newSubtotal) + $scope.amount.labour;
		});

		$scope.amount.newTotal = total;
		return $scope.amount.newTotal;
	}

	$scope.getNewGrandTotalFn = function() {
		$scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.amount.newTotalDiscount - $scope.amount.truck_rent;
		return $scope.amount.newGrandTotal;
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;

		total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
		$scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference;
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
			$scope.info.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable'){
			total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
			if(total >= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
			if(total <= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else {
			total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
			if(total > 0){
				$scope.info.csign = 'Payable';
			} else {
				$scope.info.csign = 'Receivable';
			}
		}

		return Math.abs(total);
	}


	$scope.totalQuantityFn = function() {
		var total = 0;

		angular.forEach($scope.records, function(item, index){
			total += item.newQuantity;
		});

		$scope.truck.quantity = total;
		$scope.commission.quantity = total;

		return $scope.truck.quantity;
	}

	$scope.getTruckTotal = function(){
		return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
	};

	$scope.getCommissionTotal = function(){
		return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
	};


}]);




//  Return Sale Ctrl
app.controller('ReturnSaleEntryCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.info = {};
	$scope.records = [];

	$scope.amount = {
		labour : 0.00,		
		oldTotal: 0.00,
		discount: 0.00,
		newTotal: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00,		
		truck_rent : 0.00
	};




	// get commission total
	$scope.commission = 0.00;
	$scope.remaining_commission = 0.00;
	
	

	// get Truck total
	$scope.truck = {
		quantity : 0,
		amount : 0,
		total:0.00
	};




	$scope.$watch('info.vno', function(voucherNo) {
		// get sale record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no = sapitems.voucher_no',
			where: {'saprecords.voucher_no': voucherNo}
		};

    	//console.log(transmit);

		// take action
		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response) {

			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					response[index].discount = parseFloat(row.discount);
					response[index].paid = parseFloat(row.paid);
					response[index].oldQuantity = parseInt(row.quantity);
					response[index].newQuantity = parseInt(row.quantity);
					response[index].purchase_price = parseFloat(row.purchase_price);
					response[index].newSalePrice = parseFloat(row.sale_price);
					response[index].oldSalePrice = parseFloat(row.sale_price);
					response[index].oldSubtotal = 0.00;
					response[index].newSubtotal = 0.00;



					var where = {
						table : "stock",
						cond : {
							code   : row.product_code,
							unit   : "Kg",
							type   : "finish_product",
							godown : 1
						}
					};

					$http({
						method : "POST",
						url : url + "read",
						data : where
					}).success(function(info){
						if(info.length > 0){
							response[index].product= info[0].name;
						}
					});
				});





				// get sapmeta info
				var condition = {
					table: 'sapmeta',
					cond: {'sapmeta.voucher_no': voucherNo}
				};

				$http({
					method: 'POST',
					url: url + 'read',
					data: condition
				}).success(function(result){
					console.log(result);
				if(result.length > 0){
						angular.forEach(result, function(row, index){
							if(row.meta_key == "truck_fare"){
								$scope.amount.truck_rent = parseFloat(row.meta_value);
								$scope.oldTruckRent = parseFloat(row.meta_value);
							}
							if(row.meta_key == "commission"){$scope.commission = row.meta_value;}
							if(row.meta_key == "remaining_commission"){$scope.remaining_commission = row.meta_value;}
							if(row.meta_key == "labour_cost"){
								$scope.amount.labour = parseFloat(row.meta_value);
								$scope.oldLabourCost = parseFloat(row.meta_value);
							}

						});
					}
					
					console.log($scope.commission);

				});




				//get party information
				var party_where = {
					table:'parties',
					cond:{code: response[0].party_code}
				}

				$http({
					method: 'POST',
					url: url + 'read',
					data: party_where
				}).success(function(response){
					$scope.info.partyName = response[0].name;
					$scope.info.partyCode = response[0].code;
					$scope.info.partyMobile = response[0].mobile;
					$scope.info.partyAddress = response[0].address;
				});


				// get party balance information

				$scope.info.partyCode = response[0].party_code;

				$http({
					method: 'POST',
					url: url + 'read',
					data: {
						table: 'partybalance',
						cond: {code: response[0].party_code}
					}
				}).success(function(info) {
					var balance = parseFloat(info[0].balance);

					$scope.info.previousBalance = Math.abs(balance);
					//$scope.info.sign = (balance <= 0) ? 'Receivable' : 'Payable';
					$scope.info.sign = (balance >= 0) ? 'Receivable' : 'Payable'; // Edit by sheam

					console.log(info);
				});





				$scope.info.date = response[0].sap_at;
				$scope.info.sapType = response[0].sap_type;
				$scope.info.voucher = response[0].voucher_no;
				$scope.info.partyCode = response[0].party_code;

				$scope.total_commission_amount = parseFloat(response[0].total_discount);

				$scope.amount.oldTotal = parseFloat(response[0].total_bill);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);


				$scope.records = response;

			}

			console.log($scope.records);
		});
	});
	
	

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.newSalePrice * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getOldGrandTotalFn = function() {
	
		$scope.amount.oldGrandTotal = $scope.amount.oldTotal;
		
		return $scope.amount.oldGrandTotal;
		
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += (item.newSubtotal) + $scope.amount.labour;
		});

		$scope.amount.newTotal = total;
		return $scope.amount.newTotal;
	}
	
	
	$scope.getTotalQtyFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item){
			total += parseFloat(item.newQuantity);
		});

		$scope.amount.totalqty = total;
		return $scope.amount.totalqty;
	}

	$scope.getNewGrandTotalFn = function()   {
		//$scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.amount.newTotalDiscount - $scope.amount.truck_rent;
		//$scope.amount.newGrandTotal = $scope.amount.newTotal;
		//return $scope.amount.newGrandTotal;
		
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += (item.newSubtotal) + $scope.amount.labour;
		});

		$scope.amount.newGrandTotal = total - $scope.amount.oldTotalDiscount - $scope.oldTruckRent ;
		return $scope.amount.newGrandTotal;
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;

		total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
		$scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference.toFixed(2);
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
			$scope.info.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable'){
			total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
			if(total >= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable'){
			//total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
			total = ($scope.info.previousBalance - $scope.amount.difference) + $scope.amount.paid; //Edit by Sheam
			if(total < 0){
				$scope.info.csign = 'Payable';
			} else {
				$scope.info.csign = 'Receivable';
			}
		} else {
			total = $scope.amount.difference + ($scope.info.previousBalance - $scope.amount.paid);
			
			if(total > 0){
				$scope.info.csign = 'Payable';
			} else {
				$scope.info.csign = 'Receivable';
			}
		}

		return Math.abs(total.toFixed(2));
	}


	$scope.totalQuantityFn = function() {
		var total = 0;

		angular.forEach($scope.records, function(item, index){
			total += item.newQuantity;
		});

		$scope.truck.quantity = total;
		$scope.commission.quantity = total;

		return $scope.truck.quantity;
	}

	$scope.getTruckTotal = function(){
		return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
	};

	$scope.getCommissionTotal = function(){
		return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
	};


}]);









// do edit sale controller
app.controller('DOEditSaleCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.info = {};
	$scope.records = [];

	$scope.amount = {
		oldTotal: 0.00,
		newTotal: 0.00,
		discount: 0.00,
		oldTotalDiscount: 0.00,
		newTotalDiscount: 0.00,
		oldGrandTotal: 0.00,
		newGrandTotal: 0.00,
		paid: 0.00
	};

	$scope.$watch('info.vno', function(voucherNo) {
		// get sale record
		var transmit = {
			from: 'saprecords',
			join: 'sapitems',
			cond: 'saprecords.voucher_no=sapitems.voucher_no',
			where: {'saprecords.voucher_no': voucherNo}
		};

		// take action
		$http({
			method: 'POST',
			url: url + 'readJoinData',
			data: transmit
		}).success(function(response) {
			$scope.info.newQuantity = 0;

			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					$scope.info.newQuantity += parseInt(row.newQuantity);

					response[index].discount 		= parseFloat(row.discount);
					response[index].paid 			= parseFloat(row.paid);
					response[index].oldQuantity 	= parseInt(row.quantity);
					response[index].newQuantity 	= parseInt(row.quantity);
					response[index].purchase_price 	= parseFloat(row.purchase_price);
					response[index].newSalePrice 	= parseFloat(row.sale_price);
					response[index].oldSalePrice 	= parseFloat(row.sale_price);
					response[index].oldSubtotal 	= 0.00;
					response[index].newSubtotal 	= 0.00;

					var where = {
						table : "products",
						cond : {product_code : row.product_code}
					};

					$http({
						method : "POST",
						url : url + "read",
						data : where
					}).success(function(info){
						if(info.length > 0){
							response[index].product= info[0].product_name;
							response[index].brand= info[0].subcategory;
						}
					});
				});

				console.log(response);

				// get sr or dsr information
				var condition = {
					table: 'sapmeta',
					cond: {'sapmeta.voucher_no': voucherNo}
				};

				$http({
					method: 'POST',
					url: url + 'read',
					data: condition
				}).success(function(response) {
					if(response.length > 0){
						angular.forEach(response, function(row, index){
							if(row.meta_key == 'sr'){$scope.info.sr = row.meta_value;}
							if(row.meta_key == 'dsr'){$scope.info.dsr = row.meta_value;}
						});
					}

					console.log(response);
				});


				//get party information
				var party_where = {
					table:'parties',
					cond:{code: response[0].party_code}
				}

				$http({
					method: 'POST',
					url: url + 'read',
					data: party_where
				}).success(function(response){
					console.log(response);

					$scope.info.partyMobile = response[0].contact;
				});

				// get party balance information
				$scope.info.partyCode = response[0].party_code;

				$http({
					method: 'POST',
					url: url + 'read',
					data: {
						table: 'partybalance',
						cond: {code: response[0].party_code}
					}
				}).success(function(info) {
					var balance = 0.00;
					if(typeof info != "undefined"){
						balance = parseFloat(info[0].balance);
					}


					$scope.info.previousBalance = Math.abs(balance);
					$scope.info.sign = (balance <= 0) ? 'Receivable' : 'Payable';
				});

				// get voucher meta
				$http({
					method: 'POST',
					url: url + 'read',
					data: {
						table: 'sapmeta',
						cond: {voucher_no: response[0].voucher_no}
					}
				}).success(function(meta) {
					if(meta.length > 0) {
						angular.forEach(meta, function(row, key) {
							$scope.info[row.meta_key] = row.meta_value;

							if(row.meta_key == 'truck_amount') {
								$scope.info[row.meta_key] = parseFloat(row.meta_value);
							}

							if(row.meta_key == 'commission_amount') {
								$scope.info[row.meta_key] = parseFloat(row.meta_value);
							}

							if(row.meta_key == 'labour_cost') {
								$scope.info[row.meta_key] = parseFloat(row.meta_value);
							}
						});
					}
				});

				$scope.info.date 		= response[0].sap_at;
				$scope.info.sapType 	= response[0].sap_type;
				$scope.info.voucher 	= response[0].voucher_no;
				$scope.info.partyCode 	= response[0].party_code;

				$scope.amount.oldTotal 	= parseFloat(response[0].total_bill);
				$scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);

				$scope.records = response;

				console.log($scope.info);
			}

			console.log(response);
		});
	});

	$scope.getOldSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
		});

		return $scope.records[index].oldSubtotal;
	}

	$scope.getNewSubtotalFn = function(index){
		angular.forEach($scope.records, function(item){
			item.newSubtotal = item.newSalePrice * item.newQuantity;
		});

		return $scope.records[index].newSubtotal;
	}

	$scope.getOldGrandTotalFn = function() {
		$scope.amount.oldGrandTotal = $scope.amount.oldTotal - $scope.amount.oldTotalDiscount;
		return $scope.amount.oldGrandTotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.records, function(item) {
			total += item.newSubtotal;
		});

		$scope.amount.newTotal = total + $scope.info.labour_cost;
		return $scope.amount.newTotal;
	}

	$scope.getNewGrandTotalFn = function() {
		$scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.info.truck_rent - $scope.amount.discount;
		return $scope.amount.newGrandTotal;
	}

	$scope.getGrandTotalDifferenceFn = function() {
		var total = 0.00;

		total = $scope.amount.newGrandTotal - $scope.amount.oldGrandTotal;
		$scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
		$scope.amount.difference = Math.abs(total);

		return $scope.amount.difference;
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
			$scope.info.csign = 'Receivable';
		} else if($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable'){
			total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
			if(total >= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else if($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable'){
			total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
			if(total <= 0){
				$scope.info.csign = 'Receivable';
			} else {
				$scope.info.csign = 'Payable';
			}
		} else {
			total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
			if(total > 0){
				$scope.info.csign = 'Payable';
			} else {
				$scope.info.csign = 'Receivable';
			}
		}

		return Math.abs(total);
	}

	$scope.getTotalProductQuantityFn = function() {
		var total = 0.00;

		angular.forEach($scope.records, function(row, index) {
			total += row.newQuantity;
		});

		$scope.info.newQuantity = total;

		return $scope.info.newQuantity;
	}

	$scope.getTotalTruckRentFn = function() {
		var total = 0.00;

		total = $scope.info.newQuantity * $scope.info.truck_amount;
		$scope.info.truck_rent = total;

		return $scope.info.truck_rent;
	}

	$scope.getCommissionTotalFn = function() {
		var total = 0.00;

		total = $scope.info.newQuantity * $scope.info.commission_amount;
		$scope.info.commission_total = total;

		return $scope.info.commission_total;
	}

}]);











// sale controller
app.controller('ReturnSaleCtrl', function($scope, $http){
	$scope.cart = [];
	$scope.amount = {
		total: 0,
		paid: 0,
		due: 0
	};

	$scope.info = {};

	$scope.$watch('vno', function(){
		var condition = {
			table: 'sale',
			cond: { voucher_number: $scope.vno }
		}

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			angular.forEach(response, function(item){
				var row = {
					id: item.id,
					category: item.category,
					subcategory: item.subcategory,
					godown: item.godown,
					product: item.product,
					oldQuantity: parseInt(item.quantity),
					quantity: parseInt(item.quantity),
					discount: parseInt(item.discount),
					returnQuantity: 0,
					price: parseFloat(item.price),
					subtotal: parseFloat(item.subtotal),
					date: item.date,
					voucher: item.voucher_number,
					paid: parseFloat(item.paid),
					due: parseFloat(item.due)
				};

				$scope.cart.push(row);

				$scope.amount.paid = row.paid;
				$scope.amount.due = row.due;
				$scope.amount.discount = row.discount;

				$scope.info.date = row.date;
				$scope.info.voucher = row.voucher;
			});
		});
	});

	$scope.changeQuantityFn = function(index) {
		$scope.cart[index].quantity;
		console.log($scope.cart[index]);
		return ($scope.cart[index].quantity - $scope.cart[index].returnQuantity);
	}

	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * ( $scope.cart[index].quantity - $scope.cart[index].returnQuantity);
		return $scope.cart[index].subtotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += item.subtotal;
		});

		$scope.amount.total = total;
		return $scope.amount.total;
	}

	$scope.getGrandTotalFn = function(){
		var total = 0;
		total = $scope.amount.total - $scope.amount.discount;
		$scope.amount.grandTotal = total;

		return $scope.amount.grandTotal;
	}

	$scope.getTotalDueFn = function(){
		$scope.amount.due = $scope.amount.total - $scope.amount.paid;
		return $scope.amount.due;
	}

});










// Due Payment Controller
app.controller('DuePaymentCtrl', function($scope, $http){
	$scope.cart = [];
	$scope.amount = {
		total: 0,
		paid: 0,
		diposit : 0.00,
		remission : 0.00,
		due: 0
	};
	$scope.info = {};

	$scope.$watch('vno', function(){
		var condition = {
			table: 'sale',
			cond: { voucher_number: $scope.vno }
		}

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			angular.forEach(response, function(item){
				var row = {
					id: item.id,
					category: item.category,
					subcategory: item.subcategory,
					godown: item.godown,
					product: item.product,
					oldQuantity: parseInt(item.quantity),
					newQuantity: parseInt(item.quantity),
					price: parseFloat(item.price),
					subtotal: parseFloat(item.subtotal),
					grand_total: parseFloat(item.grand_total),
					discount: parseFloat(item.discount),
					date: item.date,
					voucher: item.voucher_number,
					paid: parseFloat(item.paid),
					remission : parseFloat(item.remission),
					due: parseFloat(item.due)
				};

				$scope.cart.push(row);

				$scope.amount.paid = row.paid;
				$scope.amount.discount = row.discount;
				$scope.amount.total_remission = row.remission;
				$scope.amount.grand_total = row.grand_total;
				$scope.amount.due = row.due;

				$scope.info.date = row.date;
				$scope.info.voucher = row.voucher;
				console.log($scope.cart);
			});
		});
	});

	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].newQuantity;
		return $scope.cart[index].subtotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += item.subtotal;
		});

		$scope.amount.total = total;
		return $scope.amount.total;
	}


	$scope.getTotalDueFn = function(d, r,tr){
		var paid = $scope.amount.paid + parseFloat(d) + parseFloat(r) + parseFloat(tr);
		$scope.amount.due = $scope.amount.grand_total - paid;
		return $scope.amount.due;
	}

});











// credit sale controller
app.controller('CreditSaleEntryCtrl', function($scope, $http){
	$scope.active = true;
	$scope.cart = [];
	$scope.amount = {
		total: 0,
		totalDiscount: 0,
		grandTotal: 0,
		paid: 0,
		due: 0
	};

	$scope.setAllSubcategory = function(){
		var condition = {
			table: 'stock',
			cond: {category: $scope.category},
			column: 'subcategory'
		};

		$http({
			method: 'POST',
			url: url + 'readDistinct',
			data: condition
		}).success(function(response){
			$scope.allSubcategory = response;
			// console.log(response);
		});
	}

	$scope.setAllProducts = function(){
		var condition = {
			table: 'stock',
			cond: {
				category: $scope.category,
				subcategory: $scope.subcategory
			},
			column: 'product_name'
		};

		$http({
			method: 'POST',
			url: url + 'readDistinct',
			data: condition
		}).success(function(response){
			$scope.allProducts = response;
			// console.log(response);
		});
	}

	/*
	$scope.setAllGodownsFn = function(){
		var condition = {
			table: 'stock',
			cond: {
				category: $scope.category,
				subcategory: $scope.subcategory,
				product_name: $scope.product
			},
			column: 'godown'
		};

		$http({
			method: 'POST',
			url: url + 'readDistinct',
			data: condition
		}).success(function(response){
			$scope.allGodown = response;
			// console.log(response);
		});
	}
	*/

	$scope.addNewProductFn = function(){
		if(typeof $scope.product !== 'undefined'){
			$scope.active = false;

			var condition = {
				table: 'stock',
				cond: {
					category: $scope.category,
					subcategory: $scope.subcategory,
					product_name: $scope.product,
					godown: $scope.showroom_id,
					showroom_id: $scope.showroom_id
				}
			};

			// console.log(condition);

			$http({
				method: 'POST',
				url: url + 'read',
				data: condition
			}).success(function(response){
				angular.forEach(response, function(item){
					var newItem = {
						product: item.product_name,
						category: item.category,
						subcategory: item.subcategory,
						price: parseFloat(item.sell_price),
						maxQuantity: parseInt(item.quantity),
						quantity: 1,
						discount: 0.00,
						subtotal: 0.00,
						godown: item.godown
					};

					$scope.cart.push(newItem);
				});
			});
		}
	}

	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
		return $scope.cart[index].subtotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});

		$scope.amount.total = total;
		return $scope.amount.total;
	}

	$scope.getTotalDueFn = function(){
		$scope.amount.due = $scope.amount.total - $scope.amount.paid;
		return $scope.amount.due;
	}

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	}


	$scope.findMemberFn = function(){
		var condition = {
			table: 'members',
			cond: {member_id: $scope.memberID}
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			if(response.length > 0){
				$scope.memberInfo = {
					member: response[0].member_full_name,
					address: 'গ্রাম: ' + response[0].member_village + ', উপজেলা: ' + response[0].member_police_station + ', জেলা:' + response[0].member_district,
					mobile: response[0].member_mobile_number,
					photo: siteurl + response[0].member_photo
				};
			} else {
				$scope.memberInfo = {
					member: '',
					address: '',
					mobile: '',
					photo: siteurl + 'public/members/default.jpg'
				};
			}
		});
	}

	$scope.getInstallmentTKFn = function(){
		var total = 0.00;
		total = (parseFloat($scope.amount.due) / parseFloat($scope.installment_quantity)).toFixed(2);

		$scope.amount_quantity = total;
	}

	$scope.installmentTypeFn = function(){
		if($scope.type == "weekly"){
			$scope.dateActive=true;
			$scope.dayActive=false;
		}else{
			$scope.dateActive=false;
			$scope.dayActive=true;
		}
	}

});











//Edit Credit Sale
app.controller('CreditSaleEditCtrl', function($scope, $http){
  $scope.cart = [];
  $scope.amount = {total: 0,paid: 0,due: 0};
  $scope.info = {};

	$scope.$watch('vno', function(){
		var condition = {
			table: 'sale',
			cond: { voucher_number: $scope.vno }
		}

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			angular.forEach(response, function(item){
				var row = {
					id: item.id,
					category: item.category,
					subcategory: item.subcategory,
					godown: item.godown,
					product: item.product,
					oldQuantity: parseInt(item.quantity),
					newQuantity: parseInt(item.quantity),
					price: parseFloat(item.price),
					subtotal: parseFloat(item.subtotal),
					date: item.date,
					voucher: item.voucher_number,
					paid: parseFloat(item.paid),
					due: parseFloat(item.due)
				};

				$scope.cart.push(row);

				$scope.amount.paid = row.paid;

				$scope.info.date = row.date;
				$scope.info.voucher = row.voucher;
			});
		});

		var where={
			table:'loan',
			cond:{voucher_number:$scope.vno}
		 };

		$http({
			method: 'POST',
			url: url + 'read',
			data: where
		}).success(function(response){
		console.log(response);
			if(response.length==1){
				angular.forEach(response,function(value){

                   $scope.installment_quantity= parseFloat(value.installment_no);
                   $scope.amount_quantity = parseFloat(value.amount_per_installment);
                   $scope.type=(value.installment_type);

                   if($scope.type=="weekly"){
                   	 $scope.dateActive=true;
			         $scope.dayActive=false;
                   }else{
                   	 $scope.dateActive=false;
			         $scope.dayActive=true;
                   }

                   $scope.installment_date = value.installment_date;
                   $scope.installment_day = value.installment_day;
			   });
			}
		});

	});


	$scope.setSubtotalFn = function(index){
		$scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].newQuantity;
		return $scope.cart[index].subtotal;
	}

	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += item.subtotal;
		});

		$scope.amount.total = total;
		return $scope.amount.total;
	}

	$scope.getTotalDueFn = function(){
		$scope.amount.due = $scope.amount.total - $scope.amount.paid;
		return $scope.amount.due;
	}

	$scope.getInstallmentTKFn=function(){
	 $scope.amount_quantity = $scope.amount.due / $scope.installment_quantity;
	}

	$scope.installmentTypeFn=function(){
		if($scope.type == "weekly"){
			$scope.dateActive=true;
			$scope.dayActive=false;
		}else{
			$scope.dateActive=false;
			$scope.dayActive=true;
		}
	}

});


// Installment Contrller
app.controller('InstallmentCtrl', function($scope){
	$scope.installment = 1;
	$scope.lessAmount = 0;

	$scope.totalAmountFn = function(amount){
		var total = 0.00;
		if($scope.installment_number == 1){
			total = $scope.due;
		}else{
			total = ((amount * $scope.installment) - $scope.lessAmount).toFixed(2)
		}
		return total;
	}

});






//SMS Controller
app.controller("CustomSMSCtrl", ["$scope", "$log", function($scope, $log){
	$scope.msgContant = "";
	$scope.totalChar = 0;
	$scope.msgSize = 1;

	$scope.$watch(function(){
		var charLength = $scope.msgContant.length,
		message = $scope.msgContant,
		messLen = 0;
		
		
		
		
	var english = /^[~!@#$%^&*(){},.:/-_=+A-Za-z0-9 ]*$/;
	
	if (english.test(message)){
	        if( charLength <= 160){ messLen = 1; }
		else if( charLength <= 306){ messLen = 2; }
		else if( charLength <= 459){ messLen = 3; }
		else if( charLength <= 612){ messLen = 4; }
		else if( charLength <= 765){ messLen = 5; }
		else if( charLength <= 918){ messLen = 6; }
		else if( charLength <= 1071){ messLen = 7; }
		else if( charLength <= 1080){ messLen = 8; }
		else { messLen = "Equal to an MMS!"; }		
		
	}else{
	        if( charLength <= 63){ messLen = 1; }
		else if( charLength <= 126){ messLen = 2; }
		else if( charLength <= 189){ messLen = 3; }
		else if( charLength <= 252){ messLen = 4; }
		else if( charLength <= 315){ messLen = 5; }
		else if( charLength <= 378){ messLen = 6; }
		else if( charLength <= 441){ messLen = 7; }
		else if( charLength <= 504){ messLen = 8; }		
		else { messLen = "Equal to an MMS!"; }
	}

		

		$scope.totalChar = charLength;
		$scope.msgSize = messLen;
	});
}]);


app.controller('AllCustomerCtrl', function($scope, $http, $window){
	var getAllCustomer = function(){
		$scope.results = [];
		var condition = {
			table: 'orders',
			groupBy: 'name'
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){
			angular.forEach(response, function(row, key){
				row.sl = (key + 1);
			});

			$scope.results = response;
		});
	}


	$scope.deleteCustomerFn = function(ono){
		var condition = {
			table: 'orders',
			cond: {order_no: ono}
		};

		if ($window.confirm("Are you sure want to delete this Customer?")) {
            $http({
				method: 'POST',
				url: url + 'delete',
				data: condition
			}).success(function(response){
				getAllCustomer();
			});
        }
	}

	// call the function
	getAllCustomer();
});









app.controller('SearchReportCtrl', function($scope, $http, $window){
	var loadData = function(){
		$scope.orders = [];
		var condition = {
			table: 'orders',
			cond: {},
			groupBy: 'order_no'
		};

		if(typeof $scope.search !== "undefined"){
			angular.forEach($scope.search, function(value, field){
				if(value !== ""){
					condition.cond[field] = value;
				}
			});

			if(typeof $scope.date !== "undefined"){
				angular.forEach($scope.date, function(value, field){
					if(value != "" && field == "from"){condition.cond["order_date >="] = value;}
					if(value != "" && field == "to"){condition.cond["order_date <="] = value;}
				});
			}
		} else {
			alert("Please Selete Status!");
			return false;
		}

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response){

			if(response.length>0){
				console.log(response);
				$scope.active=false;
				angular.forEach(response, function(item, key){
				  item.sl = key + 1;
			    });
			  $scope.orders = response;
			}else{
				$scope.orders = [];
				$scope.active=true;
			}

		});
	}

	$scope.searchDataFn = function(){
		// call the loader
		loadData();
	}

	$scope.getGrandTotalFn = function(){
		var total = 0;
		angular.forEach($scope.orders, function(item){
			total += parseFloat(item.grand_total);
		});

		return total.toFixed(2);
	}
});













// show All Stock Product Ctrl
app.controller('showAllStockProductCtrl', function($scope, $http, $log) {
	$scope.$watch('showroom_id', function(){
		$scope.allStockProducts = [];
	    $scope.reverse = false;

	    var where = {
	    	table:'stock',
				cond: {
					type: 'retail',
					'quantity >=': 0
				}
	    };

			if($scope.showroom_id != "godown"){
				where.cond.showroom_id =  $scope.showroom_id;
			}

			console.log(where);


	    //console.log($scope.showroom_id);

	    if($scope.privilege == "admin" && $scope.showroom_id == "godown") {
			where.cond = {type: 'retail', 'quantity >=' : 0};
	    }

		//console.log(where);
		$http({
			method:'POST',
			url:url+'read',
			data:where
		}).success(function(response){
			console.log(response);

			//Loader
			$("#loading").fadeOut("fast", function(){
				$(".loader-hide").fadeIn('slow');
			});

			angular.forEach(response, function(value, key){
				value['sl'] = key + 1;

				//Getting showroom value Start here
			    var condition = {
			    	table: 'showroom',
					cond: {showroom_id: value.showroom_id}
			    };

				$http({
					method: 'POST',
					url: url + 'read',
					data: condition
				}).success(function(emit){
					// console.log(emit);
					if(emit.length > 0){
						value["godown_name"] = emit[0].name;
					}
				});

				// Getting showroom value End here
				$scope.allStockProducts.push(value);
			});

		  	$log.log($scope.allStockProducts);
		});
	});

	$scope.getTotalFn=function(index){
		var total = 0.00;

		total = $scope.allStockProducts[index].quantity * $scope.allStockProducts[index].sell_price;

		$scope.allStockProducts[index].total = total;

		return $scope.allStockProducts[index].total;
	}

	$scope.getQuantityTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += parseInt(item.quantity);
		});

	  	return total;
	}

	$scope.getGrandTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += item.total;
		});

	  	return total;
	}

});











// show All Stock Product Ctrl
app.controller('showAllDOStockProductCtrl', function($scope, $http, $log) {
	$scope.$watch('showroom_id', function(){
		$scope.allStockProducts = [];
	    $scope.reverse = false;

	    var where = {
	    	table:'stock',
			cond: {type: 'do', 'do_in >' : 0}
	    };


		$http({
			method:'POST',
			url:url+'read',
			data:where
		}).success(function(response){

			//Loader
			$("#loading").fadeOut("fast", function(){
				$(".loader-hide").fadeIn('slow');
			});

			angular.forEach(response, function(value, key){
				value['sl'] = key + 1;


				// get company name
			    var condition = {
			    	table: 'saprecords',
					cond: {voucher_no : value.do_no}
			    };

				$http({
					method: 'POST',
					url: url + 'read',
					data: condition
				}).success(function(response){

				value['date'] = response[0].sap_at;

				  var where =  {
				  	table : "parties",
				  	cond : { code : response[0].party_code}
				  };

				  $http({
				  	method : "POST",
				  	url : url + "read",
				  	data : where

				  }).success(function(item){
				  	value["company"] = item[0].name;
				  });

				});


				$scope.allStockProducts.push(value);


			});

		});
	});

	$scope.getTotalFn=function(index){
		var total = 0.00;

		total = $scope.allStockProducts[index].do_in * $scope.allStockProducts[index].purchase_price;

		$scope.allStockProducts[index].total = total;

		return $scope.allStockProducts[index].total;
	}

	$scope.getDoInTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += parseInt(item.do_in);
		});
		return total;
	}

	$scope.getDoOutTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += parseInt(item.do_out);
		});
		return total;
	}

	$scope.getRemainingTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += parseInt(item.do_in - item.do_out);
		});
		return total;
	}

	$scope.getGrandTotalFn=function(){
		var total = 0;
		angular.forEach($scope.allStockProducts, function(item){
			total += item.total;
		});
	  return total;
	}
});













//Product Distribution
app.controller("productDistribution",function($scope,$http,$log){

	$scope.ShowProduct=function(){
	    var where={
	    	table:'showroom',
			cond: {showroom_id: $scope.showroom}
	    };
		$http({
			method:'POST',
			url:url+'read',
			data:where
		}).success(function(response){
			var p_type = response[0].type;
			//colecting Product Information Start here
			var where={
		    	table:'stock',
				cond: {
					type: p_type,
					showroom_id: "godown",
					godown: $scope.godown,
					"quantity >": 0
				}
	    	};
	    	//console.log(where);
			$http({
				method:'POST',
				url:url+'read',
				data:where
			}).success(function(response){
				$scope.allProducts=response;
				//console.log($scope.allProducts);
			});

			//colecting Product Information End here
		});

	}

	$scope.itemName = [];
	$scope.cart = [];
	$scope.addCart = function(){
	    var where = {
	    	table: 'stock',
			cond: {id: $scope.product_id}
	    };

		$http({
			method:'POST',
			url:url+'read',
			data:where
		}).success(function(response){
			var items = $scope.itemName;

			if(response.length > 0) {
				if(items.indexOf(response[0].product_name) == -1){
					var each_data = {
						type: response[0].type,
						category: response[0].category,
						product_name: response[0].product_name,
						subcategory: response[0].subcategory,
						quantity:response[0].quantity,
						sell_price:response[0].sell_price,
						godown:response[0].godown,
						showroom_id:response[0].showroom_id
					}

					$scope.itemName.push(each_data.product_name);
					$scope.cart.push(each_data);
				}
			}
		});

		// console.log($scope.cart);
	}

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
		$scope.itemName.splice(index, 1);

		//console.log($scope.itemName)
	}

});

















// payroll controller
app.controller("PayrollCtrl", ["$scope", "$http","$window","$interval", function($scope, $http,$window,$interval){
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.msg = {active: true, content: ""};

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.data.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response){
			// get data
			if(response.length == 1){
				$scope.profile.eid = response[0].emp_id;
				$scope.profile.name = response[0].name;
				$scope.profile.post = response[0].designation;
				$scope.profile.mobile = response[0].mobile;
				$scope.profile.email = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image = siteurl + response[0].path;

				$scope.profile.active = true;
				console.log(response);
			} else {
				console.log("Employee not found!");
				$scope.msg.active = false;
				//$scope.msg.content = "Employee not found!";

				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
			}

		});
	}

	$scope.saveDataFn = function() {
		// chack existance
		var transmit = {
			table: "salary_structure",
			where: {eid: $scope.data.eid}
		};

		$http({
			method: "POST",
			url: siteurl + 'payroll/addBasicSalaryCtrl/exists',
			data: transmit
		}).success(function(response) {
			var transmit = {
				table: "salary_structure",
				dataset: $scope.data
			};

			// store the info
			if(parseInt(response) === 1){
				transmit.dataset = {basic: $scope.data.basic}
				transmit.where = {eid: $scope.data.eid};
			}

			$http({
				method: "POST",
				url: siteurl + 'payroll/addBasicSalaryCtrl/save',
				data: transmit
			}).success(function(response) {
				$scope.msg.active = true;
				$scope.msg.content = response;

				$interval(function(){$window.location.reload();},5000);

				console.log(response);
			});
		});
	}
}]);










// Incentive Controller
app.controller("IncentiveCtrl", ["$scope", "$http", function($scope, $http){
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.incentives = [
		{fields: "HRA", percentage: 0},
		{fields: "DA", percentage: 0},
		{fields: "TA", percentage: 0},
		{fields: "CCA", percentage: 0},
		{fields: "Medical", percentage: 0}
	];

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response){
			// get data
			if(response.length > 0){
				$scope.profile.eid = response[0].emp_id;
				$scope.profile.name = response[0].name;
				$scope.profile.post = response[0].designation;
				$scope.profile.mobile = response[0].mobile;
				$scope.profile.email = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image = siteurl + response[0].path;

				$scope.profile.active = true;

				// get basic salary
				var transmit = {
					table: "salary_structure",
					cond: {eid: $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					if(response.length > 0){
						$scope.amount = parseInt(response[0].basic);
					} else {
						alert("This employee's basic info not found!");
					}
				});

				// check incentive active or not
				var transmit = {
					table: "salary_structure",
					cond: {"eid": $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					console.log(response);
					if(response[0].incentive === "yes"){
						var transmit = {
							table: "incentive_structure",
							cond: {eid: $scope.eid}
						};

						$http({
							method: "POST",
							url: url + "read",
							data: transmit
						}).success(function(response) {
							console.log(response);

							angular.forEach(response, function(row, index){
								response[index].percentage = parseFloat(response[index].percentage);
							});

							$scope.incentives = response;
						});
					}
				});

			} else {
				// console.log("Employee not found!");

				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;

				$scope.amount = 0.00;
			}

		});
	}

	$scope.totalFn = function(i) {
		var total = 0.00;
		total = $scope.amount * ($scope.incentives[i].percentage / 100);
		total = total.toFixed(2);
		return total;
	}
}]);















// Bonus Controller
app.controller("BonusCtrl", ["$scope", "$http", function($scope, $http){
	$scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response){

			// get data
			if(response.length > 0){
				$scope.profile.eid = response[0].emp_id;
				$scope.profile.name = response[0].name;
				$scope.profile.post = response[0].designation;
				$scope.profile.mobile = response[0].mobile;
				$scope.profile.email = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image = siteurl + response[0].path;

				$scope.profile.active = true;
				console.log(response);

				// get bonus info
				var transmit = {
					table: "salary_structure",
					cond: {eid: $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					if(response.length > 0) {
						if(response[0].bonus === "yes") {
							// get bonus records
							var transmit = {
								table: "bonus_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0){
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
									});

									$scope.bonuses = response;
								} else {
									$scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
								}
							});
						}
					}
				});
			} else {
				console.log("Employee not found!");

				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
			}

		});
	}

	$scope.createRowFn = function() {
		var obj = {fields: "", percentage: 0, remarks: ""};
		$scope.bonuses.push(obj);
	}

	$scope.deleteRowFn = function(index) {
		$scope.bonuses.splice(index, 1);
	}

}]);












// Deduction Controller
app.controller("DeductionCtrl", ["$scope", "$http", function($scope, $http){

	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false
	};

	$scope.deductions = [
		{fields: "Advanced Pay", amount: 0},
		{fields: "Professional Tax ", amount: 0},
		{fields: "Loan", amount: 0},
		{fields: "Provisional Fund", amount: 0}
	];

	$scope.getProfileFn = function() {
		var where = {
			table: "employee",
			cond: {"emp_id": $scope.eid}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response) {
			// get data
			if(response.length > 0){
				$scope.profile.eid = response[0].emp_id;
				$scope.profile.name = response[0].name;
				$scope.profile.post = response[0].designation;
				$scope.profile.mobile = response[0].mobile;
				$scope.profile.email = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image = siteurl + response[0].path;
				$scope.profile.active = true;

				// check deduction active or not
				var transmit = {
					table: "salary_structure",
					cond: {"eid": $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					console.log(response);
					if(response[0].deduction === "yes"){
						var transmit = {
							table: "deduction_structure",
							cond: {eid: $scope.eid}
						};

						$http({
							method: "POST",
							url: url + "read",
							data: transmit
						}).success(function(response) {
							console.log(response);

							angular.forEach(response, function(row, index){
								response[index].amount = parseFloat(response[index].amount);
							});

							$scope.deductions = response;
						});
					}
				});

			} else {
				// console.log("Employee not found!");
				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
			}

		});
	}

}]);










app.controller("PaymentCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.basic_salary = 0.00;
	$scope.profile = {
		image: siteurl + "private/images/default.png",
		active: false,
		incentive: false,
		deduction: false,
		bonus: false
	};

	$scope.insentives = [];
	$scope.deductions = [];
	$scope.bonuses = [];

	$scope.amount = {
		insentives: {extra: 0.00},
		deductions: {extra: 0.00},
		bonuses: {extra: 0.00}
	};

	$scope.getEmployeeInfoFn = function() {
		var where = {
			table: "employee",
			cond: {emp_id: $scope.eid}
		};

		$http({
			method: "POST",
			url: url + "read",
			data: where
		}).success(function(response) {
			if(response.length > 0){
				$scope.profile.eid = response[0].emp_id;
				$scope.profile.name = response[0].name;
				$scope.profile.post = response[0].designation;
				$scope.profile.mobile = response[0].mobile;
				$scope.profile.email = response[0].email;
				$scope.profile.joining = response[0].joining_date;
				$scope.profile.image = siteurl + response[0].path;

				$scope.profile.active = true;

				// get basic salary
				var transmit = {
					table: "salary_structure",
					cond: {eid: $scope.eid}
				};

				$http({
					method: "POST",
					url: url + "read",
					data: transmit
				}).success(function(response) {
					if(response.length > 0) {
						$scope.basic_salary = parseInt(response[0].basic);

						// incentives
						if(response[0].incentive === "yes"){
							// active incentives
							$scope.profile.incentive = true;

							// get incentives
							var transmit = {
								table: "incentive_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
										response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
										$scope.amount.insentives[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
									});

									$scope.insentives = response;
								} else {
									$scope.insentives = [];
									$scope.amount.insentives = {};
									$scope.amount.insentives.extra = 0.00;
								}

								// console.log(response);
							});
						}

						// deduction
						if(response[0].deduction === "yes"){
							// active deduction
							$scope.profile.deduction = true;

							// get deduction
							var transmit = {
								table: "deduction_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].amount = parseFloat(row.amount);
										$scope.amount.deductions[response[index].fields] = parseFloat(row.amount);
									});

									$scope.deductions = response;
								} else {
									$scope.deductions = [];
									$scope.amount.deductions = {};
									$scope.amount.deductions.extra = 0.00;
								}

								// console.log(response);
							});
						}

						// deduction
						if(response[0].bonus === "yes"){
							// active deduction
							$scope.profile.bonus = true;

							// get deduction
							var transmit = {
								table: "bonus_structure",
								cond: {eid: $scope.eid}
							};

							$http({
								method: "POST",
								url: url + "read",
								data: transmit
							}).success(function(response) {
								if(response.length > 0) {
									angular.forEach(response, function(row, index) {
										response[index].percentage = parseFloat(row.percentage);
										response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
										$scope.amount.bonuses[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
									});

									$scope.bonuses = response;
								} else {
									$scope.bonuses = [];
									$scope.amount.bonuses = {};
									$scope.amount.bonuses.extra = 0.00;
								}

								// console.log(response);
							});
						}
					} else {
						alert("This employee's basic info not found!");
						$scope.basic_salary = 0.00;
					}
				});
			} else {
				$scope.profile = {};

				$scope.profile.image = siteurl + "private/images/default.png";
				$scope.profile.active = false;
				$scope.profile.incentive = false;
				$scope.profile.deduction = false;
			}

			// console.log(response);
		});
	}

	$scope.totalFn = function() {
		var total = 0.00;
		var insentives = 0.00;
		var deductions = 0.00;
		var bonuses = 0.00;

		angular.forEach($scope.amount.insentives, function(value){
			insentives += value;
		});

		angular.forEach($scope.amount.deductions, function(value){
			deductions += value;
		});

		angular.forEach($scope.amount.bonuses, function(value){
			bonuses += value;
		});

		total = ($scope.basic_salary + insentives + bonuses) - deductions;

		return total;
	}

}]);









// Salary Report
app.controller("SalaryReportCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.resultset = [];
	$scope.active = false;
	$scope.perPage = 10;

	$scope.getSalaryRecordFn = function() {
		var where = {
			"Year(date)": $scope.where.year,
			"Month(date)": $scope.where.month
		};

		$http({
			method: "POST",
			url: siteurl + "salary/salary/read_salary",
			data: where
		}).success(function(response) {
			if (response.length > 0) {
				$scope.active = true;

				angular.forEach(response, function(row, index) {
					row.sl = index + 1;
				});

				$scope.resultset = response;
			} else {
				$scope.active = false;
				$scope.resultset = [];
			}

			console.log(response);
		});
	}
}]);










// All Payment
app.controller("AllPaymentCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.resultset = [];
	$scope.active = false;
	$scope.perPage = 10;

	$scope.getSalaryRecordFn = function() {
		var where = {
			"Year(date)": $scope.where.year,
			"Month(date)": $scope.where.month
		};

		console.log(where);

		$http({
			method: "POST",
			url: siteurl + "salary/payment/read_salary",
			data: where
		}).success(function(response) {
			if (response.length > 0) {
				$scope.active = true;

				angular.forEach(response, function(row, index) {
					row.sl = index + 1;
				});

				$scope.resultset = response;
			} else {
				$scope.active = false;
				$scope.resultset = [];
			}

			console.log(response);
		});
	}
}]);









// Show All Supplier Transaction
app.controller('showAllSupplierTransactionCtrl',function($scope,$http,$log) {
	$scope.allTransactions=[];
	$scope.perPage="30";
	$scope.reverse=true;

	var where ={
		from:'vendor',
		join:'supplier_transaction',
		cond:'supplier_transaction.supplier_name=vendor.id'
	};

	$http({
		method:"POST",
		url:url+"readJoinData",
		data:where
	}).success(function(response){
		if(response.length > 0){
			angular.forEach(response, function(value, key) {
				value['sl'] = key+1;
			    $scope.allTransactions.push(value);
			});
		} else {
			$scope.allTransactions=[];
		}

	  	$log.log($scope.allTransactions);
	});

});


// cost entry ctrl
app.controller('CostEntryCtrl',function($scope,$http,$log) {

	$scope.setAllPurpose = function(){
		var condition = {
			table: "sitemeta",
			cond: {meta_key: "cost_purpose", meta_type: $scope.type}
		};

		$http({
			method	: "POST",
			url		: url + "read",
			data	: condition
		}).success(function(response){
			if(response.length > 0){
				$scope.purpose = response;
			}else{
				$scope.purpose = "";
			}
		});
	}
});


// getDueCtrl
app.controller("getDueCtrl", function($http, $scope){

	$scope.getUpazillaFn = function(){
	 $scope.upazilla = [];
		 var where = { "key" : $scope.zilla};

		 $http({
		  method : "POST",
		  url  : siteurl + "sale/due/return_upazila",
		  data : where
		 }).success(function(response){
		  if(response.length > 0){
		   $scope.upazilla = response;
		  }
		  console.log($scope.upazilla);
		 });
	}

});







// Supplier transaction controller
app.controller("supplierTransactionCtrl", function($http, $scope, $log){

	//get suplier information
	$scope.getsupplierInfo = function(){
		var condition = {
			from:'vendor',
			join:'purchase',
			group_by:'voucher_no',
			cond:'vendor.id = purchase.vendor_id',
			where:{'vendor.id':$scope.supplier_name}
		};

		$http({
			method:"POST",
			url:url+"readJoinGroupByData",
			data:condition
		}).success(function(response) {
			if(response.length > 0){
				$scope.company_name = response[0].vendor_name;
				$scope.voucher_number = response[0].voucher_no;

				var totalDue = 0;
				angular.forEach(response, function(el, i) {
					totalDue += parseFloat(el.due);
				});

				$scope.totalBalance = Math.abs(totalDue);
				$scope.total_original_Balance = totalDue;

				if(totalDue >= 0) {
					$scope.balanceSign = "-";
				} else {
					$scope.balanceSign = "+";
				}
			}

			console.log(response);
		});
	};

	//claculate total due
	$scope.claculateDue=function(){
		var total =0;
		total=parseFloat($scope.totalBalance)-parseFloat($scope.payment);
		$scope.netBalance = Math.abs(total);
		$scope.net_original_Balance = total;

		if(total>=0){
			$scope.netbalanceSign="-";
		}else{
		   $scope.netbalanceSign="+";
		}
	};
});

// collection sheet
app.controller('collectionSheet', function($scope, $http){
	$scope.active=false;
	$scope.getUpazillaFn = function(){
		$scope.upazilla = [];
			var where = { "key" : $scope.zilla};

			$http({
				 method : "POST",
				 url  : siteurl + "sheet/sheet/return_upazila",
				 data : where
			}).success(function(response){
			 if(response.length > 0){
				$scope.upazilla = response;
				$scope.active=true;

			 }else{
				$scope.active=false;
			 }
			 console.log($scope.upazilla);
			 console.log($scope.active);
			});
	}
});













// Client transaction controller start here
app.controller('ClientTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.sign = 'Receivable';
	$scope.csign = 'Receivable';

	$scope.payment = 0.00;
	$scope.displayBalance = 0.00;

	// get client information
	$scope.getclientInfo = function(){
		var condition = {
			table: 'partybalance',
			cond: {code: $scope.code}
		};

		$http({
			method: "POST",
			url: url + "read",
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				var balance = parseFloat(response[0].balance);

				$scope.displayBalance = parseFloat(response[0].balance);
				$scope.balance = Math.abs(balance);

				if(balance < 0) {
					$scope.sign = 'Payable';
				} else {
					$scope.sign = 'Receivable';
				}
			}

			console.log(response);
		});
	};

	$scope.getTotalFn = function() {
		var total = $scope.displayBalance - $scope.payment;

		$scope.csign = (total >= 0) ? "Receivable" : "Payable";

		return Math.abs(total);
	}

}]);













// client edit transaction controller start here
app.controller('ClientTransactionEditCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.payment = 0.00;

	$scope.$watchGroup(['id', 'transactionBy'], function(input) {
		if(input[1] == 'cheque') {

			$http({
				method: 'POST',
				url: url + "read",
				data: {
					table: 'partytransactionmeta',
					cond: {transaction_id: input[0]}
				}
			}).success(function(response) {
				if(response.length > 0) {
					angular.forEach(response, function(row) {
						if(row.meta_key == 'bankname') {$scope.bankname = row.meta_value;}
						if(row.meta_key == 'branchname') {$scope.branchname = row.meta_value;}
						if(row.meta_key == 'account_no') {$scope.accountno = row.meta_value;}
						if(row.meta_key == 'chequeno') {$scope.chequeno = row.meta_value;}
						if(row.meta_key == 'passdate') {$scope.passdate = row.meta_value;}
					});
				}

				console.log(response);
			});
		}
	});

	$scope.getTotalFn = function() {
		var total = $scope.balance - ($scope.payment - $scope.prevPayment);
		$scope.csign = (total >= 0) ? "Receivable" : "Payable";

		return Math.abs(total);
	}

}]);














// ClientCommissionCtrl
app.controller("ClientCommissionCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.resultset = [];
	$scope.total = 0.00;

	// get all upazilla
	$scope.getUpazillaFn = function(){
		var where = {
			table	: "parties",
			group_by: "area",
			cond	: {zone : $scope.zilla}
		};

		$http({
			method	: "POST",
			url		: url + "readGroupByData",
			data	: where
		}).success(function(response){
			$scope.allUpazilla = response;
			//console.log(response);
		});
	}

	var condition = {
		table: 'parties',
		cond: {
			type: 'client'
		}
	};

	$http({
		method: "POST",
		url: url + 'read',
		data: condition
	}).success(function(response) {
		$scope.allClients = response;
		// console.log(response);

	});

	// get all upazilla wise cliend
	$scope.getAllClientFn = function(){
		var condition = {
			table: 'parties',
			cond: {
				type: 'client',
				zone: $scope.zilla,
				area: $scope.upazilla
			}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: condition
		}).success(function(response) {
			$scope.allClients = response;
			// console.log(response);

		});
	}



	$scope.searchCommissionFn = function() {
		var where = {};

		angular.forEach($scope.query, function(value, key) {
			if(value != "") {
				where[key] = value;
			}
		});
		console.log(where);


		angular.forEach($scope.dateset, function(value, key) {
			if(value != "") {
				if(key == "from") { where["transaction_at >="] = value; }
				if(key == "to") { where["transaction_at <="] = value; }
			}
		});

		$http({
			method: "POST",
			url: siteurl + "commission/client_commission/search",
			data: where
		}).success(function(response) {
			$scope.resultset = [];

			if(response.length > 0){
				$scope.resultset = response;
			}

			console.log($scope.resultset);
		});
	}

	$scope.sumFn = function() {
		var total = 0.00;

		angular.forEach($scope.resultset, function(row, key){
			if(row.action) {
				total += parseFloat(row.total);
			}
		});

		$scope.total = total;
	}


}]);


















// company transaction controller start here
app.controller('CompanyTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.balance = 0.00;
	$scope.sign = "Receivable";

	$scope.payment = 0.00;
	$scope.csign = "Receivable";

	$scope.getCompanyInfo = function() {
		var condition = {
			table: 'partybalance',
			cond: {'code' : $scope.code}
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				$scope.balance = Math.abs(parseFloat(response[0].balance));

				if(parseFloat(response[0].balance) < 0) {
					$scope.sign = "Payable";
				} else {
					$scope.sign = "Receivable";
				}
			} else {
				$scope.balance = 0.00;
				$scope.sign = "Receivable";
			}

			console.log(response);
		});
	}

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

		return Math.abs(total);
	}
}]);

















//Edit company Transaction
app.controller('CompanyEditTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.payment = 0.00;

	$scope.$watchGroup(['id', 'transactionBy'], function(input) {
		if(input[1] == 'cheque') {

			$http({
				method: 'POST',
				url: url + "read",
				data: {
					table: 'partytransactionmeta',
					cond: {transaction_id: input[0]}
				}
			}).success(function(response) {
				if(response.length > 0) {
					angular.forEach(response, function(row) {
						if(row.meta_key == 'bankname') {$scope.bankname = row.meta_value;}
						if(row.meta_key == 'branchname') {$scope.branchname = row.meta_value;}
						if(row.meta_key == 'account_no') {$scope.accountno = row.meta_value;}
						if(row.meta_key == 'chequeno') {$scope.chequeno = row.meta_value;}
						if(row.meta_key == 'passdate') {$scope.passdate = row.meta_value;}
					});
				}

				console.log(response);
			});
		}
	});

	$scope.getTotalFn = function() {
		var total = $scope.balance + ($scope.payment - $scope.prevPayment);
		$scope.csign = (total >= 0) ? "Receivable" : "Payable";

		return Math.abs(total);
	}

}]);





















/* company transaction ctrl
app.controller('CompanyTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.balance = $scope.payment = 0;
	$scope.sign = $scope.csign = "Receivable";

	$scope.getCompanyInfo = function() {
		var condition = {
			table: 'partybalance',
			cond: {code: $scope.code}
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				$scope.balance = Math.abs(parseFloat(response[0].balance));

				if(parseFloat(response[0].balance) >= 0) {
					$scope.sign = "Receivable";
				} else {
					$scope.sign = "Payable";
				}
			} else {
				$scope.balance = 0.00;
				$scope.sign = "Receivable";
			}

			console.log(response);
		});
	}



	$scope.active = true;
	$scope.type = "পরিশোধ";
	$scope.status = false;
	$scope.class_meassure = "col-md-5";


	$scope.getUpazillaFn = function(){
	 $scope.allUpazilla = [];
	 var where = { "key" : $scope.zilla};

	 $http({
	  method : "POST",
	  url  : siteurl + "client/transaction/return_upazila",
	  data : where
	 }).success(function(response){
	  if(response.length > 0){
	   $scope.allUpazilla = response;
	  }
	  console.log($scope.allUpazilla);
	 });
	}



	$scope.getClientFn = function(type) {
		$scope.allClients = [];
		var condition = {
			table: 'parties',
			cond: {
				type: 'client',
				ctype: type
			}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length>0){
				$scope.allClients = [];
				angular.forEach(response, function(items, key){
					items['client_address'] = items.name + "[" + items.address + "]";
					$scope.allClients.push(items);
				});
			}else{
				$scope.allClients = [];
			}
			console.log($scope.allClients);
		});
	}


	//get brand info
	$scope.getBrnadFn = function(){
		$scope.allBrands = [];
		$scope.clientName = "";
		var where = {
			table : "partybalance",
			cond : {code : $scope.clientCode}
		};

   $http({
		 method : "POST",
		 url : url + "read",
		 data : where
	 }).success(function(response){
		  if(response.length > 0){

				$scope.allBrands = response;
			}else{
				$scope.allBrands = [];
			}
	 });


	 var obj = {
	  table : "parties",
	  cond : {code : $scope.clientCode}
	 };

	 $http({
	   method : "POST",
	   url    : url + "read",
	   data   : obj
	 }).success(function(info){
	    console.log(info);
	    if(info.length == 1){
	       $scope.clientName = info[0].name;

	    }
	 });


	}



	$scope.getClientInfo = function(brand = "") {
		var condition = {
			table: 'partybalance',
			cond: {'code' : $scope.clientCode} // cond: {code: $scope.client.code}
		};

		//console.log(condition);

		// create condition
		if(brand != "") {condition.cond.brand = brand;}

		console.log(condition);

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				$scope.balance = Math.abs(parseFloat(response[0].balance));

				if(parseFloat(response[0].balance) > 0) {
					$scope.sign = "Payable";
				} else if(parseFloat(response[0].balance) < 0) {
					$scope.sign = "Receivable";
				} else {
					$scope.sign = "Receivable";
				}
			} else {
				$scope.balance = 0.00;
				$scope.sign = "Receivable";
			}

		  if($scope.sign == "Receivable"){
		  		$scope.active = true;
		  		$scope.class_meassure = "col-md-5";
			}else{
				$scope.active = false;
				$scope.class_meassure = "col-md-3";
			}

			console.log(response);
		});
	}





	$scope.getRetailFn = function() {
		$scope.getClientInfo("");
	}

	$scope.getTotalFn = function() {
		var total = 0.00;

		if($scope.sign == 'Receivable'){
			total = $scope.balance - $scope.payment;

			if(total >= 0) {
				$scope.csign = "Receivable";
			} else {
				$scope.csign = "Payable";
			}
		} else {
			if($scope.type == "পরিশোধ"){
				total = $scope.balance - $scope.payment;
				if(total > 0) {
					$scope.csign = "Payable";
				} else {
					$scope.csign = "Receivable";
				}
			}else{
				total = $scope.balance + $scope.payment;
			    $scope.csign = "Payable";
			}
		}

		return Math.abs(total);
	}

}]);
*/










//vendor transaction controller start here
app.controller('VendorTransactionCtrl', ['$scope', '$http', function($scope, $http){
	$scope.balance = $scope.payment = 0;
	$scope.sign = $scope.csign = "Receivable";

	$scope.getVendortInfo = function() {
		var condition = {
			table: 'partybalance',
			cond: {code: $scope.clientCode}
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				$scope.balance = Math.abs(parseFloat(response[0].balance));

				if(parseFloat(response[0].balance) >= 0) {
					$scope.sign = "Receivable";
				} else {
					$scope.sign = "Payable";
				}
			} else {
				$scope.balance = 0.00;
				$scope.sign = "Receivable";
			}

			console.log(response);
		});
	}

	$scope.getTotalFn = function() {
		var total = 0.00;

		if($scope.sign == 'Receivable'){
			total = $scope.balance + $scope.payment;
			$scope.csign = "Receivable";
		} else {
			total = $scope.balance - $scope.payment;

			if(total <= 0) {
				$scope.csign = "Receivable";
			} else {
				$scope.csign = "Payable";
			}
		}

		return Math.abs(total);
	}

}]);









// add client ctrl
app.controller("AddClientCtrl", ['$scope', '$http', function($scope, $http) {
	$scope.items = [{
		brand: "bsrm",
		balance: 0.00,
		limit: 0.00,
		status: "receivable"
	}];

	$scope.addNewFn = function() {
		var newobj = {
			brand: "",
			balance: 0.00,
			limit: 0.00,
			status: "receivable"
		};

		$scope.items.push(newobj);
	}

	// zilla wise upazilla
	$scope.getUpazillaFn = function(){
		$scope.upazilla = [];
		var where = { "key" : $scope.zone};

	    $http({
			method	: "POST",
			url		: siteurl + "client/client/return_upazila",
			data	: where
		}).success(function(response){
			if(response.length > 0){
				$scope.upazilla = response;
			}
			console.log($scope.upazilla);
		});
	}


	$scope.deleteFn = function(index) {
		$scope.items.splice(index, 1);
	}

}]);




// Edit client ctrl
app.controller("EditClientCtrl", ['$scope', '$http', function($scope, $http) {
	$scope.items = [{
		brand: "",
		balance: 0.00,
		limit: 0.00,
		status: "receivable"
	}];


	$scope.$watch("partyCode", function(){
		var where = {
			table : "partybalance",
			cond : {code : $scope.partyCode}
		};

		$http({
			method : "POST",
			url : url + "read",
			data : where
 		}).success(function(response){
			if(response.length > 0){
				 $scope.items = [];
				angular.forEach(response, function(values){
					values.status = (parseFloat(values.initial_balance) <= 0 ) ? "receivable" :"payable";
					values.amount = Math.abs(parseFloat(values.initial_balance));
					values.credit_limit = parseFloat(values.credit_limit);
					$scope.items.push(values);
				});
			}
			console.log($scope.items);
		});

	});



	// zilla wise upazilla
	$scope.$watch('zone', function() {
		var where = { "key" : $scope.zone};

		$http({
			method	: "POST",
			url		: siteurl + "client/client/return_upazila",
			data	: where
		}).success(function(response){
			if(response.length > 0){
				$scope.upazilla = response;
			}
		});
	});


	$scope.addNewFn = function() {
		var newobj = {
			brand: "",
			balance: 0.00,
			limit: 0.00,
			status: "receivable"
		};

		$scope.items.push(newobj);
	}

	$scope.deleteFn = function(index) {
		$scope.items.splice(index, 1);
	}

}]);





// Client Upgrade Ctrl
app.controller('ClientUpgradeCtrl', ['$scope', '$http', function($scope, $http) {

	$scope.securities = [{bank: "", branch: "", cheque: "", amount: 0.00}];

	$scope.$watch('code', function(value) {
		var where = {
			table: "partymeta",
			cond: {
				party_code: value,
				meta_key: 'security'
			}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response) {
			if(response.length > 0) {
				$scope.securities = angular.fromJson(response[0].meta_value);
			}

			console.log(response);
		});
	});

	$scope.newRowFn = function(){
		var object = {bank: "", branch: "", cheque: ""};
		$scope.securities.push(object);
	}

	$scope.deleteRowFn = function(index){
		$scope.securities.splice(index, 1);
	}

}]);


// All Bank Transaction Ctrl
app.controller("AllBankTransactionCtrl", ["$scope", "$http", function($scope, $http) {
	$allAccount = [];

	$scope.getAccountFn = function() {
		var where = {
			table: 'bank_account',
			cond: {bank_name: $scope.bank}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response) {
			if(response.length > 0) {
				$scope.allAccount = response;
			}

			console.log(response);
		});
	}

}]);


// Add Loan Transaction Ctrl
app.controller("loanTransactionCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.TotalPaid = 0;
	$scope.TotalAmount = 0;
	$scope.getTotal = function(loanID) {
		var where = {
			table: 'loan_transaction',
			column: 'amount',
			cond: {loan_id: loanID}
		};

		$http({
			method: "POST",
			url: url + 'readSum',
			data: where
		}).success(function(response) {
			if(response[0].amount > 0) {
				$scope.TotalPaid=parseFloat(response[0].amount);
			}else{
				$scope.TotalPaid=0;
			}
		});

		where = {
			table: 'loan',
			cond: {id: loanID}
		};

		$http({
			method: "POST",
			url: url + 'read',
			data: where
		}).success(function(response) {
			if(response.length > 0) {
				$scope.TotalAmount=parseFloat(response[0].amount);
				//console.log($scope.TotalAmount);
			}else{
				$scope.TotalAmount=0;
			}
		});
	}
		$scope.Due = $scope.TotalAmount-$scope.TotalPaid;

}]);











//net balance sign filter
app.filter("net_balance_sign",function(){
	return function(input){
		var sign;

		if(input >= 0) {
			sign="-";
		} else {
			sign="+";
		}

	  	return sign;
	}
});

app.filter("netBalanceFilter",function() {
	return function(value){
		return Math.abs(value);
	}
});


//show allTargetCommissionCtrl

app.controller('allTargetCommissionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.dataset = [];

	var loadData = function(){
		var condition = {
			table: 'commissions'
		};

		$http({
			method: 'POST',
			url: url + 'read',
			data: condition
		}).success(function(response) {
			if(response.length > 0) {
				angular.forEach(response, function(row, i) {
					row['sl'] = i+1;
					$scope.dataset.push(row);
				});
			} else {
				$scope.dataset = [];
			}

			 console.log($scope.dataset);
		});
	}

	loadData();
}]);

//cost controller start here
app.controller("costCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.fields = [];

	var obj = {
		table : "cost_field"
	};

	$http({
		method : "POST",
		url : url + "read",
		data : obj
	}).success(function(response){
		if(response.length>0){
			angular.forEach(response,function(values,index){
				values['sl'] = index + 1;
				$scope.fields.push(values);
			});
		}else{
			$scope.fields = [];
		}
	});
}]);


//ChalanCtrL  start here
app.controller("chalanCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.chalan = [];
	// Table
	var obj = {
		table: "chalan",
		cond: {trash: 0},
		group_by: "chalan_no"
	};

	$http({
		method : "POST",
		url : url + "readGroupByData",
		data : obj
	}).success(function(response){
		if(response.length>0){

			angular.forEach(response, function(values, index){
				// get client info
				var where = {
					table: 'parties',
					cond: {code: values.party_code}
				};

				$http({
					method: 'POST',
					url: url + 'read',
					data: where
				}).success(function(party) {
					values['sl'] = index + 1;
					values['party'] = party[0].name;

					$scope.chalan.push(values);
				});

				console.log($scope.chalan);
			});
		}else{
			$scope.chalan = [];
		}
	});

}]);



app.controller("chalanRowCtrl",["$scope","$http",function($scope,$http){
	$scope.addRowFn = function(){
         if(typeof $scope.raw_material != "undefined" && typeof $scope.quantity != "undefined"){

             var where = {
                 table : "materials",
                 cond  : {
                     code : $scope.raw_material
                 }
             };

             $http({
                 method : "POST",
                 url    : url + "read",
                 data   : where
             }).success(function(response){
                  if(response.length == 1){
                      var item = {
                          raw_mat : response[0].name,
                          code     : $scope.raw_material,
                          quantity : $scope.quantity
                     };
                     $scope.allRecords.push(item);
                 }else{
                     $scope.allRecords = [];
                 }
             });
         }else{
             alert("Please Fill up all the Value!");
         }
     };
}]);



//Chalan Ctrl

// add prescription ctrl
/*app.controller("addChalanCtrl",["$scope","$http",function($scope,$http){
	 $scope.allChalan = [{
	 	product  : "",
	 	quqntity : ""
	 }];

	 var addNewItem = function(key) {
	 	var item = (key == 'chalanItem') ? {product: "", quqntity: ""} : {product: "", quqntity: ""};

	 	if(key == 'chalanItem') {
	 		$scope.allChalan.push(item);
	 	}
	 }

	 $scope.addRowChalanByClickFn = function(key){
	 	addNewItem(key);
	 };

	 $scope.removeRowChalanFn = function(i){
	 	$scope.allChalan.splice(i,1);
	 };

}]);*/









// production Contrller start here
app.controller("productionCtrl", ["$scope", "$http", function($scope, $http) {
	$scope.allRecords = [];

	// add new row fn
	 $scope.addRowFn = function(){
		 if(typeof $scope.raw_material != "undefined" && typeof $scope.quantity != "undefined"){
					 var where = {
						 table : "stock",
						 cond  : {
							 code   : $scope.raw_material,
							 unit   : "Kg",
							 type   : "raw",
							 godown : 1
						 }
					 };
					 
					// console.log(where);

					 $http({
						 method : "POST",
						 url    : url + "read",
						 data   : where
					 }).success(function(response){
						  if(response.length == 1){
							  var item = {
								  raw_mat  : response[0].name,
				 				  code     : $scope.raw_material,
								  stock    : response[0].quantity,
				 				  quantity : ($scope.quantity >= parseFloat(response[0].quantity)) ? parseFloat(response[0].quantity) : $scope.quantity
				 			 };

							 $scope.allRecords.push(item);
							 $scope.calWeight();
						 }  else{
							 $scope.allRecords = [];
						 }
						// console.log($scope.allRecords);
					 });
	         } else{
			 alert("Please Fill up all the Value!");
		 }
	 };

	 //remove row start where
	 $scope.removeRowFn = function(i){
		 $scope.allRecords.splice(i,1);
	 };

	 //get product info fn
	 $scope.getProductInfoFn = function(){
		 var where = {
			 table : "materials",
			  cond : {
				  code : $scope.finish_product_code
			  }
		 };

		// console.log(where);

		 $http({
			 method : "POST",
			 url    : url + "read",
			 data   : where
		 }).success(function(response){
			 if(response.length == 1){
				 $scope.product_name = response[0].name;
			 }else{
				 $scope.product_name = "";
			 }
		 });
	 };

	$scope.totalWeight = 0;

	$scope.calWeight = function() {
		var total = 0;

		angular.forEach($scope.allRecords, function(item, i) {
			total += item.quantity;
		});

		$scope.totalWeight = total;
		// return total;
	}


}]);





// production edit Contrller start here
app.controller("editProductionCtrl",["$scope","$http",function($scope,$http){

	 //get product info fn
	 $scope.getProductInfoFn = function(){
		 var where = {
			 table : "materials",
			  cond : {
				  code : $scope.finish_product_code
			  }
		 };

		 console.log(where);

		 $http({
			 method : "POST",
			 url    : url + "read",
			 data   : where
		 }).success(function(response){
			 if(response.length == 1){
				 $scope.product_name = response[0].name;
			 }else{
				 $scope.product_name = "";
			 }
		 });
	 };
}]);


// chalan Contrller start here
app.controller("chalanAddCtrl", ["$scope","$http",function($scope,$http){
	$scope.items = [];
	$scope.products = []

	// add new row fn
	$scope.addRowFn = function(){
		if(typeof $scope.productGiven !== "undefined"){
			if($scope.products.indexOf($scope.productGiven) < 0) {
				var where = {
					table: "materials",
					cond: {
						code: $scope.productGiven,
						type: 'finish_product',
						trash: 0
					}
				};

				$http({
					method : "POST",
					url    : url + "read",
					data   : where
				}).success(function(response) {
					if(response.length > 0) {
						var item = {
							product : response[0].name,
							code: response[0].code,
			 				quantity: $scope.quantityGiven
			 			};

						$scope.items.push(item);
						$scope.products.push(response[0].code);

						console.log(response);
					}
				});
			}
	   }
	};


	//calculate Bags no
	$scope.calculateBags = function(i,size){
		var bag_no = 0.00;
        bag_no = parseFloat($scope.items[i].quantity) / parseFloat(size);
		$scope.items[i].bags = bag_no.toFixed(2);
		return $scope.items[i].bags;
	};


	//remove row start where
	$scope.deleteItemFn = function(i){
		$scope.items.splice(i, 1);
		$scope.products.splice(i, 1);
	};
}]);

// production Contrller start here
app.controller("chalanEditCtrl", ["$scope", "$http", function($scope, $http) {

	$scope.$watch("chalanNo", function(value) {
		$scope.items = [];

		var where = {
			from: "chalan",
			join: "materials",
			cond: "chalan.code=materials.code",
			where: {'chalan.chalan_no': value}
		};

		$http({
			method : "POST",
			url    : url + "readJoinData",
			data   : where
		}).success(function(response) {
			if(response.length > 0) {
				angular.forEach(response, function(row, index) {
					var item = {
						bags: parseFloat(row.bags),
						chalan_no: row.chalan_no,
						product: row.name,
						code: row.code,
						date: row.date,
						id: parseInt(row.id),
						party_code: row.party_code,
						quantity: parseFloat(row.quantity),
						size: row.size
					};

					$scope.items.push(item);
				});

				console.log(response);
				// console.log($scope.items);
			}
		});
	});

	$scope.calculateBags = function(index) {
		$scope.items[index].bags = $scope.items[index].quantity / parseInt($scope.items[index].size);
	}

}]);







