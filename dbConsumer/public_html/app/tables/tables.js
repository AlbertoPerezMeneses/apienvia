'use strict';

angular.module('myApp.tables', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/tables/:id', {
    templateUrl: 'tables/tables.html',
    controller: 'TablesCtrl'
  });
}])

.controller('TablesCtrl', [function() {

}]);