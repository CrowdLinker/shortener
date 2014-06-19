angular.module('shortenerApp.services',[])
    .factory('User',function($http){
        return {
            create: function(data) {
                return $http({
                    method : 'POST',
                    url : shortener.url + '/api/user/create',
                    data: data
                });
            }
        };
    })