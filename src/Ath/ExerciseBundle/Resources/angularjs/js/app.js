'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', [
  'ngRoute',
  'myApp.filters',
  'myApp.services',
  'myApp.directives',
  'myApp.controllers'
]).
config(['$routeProvider', '$interpolateProvider', function($routeProvider, $interpolateProvider) {
  $routeProvider.when('/init', {templateUrl: Routing.generate('ath_exercise_init'), controller: 'InitCtrl'});
  $routeProvider.when('/view2', {template: '<p>test 2 </p>', controller: 'TestCtrl'});
  $routeProvider.otherwise({redirectTo: '/init'});

  $interpolateProvider.startSymbol('{[{');
  $interpolateProvider.endSymbol('}]}');
}]);

