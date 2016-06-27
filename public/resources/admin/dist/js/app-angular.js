/* ==================================================================================================
 ** LOADING PAGE EVENT...
 =================================================================================================== */
var loadTemplate = function () {
    document.getElementById('main-container').style.visibility = 'visible';
};

var loadLocalFunc = function(evt) {
    window.onload(evt);
    loadTemplate(evt);
};

if(window.attachEvent) {
    window.attachEvent('onload', loadTemplate);
} else {
    if(window.onload) {
        window.onload = loadLocalFunc;
    } else {
        window.onload = loadTemplate;
    }
}

$(document).scroll(function (event) {
    if ($(document).scrollTop() >= 98) {
        $('.to-fixed-on-scroll').addClass('to-fixed-on-scroll-active');
    }
    else {
        $('.to-fixed-on-scroll').removeClass('to-fixed-on-scroll-active');
    }
});


/* ==================================================================================================
 ** WEBSITE CAPTURE...
 =================================================================================================== */

/* ==================================================================================================
** ANGULAR STARTS HERE...
=================================================================================================== */

var app = angular.module('app', ['ngRoute', 'colorpicker.module']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/', {
            template: '<p>Hello this is main page</p>'
        })
        .when('/clients-list', {
            templateUrl: '/resources/admin/templates/widgets/clients-list.html',
            controller: 'clientsCtrl'
        })
        .when('/client-sites/:id', {
            templateUrl: '/resources/admin/templates/widgets/client-sites.html',
            controller: 'clientCtrl'
        })
        .when('/mailer', {
            templateUrl: '/resources/admin/templates/widgets/all-websites.html'
        })
        .when('/mailer-settings/:siteId', {
            templateUrl: '/resources/admin/templates/widgets/mailer-settings.html',
            controller: 'mailerCtrl'
        });
});

app.factory('authUser', function ($http) {
    var factory = {};

    factory.getAuthUserInfo = function (callback) {
        $http({
            method: 'GET',
            url: '/helper/user/getUser'
        }).then(function success(response) {
            if(response.data[0] !== false) {
                 callback(response.data[0]);
            }
        }, function error(response) {});
    };

    return factory;
});

app.factory('clientsFactory', function ($http) {
    var factory = {};

    factory.getAllClients = function (callback) {
        $http({
            method: 'GET',
            url: '/admin/client/GetAllClient'
        }).then(function success(response) {
            if(response.data.data !== false){
                callback(response.data.data);
            }

        }, function error(response) {});
    };

    return factory;
});

app.factory('clientFactory', function ($http) {
    var factory = {};

    factory.getSites = function (id, callback) {
        $http({
            method: 'GET',
            url: '/admin/client/GetAllSiteClient/' + id
        }).then(function success(response) {
            if(response.data.data !== false) {
                callback(response.data.data);
            }
        }, function error(response) {});
    };

    return factory;
});

app.factory('mailerFactory', function ($http) {
    var factory = {};

    factory.getSettings = function (id, callback) {
        $http({
            method: 'GET',
            url: '/admin/editor/GetOptions/' + id
        }).then(function success(response) {
            if(response.data !== false) {
                callback(response.data);
            }
        }, function error(response) {});
    };

    return factory;
});

app.controller('clientsCtrl', function ($scope, clientsFactory) {
    $scope.allClients = {};

    clientsFactory.getAllClients(function (data) {
        $scope.allClients = data;
    });
});

app.controller('clientCtrl', function ($scope, $routeParams, clientFactory) {
    $scope.sites = {};

    clientFactory.getSites($routeParams.id, function(data) {
        $scope.sites = data;
    });
});

app.controller('mailerCtrl', function ($scope, $http, $sce, $routeParams, mailerFactory) {
    mailerFactory.getSettings($routeParams.siteId, function (data) {
        $scope.mailerSettings = data;

        $scope.mailerSettings.text_default.recall.main_icon = function() {
            return $sce.trustAsHtml($scope.mailerSettings.text_default.recall.main_icon);
        };

    });

    $scope.addingNewItem = false;
    $scope.newItem = {};

    $scope.addProperty = function(key, editing, object) {
        if(!object) {
            if(editing === true) $scope.addingNewItem = true;
            else $scope.addingNewItem = false;
        } else {
            if(editing === true) $scope.addingNewItem = true;
            else $scope.addingNewItem = false;

            $scope.mailerSettings[key].style.push(object);
            $scope.newItem = {};
        }
    };

    $scope.removeProperty = function(keyObject, keyStyle) {
        $scope.mailerSettings[keyObject].style.splice(keyStyle, 1);
    };

    $scope.console = function (obj) {
        $http({
            method: 'POST',
            url: '/admin/editor/GetEditCSS/'+$routeParams.siteId,
            data: $scope.mailerSettings
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.widgetStylesheets = response.data;
            }
        }, function error(response) {});
    };



    $scope.saveSettings = function (obj) {
        $http({
            method: 'GET',
            url: '/admin/editor/SaveConfig/'+$routeParams.siteId
        }).then(function success(response) {
            
        }, function error(response) {});
    };

    $scope.cancelSettings = function (obj) {
        $http({
            method: 'GET',
            url: '/admin/editor/CancelConfig/'+$routeParams.siteId
        }).then(function success(response) {

        }, function error(response) {});
    };

    $scope.changeCss = function() {
        $http({
            method: 'POST',
            url: '/admin/editor/GetEditCSS/'+$routeParams.siteId,
            data: false
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.widgetStylesheets = response.data;
            }

        }, function error(response) {});
    };

    $scope.changeCss();

});

app.controller('blinkMainController', function($scope, $http, authUser, $routeParams) {
    $scope.date = new Date();

    authUser.getAuthUserInfo(function (data) {
        $scope.authUserInfo = data;
    });

    $scope.mailerNewClientInfo = {};
    $scope.newCompany = {};
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

    $scope.AddSite = function(event) {
        //console.info($routeParams);
        $http({
            method: 'POST',
            url: '/admin/callback/AddSite/'+$routeParams.id,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            if(response.data.data !== false) {
                $('#myModal').modal('toggle');
                $scope.mailerNewClientInfo = {};
                $scope.mailerGetClients();
                location.reload();
            }

        }, function error(response) {});
    };

    $scope.operatorApr = function (id,approve,sitename) {
        console.info(id+' '+approve);
        $http({
            method: 'POST',
            url: '/admin/callback/OperatorEdit/'+id+'/'+approve+'/'+sitename,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            console.info(response);
        }, function error(response) {});
    };

    $scope.addNewCompany = function(event) {
        //console.info($routeParams);
        $http({
            method: 'POST',
            url: '/admin/Client/AddClient/',
            data: $scope.newCompany
        }).then(function success(response) {
            if(response.data.data !== false) {
                $('#myModal').modal('toggle');
                $scope.newCompany = {};
                $scope.mailerGetClients();
                // location.reload();
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
    };

    $scope.mailerGetClients();

    $scope.recallHeaderWidget = false;
    $scope.messangeHeaderWidget = false;
    $scope.chatHeaderWidget = false;

    $scope.defaultCssValues = {};

    $scope.changeCss = function() {
        $http({
            method: 'POST',
            url: '/admin/editor/GetEditCSS/'+$routeParams.siteId,
            data: false
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.widgetStylesheets = response.data;
            }

        }, function error(response) {});
    };

    $scope.changeCss();

});

/* ==================================================================================================
 ** ANGULAR DIRECTIVES...
 =================================================================================================== */

app.directive('getHeader', function () {
    return {
        templateUrl: '/resources/admin/templates/header.html'
    }
});

app.directive('getSidebar', function () {
    return {
        templateUrl: '/resources/admin/templates/sidebar.html'
    }
});

app.directive('getFooter', function () {
    return {
        templateUrl: '/resources/admin/templates/footer.html'
    }
});

app.directive('getModal', function () {
    return {
        templateUrl: '/resources/admin/templates/modal.html'
    }
});

app.directive('defaultTemplateDirectory', function () {
    return {
        templateUrl: '/resources/callback/html/default/main.html'
    }
});

/* ==================================================================================================
 ** WIDGETS...
 =================================================================================================== */

app.directive('recallHeaderWidget', function () {
    return {
        templateUrl: '/resources/callback/html/default/widgets/recall-header-widget.html'
    }
});

app.directive('messangeHeaderWidget', function () {
    return {
        templateUrl: '/resources/callback/html/default/widgets/messange-header-widget.html'
    }
});

app.directive('chatHeaderWidget', function () {
    return {
        templateUrl: '/resources/callback/html/default/widgets/chat-header-widget.html'
    }
});