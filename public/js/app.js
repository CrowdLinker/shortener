
angular.module('shortenerApp', [
    'shortenerApp.controllers',
    'shortenerApp.services',
    'angles',
    'ui.bootstrap'
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
