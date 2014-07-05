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
                    window.location.replace(shortener.url + '/login');
                })
                .error(function(data)
                {
                    if(data['error']['status_code'] == 400)
                    {
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
                    if(shortener.redirect_intend== "")
                    {
                        $window.location.replace(shortener.url + '/dashboard');
                    }
                    else
                    {
                        $window.location.replace(shortener.redirect_intend);
                    }
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
        $scope.currentPage = 1;
        $scope.maxSize = 10;
        var begin = (($scope.currentPage - 1) * $scope.maxSize)
            , end = begin + $scope.maxSize;
        Link.get()
            .success(function(data)
            {
                $scope.shortlinks = data.data;
                $scope.$watch('currentPage + maxSize', function() {
                    var begin = (($scope.currentPage - 1) * $scope.maxSize)
                        , end = begin + $scope.maxSize;
                    $scope.filteredLinks = $scope.shortlinks.slice(begin, end);
                });
            });



        $scope.submitLink = function()
        {
            Link.create($scope.shortlink)
                .success(function()
                {
                    Link.get()
                        .success(function(data)
                        {
                            $scope.shortlinks = data.data;
                            $scope.filteredLinks = $scope.shortlinks.slice(begin, end);
                        });
                });
        };
    })
    .controller('AnalyticsController',
    function($scope,Link)
    {
        $scope.traffic = [];
        $scope.topcities = [];
        $scope.topcountries = [];
        Link.details()
            .success(function(data)
            {
                $scope.pagetitle = data.pagetitle;
                $scope.domainprovider = data.domain;
                $scope.traffic = data.referrers;
                $scope.originallink = data.original_url;
                $scope.totalclicks = data.totalclicks;
                $scope.uniqueclicks = data.uniqueclicks;
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
        Link.locations()
            .success(function(data)
            {
                $scope.topcities = data.top5cities;
                $scope.topcountries = data.top5countries;
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

        $scope.deactivateAccount = function()
        {
            User.delete()
                .success(function()
                {
                    window.location.replace(shortener.url + '/logout');
                });
        };

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

        User.accounts()
            .success(function(data)
            {
                $scope.socialaccounts = data.data;
            })
    })
    .controller('HomeController',
    function($scope,Link)
    {
        $scope.created = false;
        $scope.generateLink = function()
        {
            Link.createhome($scope.generate)
                .success(function(data)
                {
                    $scope.created = true;
                    $scope.favicon = data.data.favicon;
                    $scope.pagetitle = data.data.pagetitle;
                    $scope.domainprovider = data.data.domainprovider;
                    $scope.url = data.data.url;
                    $scope.clicks = data.data.totalclicks;
                    $scope.hash = data.data.hash;
                });
        };
    })
    .controller('TwitterController',
    function($scope,User)
    {
        $scope.account = {};
        $scope.error = false;
        $scope.setEmail = function()
        {
            User.twitter($scope.account)
                .success(function(data)
                {
                    window.location.replace(shortener.url + '/dashboard');
                })
                .error(function(data)
                {
                    $scope.error = true;
                });
        }
    })
    .controller('ShareController',
    function($scope,User)
    {
        $scope.selectedsocial = [];
        $scope.sharedata = {};
        $scope.success = false;
        $scope.error = false;
        $scope.sharedata.message = shortener.message;
        User.accounts()
            .success(function(data)
            {
                $scope.socialaccounts = data.data;
            })

        $scope.selectAccount = function(index,data,selected)
        {
            if(selected)
            {
                $scope.selectedsocial.push(data);
            }
            else
            {
                $scope.selectedsocial.splice(index,1);
            }
        };

        $scope.postNow = function()
        {
            $scope.data = {
                'message': $scope.sharedata.message,
                'socialaccounts': $scope.selectedsocial
            };

            User.share($scope.data)
                .success(function(data)
                {
                    console.log(data);
                    $scope.success = true;
                    $scope.error = false;
                    $scope.successmessage = data.message;
                })
                .error(function(data)
                {
                    $scope.success = false;
                    $scope.error  = true;
                    $scope.errormessage = data.message;
                });
        }
    });


