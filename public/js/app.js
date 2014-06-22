
angular.module('shortenerApp', [
    'shortenerApp.controllers',
    'shortenerApp.services',
    'angles'
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
