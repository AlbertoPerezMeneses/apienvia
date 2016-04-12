'use strict';

angular.module('myApp.databases', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/databases', {
    templateUrl: 'databases/databases.html',
    controller: 'databasesCtrl'
  });
}])

.controller('databasesCtrl', [function() {

}]);