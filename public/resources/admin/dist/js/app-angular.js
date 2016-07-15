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
            templateUrl: '/resources/admin/templates/widgets/main.html',
            controller: 'mainpageCtrl'
        })
        .when('/clients-list/:page', {
            templateUrl: '/resources/admin/templates/widgets/clients-list.html',
            controller: 'clientsCtrl'
        })
        .when('/client-sites/:id/:page', {
            templateUrl: '/resources/admin/templates/widgets/client-sites.html',
            controller: 'clientCtrl'
        })
        .when('/mailer', {
            templateUrl: '/resources/admin/templates/widgets/all-websites.html'
        })
        .when('/mailer-settings/:siteId', {
            templateUrl: '/resources/admin/templates/widgets/mailer-settings.html',
            controller: 'mailerCtrl'
        })
        .when('/users-list/:page', {
            templateUrl: '/resources/admin/templates/widgets/user-settings.html',
            controller: 'userCtrl'
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

    factory.getAllClients = function (callback,route) {
        $http({
            method: 'GET',
            url: '/admin/client/GetAllClient/'+route.page
        }).then(function success(response) {
            if(response.data.data !== false){

                callback(response.data);
            }

        }, function error(response) {});
    };

    return factory;
});

app.factory('clientFactory', function ($http) {
    var factory = {};

    factory.getSites = function (id,callback,page) {
        $http({
            method: 'GET',
            url: '/admin/client/GetAllSiteClient/' + id+'/'+page
        }).then(function success(response) {
            if(response.data.data !== false) {
                callback(response.data);
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

app.factory('userFactory', function ($http) {
    var factory = {};

    factory.getSettings = function (callback) {
        $http({
            method: 'GET',
            url: '/admin/Users/GetAllUsers/'
        }).then(function success(response) {
            if(response.data !== false) {
                callback(response.data.data);
            }
        }, function error(response) {});
    };

    return factory;
});

app.controller('clientsCtrl', function ($scope, clientsFactory,$routeParams,$http) {
    $scope.allClients = {};
    clientsFactory.getAllClients(function (data) {
        $scope.allClients = data.data;
        $scope.route=$routeParams;

        var pagination=[];

        for (i=0; i<data.count; i++)
        {
            pagination[i]=i;
        }
        $scope.countpage = pagination;
    },$routeParams);

    $scope.AddClient=function () {
        $http({
            method: 'POST',
            url: '/admin/client/AddClient/'+$routeParams.page,
            data: $scope.NewClient
        }).then(function success(response) {
            if(response.data.data !== false) {
                $scope.NewClient={};
                UIkit.notify("<i class='uk-icon-check'></i>Клиент успешно добавлен!",{status:'success',pos:'top-right'});
                $scope.allClients=response.data.data;
                console.info(response);
            }
        }, function error(response) {});
    };

});

app.controller('clientCtrl', function ($scope, $routeParams, clientFactory,$http) {
    $scope.sites = {};

    clientFactory.getSites($routeParams.id, function(data) {
        $scope.sites = data.data;
        $scope.route = $routeParams;
        $scope.pagesize=data.pagesize;
        $scope.offset=0;
        var countpage=Math.ceil((data.count/(data.pagesize)));

        var pagination=[];
        for (i=0; i<countpage; i++)
        {
            pagination[i]=i;
        }
        $scope.countpage = pagination;
    },$routeParams.page);

    $scope.AddSite = function(event) {
        //console.info($routeParams);
        $http({
            method: 'POST',
            url: '/admin/callback/AddSite/'+$routeParams.id,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            $scope.sites=response.data.data;
            if(response.data.data !== false) {
                $scope.mailerNewClientInfo = {};
                UIkit.notify("<i class='uk-icon-check'></i>Сайт успешно добавлен!",{status:'success',pos:'top-right'});
                $scope.mailerGetClients();
                //location.reload();
            }

        }, function error(response) {});
    };

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
        console.log(key);
        console.log($scope.mailerSettings.options_default.css[key].config);

        if(!object) {
            if(editing === true) $scope.addingNewItem = true;
            else $scope.addingNewItem = false;
        } else {
            if(editing === true) $scope.addingNewItem = true;
            else $scope.addingNewItem = false;

            $scope.mailerSettings.options_default.css[key].config.push(object);
            $scope.newItem = {};
        }
    };

    $scope.removeProperty = function(keyObject, keyStyle) {
        console.log($scope.mailerSettings.options_default.css[keyObject]);
        $scope.mailerSettings.options_default.css[keyObject].config.splice(keyStyle, 1);
    };

    $scope.console = function (obj) {
        $http({
            method: 'POST',
            url: '/admin/editor/GetEditCSS/'+$routeParams.siteId,
            data: $scope.mailerSettings
        }).then(function success(response) {
            if(response.data !== false) {
                $scope.widgetStylesheets = response.data;
                var overlay=document.getElementById('overlay-blink');
                overlay.style.display = 'block';
                overlay.style.position = 'static';
                overlay.style.zIndex = 0;
            }
        }, function error(response) {});
    };
    $scope.addContact = function ($obj) {

        console.log(Object($scope.mailerSettings.text_default.contacts.data).length);
        if (Object($scope.mailerSettings.text_default.contacts.data).length<=3) {
            $scope.mailerSettings.text_default.contacts.data.push({
                "type": "tel",
                "text": "Текст контакта",
                "title": "Название контакта"
            });
        }
        else {
            UIkit.notify("<i class='uk-icon-check'></i>Контактов на форме может быть, не более 4-х!",{status:'warning',pos:'top-right'});
        }
        $scope.console($obj);
        return $scope.mailerSettings.text_default.contacts.data;
        
    };
    $scope.delContact = function ($obj) {
            console.log($obj);
            $scope.mailerSettings.text_default.contacts.data.splice($obj,1);
            $scope.console($obj);
            return $scope.mailerSettings.text_default.contacts.data;

        };



    $scope.saveSettings = function (obj) {
        $http({
            method: 'GET',
            url: '/admin/editor/SaveConfig/'+$routeParams.siteId
        }).then(function success(response) {
            if (response)
            {
                UIkit.notify("<i class='uk-icon-check'></i>Настройки были успешно сохранены!",{status:'success',pos:'top-right'});
            }
            else
            {
                UIkit.notify("<i class='uk-icon-check'></i>Настройки не были сохранены!",{status:'danger',pos:'top-right'});
            }
        }, function error(response) {});
    };

    $scope.cancelSettings = function (obj) {
        $http({
            method: 'GET',
            url: '/admin/editor/CancelConfig/'+$routeParams.siteId
        }).then(function success(response) {
            if (response)
            {
                UIkit.notify("<i class='uk-icon-check'></i>Настройки были успешно сврошены",{status:'success',pos:'top-right'});
            }
            else
            {
                UIkit.notify("<i class='uk-icon-check'></i>Настройки не были сврошены",{status:'danger',pos:'top-right'});
            }
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
                var overlay=document.getElementById('overlay-blink');
                overlay.style.display = 'block';
                overlay.style.position = 'static';
                overlay.style.zIndex = 0;
            }

        }, function error(response) {});
    };

    $scope.changeCss();

});

app.controller('userCtrl', function ($scope, $http, $sce, $routeParams, userFactory) {
    userFactory.getSettings(function (data) {
        $scope.usersSettings = data;


    });

    $scope.dellPerm=function (id,key1,key) {
        console.log($scope.usersSettings[key].company[key1]);
        //delete ($scope.usersSettings[key].company[key1]);
        $scope.usersSettings[key].company.splice(key1, 1);
        $http({
            method: 'GET',
            url: '/admin/Users/delPermission/'+id,
        }).then(function success(response) {
            $scope.sites=response.data.data;
            if(response.data.data !== false) {

                UIkit.notify("<i class='uk-icon-check'></i>Доступ успешно удален!",{status:'success',pos:'top-right'});
                //$scope.mailerGetClients();
            }

        }, function error(response) {});
    };

    /*$scope.dellPerm=function (id) {
        console.log($scope.usersSettings[key].company[key1]);
        $http({
            method: 'GET',
            url: '/admin/Users/delPermission/'+id,
        }).then(function success(response) {

        }, function error(response) {});
    };*/
    
    $scope.companyApr=function (id,val) {
        console.log(val);
        $http({
            method: 'POST',
            url: '/admin/Users/approvePermission_c/'+id,
            data: val
        }).then(function success(response) {

        }, function error(response) {});
    };

    $scope.dellPermSite=function (id,key2,key1,key) {
        console.log(id+' '+key2+' '+key1+' '+key);
        console.log($scope.usersSettings[key].company[key1].sites[key2]);
        //delete ($scope.usersSettings[key].company[key1].sites[key2]);
        $scope.usersSettings[key].company[key1].sites.splice(key2, 1);
        $http({
            method: 'GET',
            url: '/admin/Users/delPermission_s/'+id,
        }).then(function success(response) {
            $scope.sites=response.data.data;
            if(response.data.data !== false) {
                UIkit.notify("<i class='uk-icon-check'></i>Доступ успешно удален!",{status:'success',pos:'top-right'});
            }

        }, function error(response) {});
    };

    $scope.siteApr=function (id,val) {
            console.log(val);
            $http({
                method: 'POST',
                url: '/admin/Users/approvePermission_s/'+id,
                data: val
            }).then(function success(response) {

            }, function error(response) {});
        }

});

app.controller('blinkMainController',function($scope, $http, authUser, $sce, $routeParams) {
    $scope.date = new Date();

    authUser.getAuthUserInfo(function (data) {
        $scope.authUserInfo = data;
    });

    $scope.mailerNewClientInfo = {};
    $scope.newCompany = {};
    $scope.siteInfo = {};
    $scope.html = {};
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


    $scope.showSiteInfo= function (obj) {
        $http({
            method: 'POST',
            url: '/admin/Client/GetSiteInfo/'+obj,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            if(response.data.data !== false) {
                //console.log(response);
                $scope.siteInfo=response.data;
                //return $scope.siteInfo;
            }
        }, function error(response) {});
    };

    $scope.editHosts = function(id) {
        $http({
            method: 'GET',
            url: '/admin/callback/getgateway/' + id
        }).then(function success(response) {
            console.log(response);
            if(response.data.data !== false) {
                $scope.hostSettingsVisibility = true;
                $scope.hostSettings = response.data.data[0];
                $scope.mailerClientOwnSettings = true;
            }
        }, function error() {});
    };

   $scope.saveHosts = function(id) {
        $http({
            method: 'POST',
            url: '/admin/callback/EditGateway/',
            data: $scope.hostSettings
        }).then(function success(response) {
            console.log(response);
            if(response.data.data !== false) {
                $scope.hostSettingsVisibility = false;
                $scope.mailerEmails=response.data.data;
            }
        }, function error() {});
    };

    $scope.addHosts = function() {
        $scope.addhostSettingsVisibility = true;
        $scope.hostSettings ={}
    };

    $scope.cancelHost = function() {
        $scope.hostSettingsVisibility = false;
        $scope.addhostSettingsVisibility = false;
        $scope.hostSettings ={}
    };

    $scope.editSite = function() {
        $scope.siteEdit = true;
    };

    $scope.cancelSite = function() {
        $scope.siteEdit = false;
    };

    $scope.saveSite = function(data,key) {
        $http({
            method: 'POST',
            url: '/admin/callback/EditSite/',
            data: data
        }).then(function success(response) {
            console.log(response);
            if(response.data.data !== false) {
                $scope.siteEdit = false;
                return response.data.data;
            }
        }, function error() {});
    };

    $scope.sendHosts = function() {
        console.log($scope.hostSettings);
        $http({
            method: 'POST',
            url: '/admin/callback/AddGateway/',
            data: $scope.hostSettings
        }).then(function success(response) {
            console.log(response);
            if(response.data.data !== false) {
                $scope.addhostSettingsVisibility = false;
                $scope.mailerEmails=response.data.data;
            }
        }, function error() {});
    };

    $scope.ShowasHyml = function(obj) {
        return $sce.trustAsHtml(obj);
    };

    $scope.messageFilter = function (obj) {

            $scope.status = obj;
            return $scope.status;
        
    };

    $scope.updatePage= function (page) {
      console.log(page);
    };

    $scope.operatorApr = function (id,approve,sitename) {
        $http({
            method: 'POST',
            url: '/admin/callback/OperatorEdit/'+id+'/'+approve+'/'+sitename,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {

        }, function error(response) {});
    };

    $scope.dellOperator = function (id,siteID,siteName) {
        console.info(id+' '+siteID+' '+siteName);
        var OperatorW=document.getElementById('Operator'+id);
        $http({
            method: 'POST',
            url: '/admin/callback/OperatorDel/'+id+'/'+siteID+'/'+siteName,
            data: $scope.mailerNewClientInfo
        }).then(function success(response) {
            OperatorW.style.display="none";
        }, function error(response) {});
    };



    $scope.addNewCompany = function() {
        //console.info($routeParams);
        $http({
            method: 'POST',
            url: '/admin/Client/AddClient/',
            data: $scope.NewClient
        }).then(function success(response) {
            if(response.data.data !== false) {
                $scope.NewClient={};
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