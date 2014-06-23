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
                    $scope.error = false;
                    $window.location.replace(shortener.url + '/login');
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
    function($scope,User,$window){
        $scope.error = false;
        $scope.authorize = function()
        {
            User.authorize($scope.account)
                .success(function(data)
                {
                    $window.location.replace(shortener.url + '/dashboard');
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
    .controller('LinkDataController',
    function($scope,Link)
    {
        Link.get()
            .success(function(data)
            {
                $scope.shortlinks = data;
            });

        $scope.submitLink = function()
        {
            Link.create($scope.shortlink)
                .success(function()
                {
                    Link.get()
                        .success(function(data)
                        {
                            $scope.shortlinks = data;
                        });
                });
        };
    })
    .controller('AnalyticsController',
        function($scope,Link)
        {
            $scope.traffic = [];
            Link.details()
                .success(function(data)
                {
                    $scope.pagetitle = data.pagetitle;
                    $scope.domainprovider = data.domain;
                    $scope.traffic = data.referrers;
                    $scope.originallink = data.original_url;
                    $scope.totalclicks = data.totalclicks;
                    var steps = 4;
                    var max = Math.max.apply(Math, data.graph_data.count);
                    $scope.options = {
                        scaleOverride: true,
                        scaleSteps: steps,
                        scaleStepWidth: Math.ceil(max / steps),
                        scaleStartValue: 0
                    };
                    $scope.chart = {
                        labels : data.graph_data.source,
                        datasets : [
                            {
                                fillColor : "rgba(151,187,205,0.5)",
                                strokeColor : "rgba(151,187,205,1)",
                                data : data.graph_data.count
                            }
                        ]
                    };
                });
        })
            .controller('SettingsController',
            function($scope,User)
            {
                $scope.settings =
                {
                    'email' : ''
                };
                $scope.newpassword = {};
                $scope.updatepassword = {};
                $scope.errormessage = '';
                $scope.success = false;
                $scope.newpassword_success = false;
                $scope.newpassword_error = false;
                $scope.newpassword_errormessage = '';
                $scope.changepassword_success = false;
                $scope.changepassword_error = false;
                $scope.changepassword_errormessage = '';
                $scope.error = false;
                $scope.createpassword = '';
                $scope.changepassword = '';
                $scope.updateEmail = function()
                {
                    User.email($scope.settings)
                        .success(function(data){
                            $scope.success = true;
                            $scope.error = false;
                        })
                        .error(function(data){
                            if(data['error']['status_code'] == 400)
                            {
                                $scope.error = true;
                                $scope.success = false;
                                $scope.errormessage = data['error']['message'];
                            }
                        });
                };

                $scope.createNewPassword = function()
                {
                    User.newpassword($scope.newpassword)
                        .success(function(){
                            $scope.newpassword_success = true;
                            $scope.newpassword_error = false;
                            $('#createpassword').modal('hide');
                            $scope.changepassword = true;
                            $scope.createpassword = false;
                        })
                        .error(function(data){
                            if(data['error']['status_code'] == 400)
                            {
                                $scope.newpassword_success = false;
                                $scope.newpassword_error = true;
                                $scope.newpassword_errormessage = data['error']['message'];
                                $scope.newpassword = {};
                            }
                        });
                }

                $scope.changePassword = function()
                {
                    User.changepassword($scope.updatepassword)
                        .success(function()
                        {
                            $scope.changepassword_success = true;
                            $scope.changepassword_error = false;
                            $('#changepassword').modal('hide');
                        })
                        .error(function(data)
                        {
                            if(data['error']['status_code'] == 400)
                            {
                                $scope.changepassword_success = false;
                                $scope.changepassword_error = true;
                                $scope.changepassword_errormessage = data['error']['message'];
                            }
                        });
                }

                User.getemail()
                    .success(function(data)
                    {
                        $scope.settings.email = data['email'];
                    });

                User.check()
                    .success(function()
                    {
                        $scope.changepassword = true;
                        $scope.createpassword = false;
                    })
                    .error(function(data)
                    {
                        if(data['error']['status_code'] == 404)
                        {
                            $scope.createpassword = true;
                            $scope.changepassword = false;
                        }
                    });
            });


