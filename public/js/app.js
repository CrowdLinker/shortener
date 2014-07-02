var app = angular.module('shortenerApp', [
    'shortenerApp.controllers',
    'shortenerApp.services',
    'angles',
    'ui.bootstrap'
]);
app.constant("CSRF_TOKEN", shortener.csrf);
app.config(function($interpolateProvider)
{
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
app.run(['$http', 'CSRF_TOKEN', function($http, CSRF_TOKEN) {
    $http.defaults.headers.common['csrf_token'] = CSRF_TOKEN;
}]);