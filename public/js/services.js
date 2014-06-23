angular.module('shortenerApp.services',[])
    .factory('User',function($http){
        return {
            create: function(data) {
                return $http({
                    method : 'POST',
                    url : shortener.url + '/api/user/create',
                    data : data
                });
            },
            authorize: function(data)
            {
                return $http({
                    method : 'POST',
                    url : shortener.url + '/api/user/authorize',
                    data : data
                })
            },
            email: function(data)
            {
                return $http({
                    method : 'PUT',
                    url : shortener.url + '/api/user/email/update',
                    data : data
                })
            },
            check: function()
            {
                return $http.get(shortener.url + '/api/user/password/exists');
            },
            getemail: function()
            {
                return $http.get(shortener.url + '/api/user/email');
            }
        };
    })
    .factory('Link',function($http)
    {
        return {
            create : function(data)
            {
                return $http({
                    method : 'POST',
                    url : shortener.url + '/api/create',
                    data: data
                });
            },
            get : function()
            {
                return $http.get(shortener.url + '/api/links');
            },
            details : function()
            {
                return $http.get(shortener.url + '/api/links/detail/' + shortener.id);
            }
        }
    });