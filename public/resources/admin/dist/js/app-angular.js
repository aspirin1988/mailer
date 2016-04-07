var app = angular.module('app', []);

app.controller('blinkMainController', function($scope, $http) {
    $scope.mailerNewClientInfo = {};
    $scope.mailerClientsOwn = {};
    $scope.mailerClientOwnSettings = false;
    $scope.mailerClientEditSettings = false;

    $scope.mailerGetTemplate = function () {

    };

    $scope.mailerGetClients = function () {
        $scope.mailerClientOwnSettings = false;
        $scope.mailerClientEditSettings = false;

        $http({
            method: 'GET',
            url: '/admin/callback/GetAllSite'
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.mailerClients = response.data.data;

                $http({
                    method: 'GET',
                    url: '/admin/callback/GetAllGateway'
                }).then(function success(response) {
                    if(response.data.data !== false) {
                        $scope.mailerEmails = response.data.data;

                        var data = {};

                        for(var i=0; i < $scope.mailerEmails.length; i++) {
                            data[$scope.mailerEmails[i].id] = $scope.mailerEmails[i];
                        }

                        for(var i=0; i < $scope.mailerClients.length; i++) {
                            $scope.mailerClients[i].email = data[$scope.mailerClients[i].email];
                        }
                    }
                }, function error(response) {});
            }
        }, function error() {});
    };

    $scope.mailerGetClients();

    $scope.mailerUpdateClients = function(mailerClient) {
        $scope.mailerUpdateClientsInnerFunc = function(id) {
            if(!id) $scope.mailerClients[mailerClient].email = $scope.mailerClients[mailerClient].email.id;
            else $scope.mailerClients[mailerClient].email = id;

            $http({
                method: 'POST',
                url: '/admin/callback/EditSite',
                data: $scope.mailerClients[mailerClient]
            }).then(function success(response) {
                if(response.data.data !== false) {
                    $scope.mailerGetClients();
                }
            }, function error(response) {});
        };

        $scope.mailerUpdateClientsInnerFunc2 = function(route) {
            $http({
                method: 'POST',
                url: route,
                data: $scope.mailerClientsOwn
            }).then(function success(response) {
                if(response.data.data !== false) {
                    $scope.mailerUpdateClientsInnerFunc(response.data.data);
                    $scope.mailerClientOwnSettings = false;
                    $scope.mailerClientEditSettings = false;
                }
            }, function error(response) {});
        };

        if ($scope.mailerClientOwnSettings === false) {
            $scope.mailerUpdateClientsInnerFunc();
        } else if ($scope.mailerClientOwnSettings === true && $scope.mailerClientEditSettings !== true) {
            $scope.mailerUpdateClientsInnerFunc2('/admin/callback/AddGateway');
        } else if ($scope.mailerClientOwnSettings === true && $scope.mailerClientEditSettings === true) {
            $scope.mailerUpdateClientsInnerFunc2('/admin/callback/EditGateway');
        }
    };

    $scope.mailerAddNewClient = function(event) {
        $http({
            method: 'POST',
            url: '/admin/callback/AddSite',
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            if(response.data.data !== false) {
                $('#myModal').modal('toggle');
                $scope.mailerNewClientInfo = {};
                $scope.mailerGetClients();
            }

        }, function error(response) {});
    };

    $scope.mailerAddNewHost = function() {
        $scope.mailerClientOwnSettings = true;
    };

    $scope.mailerAddNewHostExit = function() {
        $scope.mailerClientOwnSettings = false;
    };

    $scope.mailerEditHosts = function(id) {
        $http({
            method: 'GET',
            url: '/admin/callback/getgateway/' + id
        }).then(function success(response) {
            if(response.data.data !== false) {
                $scope.mailerClientEditSettings = true;
                $scope.mailerClientsOwn = response.data.data[0];
                $scope.mailerClientOwnSettings = true;
            }
        }, function error() {});
    };

    $scope.mailerRemoveHosts = function (id) {
        $http({
            method: 'POST',
            url: '/admin/callback/DelSite',
            data: {id: id}
        }).then(function success(response) {
            if(response.data.data !== false) {
                $scope.mailerGetClients();
            }

        }, function error(response) {});
    }
});