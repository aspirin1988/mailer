var app = angular.module('app', []);

app.controller('blinkMainController', function($scope, $http) {
    $scope.newClientInfo = {};
    $scope.addNewClientResponse = false;

    $scope.getMailerTemplate = function () {

    };

    $scope.getMailerClients = function () {
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
                }, function error(response) {})
            }
        }, function error() {});
    };

    $scope.getMailerClients();

    $scope.updateMailerClients = function(mailerClient) {
        $scope.mailerClients[mailerClient].email = $scope.mailerClients[mailerClient].email.id;

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

    $scope.addNewClient = function(event) {
        $http({
            method: 'POST',
            url: '/admin/client/AddSite',
            data: $scope.newClientInfo
        }).then(function success(response) {
            $('#myModal').modal('toggle');
            $scope.addNewClientResponse = true;
            $scope.newClientInfo = {};

            setTimeout(function() {
                $scope.addNewClientResponse = false;
            }, 2500);

        }, function error(response) {});
    };
});