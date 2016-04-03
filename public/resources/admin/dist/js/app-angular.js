var app = angular.module('app', []);

app.controller('blinkMainController', function($scope, $http) {
    $scope.newClientInfo = {};
    $scope.mailerClientsOwn = {};
    $scope.mailerClientOwnSettings = false;
    $scope.mailerClientEditSettings = false;

    $scope.getMailerTemplate = function () {

    };

    $scope.getMailerClients = function () {
        $scope.mailerClientOwnSettings = false;
        $scope.mailerClientEditSettings = false;

        $http({
            method: 'GET',
            url: '/admin/client/GetAllSite'
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.mailerClients = response.data.data;

                $http({
                    method: 'GET',
                    url: '/admin/client/GetAllGateway'
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

    $scope.getMailerClients();

    $scope.updateMailerClients = function(mailerClient) {
        $scope.updateMailerClientsInnerFunc = function(id) {
            if(!id) $scope.mailerClients[mailerClient].email = $scope.mailerClients[mailerClient].email.id;
            else $scope.mailerClients[mailerClient].email = id;

            $http({
                method: 'POST',
                url: '/admin/client/EditSite',
                data: $scope.mailerClients[mailerClient]
            }).then(function success(response) {
                if(response.data.data !== false) {
                    $scope.getMailerClients();
                }
            }, function error(response) {});
        };

        $scope.updateMailerClientsInnerFunc2 = function(route) {
            $http({
                method: 'POST',
                url: route,
                data: $scope.mailerClientsOwn
            }).then(function success(response) {
                if(response.data.data !== false) {
                    $scope.updateMailerClientsInnerFunc(response.data.data);
                    $scope.mailerClientOwnSettings = false;
                    $scope.mailerClientEditSettings = false;
                }
            }, function error(response) {});
        };

        if ($scope.mailerClientOwnSettings === false) {
            $scope.updateMailerClientsInnerFunc();
        } else if ($scope.mailerClientOwnSettings === true && $scope.mailerClientEditSettings !== true) {
            $scope.updateMailerClientsInnerFunc2('/admin/client/AddGateway');
        } else if ($scope.mailerClientOwnSettings === true && $scope.mailerClientEditSettings === true) {
            $scope.updateMailerClientsInnerFunc2('/admin/client/EditGateway');
        }
    };

    $scope.addNewClient = function(event) {
        $http({
            method: 'POST',
            url: '/admin/client/AddSite',
            data: $scope.newClientInfo
        }).then(function success(response) {
            if(response.data.data !== false) {
                $('#myModal').modal('toggle');
                $scope.newClientInfo = {};
                $scope.getMailerClients();
            }

        }, function error(response) {});
    };

    $scope.addNewHost = function() {
        $scope.mailerClientOwnSettings = true;
    };

    $scope.addNewHostExit = function() {
        $scope.mailerClientOwnSettings = false;
    };

    $scope.editHosts = function(id) {
        $http({
            method: 'GET',
            url: '/admin/client/getgateway/' + id
        }).then(function success(response) {
            if(response.data.data !== false) {
                $scope.mailerClientEditSettings = true;
                $scope.mailerClientsOwn = response.data.data[0];
                $scope.mailerClientOwnSettings = true;
            }
        }, function error() {});
    };
});