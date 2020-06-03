function SearchCtrl($scope, $http) {
	// The function that will be executed on button click (ng-click="search()")
	$scope.search = function() {
		$http.post('search.php', { "data" : $scope.keywords})
		.success(function(data, status) {
    			$scope.status = status;
    			$scope.data = data;
    			$scope.result = data; // Show result from server in our <pre></pre> element
    		})
		.error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
		});
	};
}
