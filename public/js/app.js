
angular.module('shortenerApp', [
    'shortenerApp.controllers',
    'shortenerApp.services'
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
