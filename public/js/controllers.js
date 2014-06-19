angular.module('shortenerApp.controllers',[])
    .controller('RegisterController',
    function($scope,User){
        $scope.error = false;
        $scope.success = false;
        $scope.createAccount = function()
        {
            User.create($scope.account)
                .success(function(data)
                {
                    $scope.success = true;
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