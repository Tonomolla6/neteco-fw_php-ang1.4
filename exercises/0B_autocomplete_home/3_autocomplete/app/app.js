var app = angular.module('myApp', ['ui.bootstrap']);

app.controller('autocompleteController', function($scope, $http) {
  
  getCountries(); 
  
  function getCountries(){  
    $http.get("ajax/getCountries.php").success(function(data){
          $scope.countries = data;
         });
    };
});
