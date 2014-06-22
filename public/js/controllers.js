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
    }
);


