angular.module('shortenerApp.controllers',[])
    .controller('RegisterController',
    function($scope,User){
        $scope.error = false;
        $scope.success = false;
        $scope.createAccount = function()
        {
            User.create($scope.account)
                .success(function()
                {
                    $scope.success = true;
                })
                .error(function(data)
                {
                    if(data['error']['status_code'] == 400)
                    {
                        console.log('error');
                        $scope.error = true;
                        $scope.success = false;
                        $scope.errormessage = data['error']['message'];
                    }
                });
        }
    })
    .controller('AuthController',
    function($scope,User,$window)
    {
        $scope.error = false;
        $scope.authorize = function()
        {
            User.authorize($scope.account)
                .success(function()
                {
                    $window.location(shortener.url + '/dashboard');
                })
                .error(function(data)
                {
                    if(data['error']['status_code'] == 400)
                    {
                        console.log('error');
                        $scope.error = true;
                        $scope.errormessage = data['error']['message'];
                    }
                });
        }
    })
