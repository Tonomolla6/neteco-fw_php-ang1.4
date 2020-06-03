var app = angular.module('angularTable', ['angularUtils.directives.dirPagination']);
app.controller('listdata',function($scope, $http){
	$scope.users = []; 
	
	$http.get("mockJson/mock.json").success(function(response){ 
		$scope.users = response;
	});
	
	$scope.sort = function(keyname){
		$scope.sortKey = keyname;   //set the sortKey to the param passed
		$scope.reverse = !$scope.reverse; //if true make it false and vice versa
	}
});