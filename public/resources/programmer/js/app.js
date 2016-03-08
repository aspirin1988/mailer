$(document).ready(function() {
    $("#menu-toggle").click(function(e) {
        $("#wrapper").toggleClass("toggled");
    });

    $('.carousel').carousel({
        interval: false
    });
});

angular.module('popupDialog', [])
    .directive('popupDialog', function() {
        return {
            restrict: 'E',
            scope: false,
            templateUrl: '/resources/programmer/html/popupDialog.html',
            link: function(scope, element, attr) {
                var popupDialog = document.getElementById('popup-dialog-content'),
                    popupDialogWidth = popupDialog.offsetWidth,
                    popupDialogMargin = popupDialogWidth / 2;

                popupDialog.style.marginLeft = '-' + popupDialogMargin + 'px';

                scope.popupDialogVisibility = false;

                scope.hidePopupDialog = function() {
                    scope.popupDialogVisibility = false;
                };

                scope.confirmedPopupDialog = function () {
                    scope[scope.popupDialogCallback]();
                    scope.popupDialogVisibility = false;
                }
            }
        };
    });


function makeChart(id, text, data) {
    var chart = new CanvasJS.Chart(id,
        {
            title:{
                text: text
            },
            animationEnabled: true,
            legend:{
                verticalAlign: "bottom",
                horizontalAlign: "center"
            },
            data: [
                {
                    indexLabelFontSize: 20,
                    indexLabelFontFamily: "Monospace",
                    indexLabelFontColor: "darkgrey",
                    indexLabelLineColor: "darkgrey",
                    indexLabelPlacement: "outside",
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{y} - <strong>#percent%</strong>",
                    dataPoints: data
                }
            ]
        });

    chart.render();
}


var programmer = angular.module('programmer', ['popupDialog']);

(function (module) {

    var fileReader = function ($q, $log) {

        var onLoad = function(reader, deferred, scope) {
            return function () {
                scope.$apply(function () {
                    deferred.resolve(reader.result);
                });
            };
        };

        var onError = function (reader, deferred, scope) {
            return function () {
                scope.$apply(function () {
                    deferred.reject(reader.result);
                });
            };
        };

        var onProgress = function(reader, scope) {
            return function (event) {
                scope.$broadcast("fileProgress",
                    {
                        total: event.total,
                        loaded: event.loaded
                    });
            };
        };

        var getReader = function(deferred, scope) {
            var reader = new FileReader();
            reader.onload = onLoad(reader, deferred, scope);
            reader.onerror = onError(reader, deferred, scope);
            reader.onprogress = onProgress(reader, scope);
            return reader;
        };

        var readAsDataURL = function (file, scope) {
            var deferred = $q.defer();

            var reader = getReader(deferred, scope);
            reader.readAsDataURL(file);

            return deferred.promise;
        };

        return {
            readAsDataUrl: readAsDataURL
        };
    };

    module.factory("fileReader",
        ["$q", "$log", fileReader]);

}(angular.module("programmer")));

programmer.controller('programmerCtrl', function($scope, $http, $templateRequest, $sce, $compile, fileUpload, fileReader) {

    $scope.projectBackreport = {};
    $scope.avaliableProjects = {};
    $scope.myProjects = {};
    $scope.toAcceptProjects = {};
    $scope.finishedProjects = {};
    $scope.commentaryKey = "";
    $scope.changedStatus = '16';
    $scope.commentResponse = "";
    $scope.locale = {};
    $scope.report = {};

    $scope.openPopupDialog = function($funcName, $question) {
        $scope.popupDialogVisibility = true;
        $scope.popupDialogQuestion = $question;
        $scope.popupDialogCallback = $funcName;
    };

    $scope.updateProject = function () {
        delete $scope.imagePreviewUrl;
        $scope.openPopupDialog('acceptProject', $scope.locale['Programmers_are_you_sure_you-want_to_approve']);

        $scope.acceptProject = function () {
            $scope.projectDetail['status'] = 17;

            $http({
                method:'POST',
                url: '/?route=programmer&action=edit-project',
                data: $scope.projectDetail
            }).then(function sucess(response) {
                $('#projectDetail').modal('toggle');
                $scope.getMyProjects();
                $scope.getAcceptedProject();
            }, function error(response) {});
        }
    };

    // Get File
    $scope.getFile = function ($uploadFilePreview) {
        var uploadUrl = '/?route=programmer&action=fileup&projectId=' + $scope.projectDetail['id'];
        fileReader.readAsDataUrl($uploadFilePreview, $scope)
            .then(function(result) {
                $('#imagePreviewUrl').removeClass('hidden');
                $scope.imagePreviewUrl = result;
                $scope.openPopupDialog('loadProjectFiles', $scope.locale['Programmers_upload_file']);
            });

        $scope.loadProjectFiles = function () {
            fileUpload.uploadFileToUrl($uploadFilePreview, uploadUrl, function (e) {
                if(e) {
                    $scope.getProjectFiles($scope.projectDetail['id']);
                }
            });
        };
    };

    // GET Projects
    $scope.getProjects = function(url, callback) {
        $http({
            method: 'GET',
            url: url
        }).then(function success(response) {
            callback(response.data);
        }, function error(response) {});
    };

    // GET Available Project
    $scope.getAvaiPrjects = function() {
        $scope.getProjects('/programmer/projects/otherProjects', function(callback) {
            $scope.avaliableProjects = callback.data;
            $scope.avaliableProjectsApprove = callback.hasProject;
        });
    };
    $scope.getAvaiPrjects();

    // GET My Project
    $scope.getMyProjects = function() {
        $scope.getProjects('/programmer/projects/myProjects', function(callback) {
            $scope.myProjects = callback.data;
        });
    };
    $scope.getMyProjects();

    // To Accepted Projects
    $scope.getAcceptedProject = function() {
        $scope.getProjects('/programmer/projects/toApprove', function(callback) {
            $scope.toAcceptProjects = callback.data;
        });
    };
    $scope.getAcceptedProject();

    // Finished Projects
    $scope.getFinishedProject = function() {
        $scope.getProjects('/programmer/projects/finish', function(callback) {
            $scope.finishedProjects = callback.data;
        });
    };
    $scope.getFinishedProject();

    // Locale
    $http({
        method: 'GET',
        url: '/programmer/language/index'
    }).then(function success(response) {
        $scope.locale = response.data;
    }, function error(response) {});

    $http({
        method: 'GET',
        url: '/helper/user/getUser'
    }).then(function success(response) {
        $scope.user=response.data;
    });

    $scope.updateBugTracker = function (message, parent, to, projectId, collapseObj) {
        var Data = {
            parent: parent,
            project: projectId,
            message: message,
            to: to
        };

        $http({
            method: 'POST',
            url: '/?route=programmer&action=edit-bugtrack',
            data: Data
        }).then(function success(response) {
            $scope.getProjectPatchList(projectId);

        }, function error(response) {});
    };

    $scope.projectDetails = function($id) {
        $http({
            method: 'GET',
            url: '/programmer/projects/projectView/' + $id
        }).then(function success(response) {
            $scope.projectDetail = response.data.data[0];
            $scope.projectDetail['brif'] = JSON.parse($scope.projectDetail['brif']);
            $scope.getProjectComments($id);
            $scope.getProjectFiles($id);
            $scope.getProjectPatchList($id);
            $scope.getCompanyInfo($scope.projectDetail.company);


            var projectDetailsView = $sce.getTrustedResourceUrl('/resources/programmer/html/projectDetails.html'),
                projectCommentsView = $sce.getTrustedResourceUrl('/resources/programmer/html/projectComments.html'),
                projectBackreportView = $sce.getTrustedResourceUrl('/resources/programmer/html/projectBackreport.html'),
                companyInfoView = $sce.getTrustedResourceUrl('/resources/programmer/html/company-info.html');

            $templateRequest(projectDetailsView).then(function(template) {
                $compile($('#projectDetails').html(template).contents())($scope);
            }, function() {});

            $templateRequest(projectCommentsView).then(function(template) {
                $compile($('#projectComments').html(template).contents())($scope);

                $scope.commentResponse = false;
            }, function() {});

            $templateRequest(projectBackreportView).then(function(template) {
                $compile($('#projectBackreport').html(template).contents())($scope);
            }, function() {});

            $templateRequest(companyInfoView).then(function(template) {
                $compile($('#companyInfo').html(template).contents())($scope);
            }, function() {});

            $scope.getAvaiPrjects();
            $("#myCarousel").carousel(0);

        }, function error(response) {});
    };

    $scope.getProjectComments = function ($id) {
        $http({
            method: 'GET',
            url: '/programmer/comments/getComments/' + $id
        }).then(function success(response) {
            $scope.projectComments = response.data.data;
            $scope.commentaryKey = Object.keys($scope.projectComments).length;
        }, function error(response) {});
    };

    $scope.getProjectFiles = function ($id) {
        $http({
            method: 'GET',
            url: '/programmer/files/getFiles/' + $id
        }).then(function success(response) {
            $scope.projectFiles = response.data.files;
            $scope.soloProjectFilesApprove = response.data['count'];
        }, function error(response) {});
    };

    $scope.getProjectPatchList = function ($id) {
        $http({
            method: 'GET',
            url: '/programmer/patchlist/getPatchList/' + $id
        }).then(function success(response) {
            $scope.projectBackreport = response.data['patch_lists'].data;

            $.each($scope.projectBackreport, function(key, val) {
                $.each(val.node, function(key1, val1) {
                    if(val1.to !== '8') {
                        $scope.projectBackreport[key]['node'][key1]['iselement'] = $sce.trustAsHtml(val1.message);
                    }
                });
            });
        }, function error(response) {});
    };

    $scope.getCompanyInfo = function ($id) {
        $http({
            method: 'GET',
            url: '/programmer/company/getCompany/' + $id
        }).then(function success(response) {
            $scope.companyInfo = response.data.data[0];
            $scope.companyInfo['contact'] = JSON.parse($scope.companyInfo['contact']);
        }, function error(response) {});
    };

    $scope.projectDetailCheck = function ($id) {
        delete $scope.imagePreviewUrl;
        var string = "Вы уверены что хотите принять проект?";
        $scope.openPopupDialog('projectDetailsApproved', string);

        $scope.projectDetailsApproved = function () {
            $http({
                method: 'POST',
                url: '/programmer/projects/editDeveloper',
                data: { id: $id }
            }).then(function success(response) {
                $scope.projectDetails($id);
                $('#projectDetail').modal('toggle');
            }, function error() {});
        }
    };


    // ============================================================================================================
    // Reports tab
    // ============================================================================================================


    //Reports of hole department
    $scope.getDepartment = function () {
        $scope.Dreport=true;
        $('#chartContainer').html('');

    };
    $scope.getReportDepartment = function () {

        var data=[];
        var statuses = {
            status1: {status_name: "Разработка проекта", items: []},
            status2: {status_name: "Утверждение дизайна", items: []},
            status3: {status_name: "Завершенный проект", items: []},
            status4: {status_name: "Тестирование проекта", items: []},
            status5: {status_name: "Дизайн", items: []},
            status6: {status_name: "Утверждение вертски", items: []}
        };
        $http({
            method: 'GET',
            url: '/?route=programmer&action=get-stat-all-slave&to='+ $scope.slaveTo +'&do='+ $scope.slaveDo
        }).then(function success(response) {
            if(response.data.count > 0) {
                var arrayOfResponse = response.data.data;
                data = [];
                $.each(arrayOfResponse, function (key, val) {
                    if(val.status === "16") {
                        for(var i=0;i<val.count;i++)
                            statuses.status1['items'].push(val);
                    } else if (val.status === "13") {
                        for(var i=0;i<val.count;i++)
                            statuses.status2['items'].push(val);
                    } else if (val.status === "19") {
                        for(var i=0;i<val.count;i++)
                            statuses.status3['items'].push(val);
                    } else if (val.status === "17") {
                        for(var i=0;i<val.count;i++)
                            statuses.status4['items'].push(val);
                    }else if (val.status === "12") {
                        for(var i=0;i<val.count;i++)
                            statuses.status5['items'].push(val);
                    }else if (val.status === "15") {
                        for(var i=0;i<val.count;i++)
                            statuses.status6['items'].push(val);
                    }
                });

                $.each(statuses, function (key, val) {
                    if(val['items'].length!==0)
                        data.push({  y: val['items'].length, legendText:val.status_name + "("+ val['items'].length +")", indexLabel: val.status_name });
                });


                makeChart('chartContainer', 'Отчет по отделу', data);
            } else {
                var data = [{  y: 100, legendText: 'У отдела нет данных', indexLabel: 'У отдела нет данных' }];
                makeChart('chartContainer','Отчет по отделу', data);
            }
        }, function error(response) {});
    };


    //Report by employee(or slave)
    $scope.getReport = function () {
        $http({
            method: 'GET',
            url: '/?route=helper&action=search-all-my-slave'
        }).then(function success(response) {
            $scope.report = response.data;
        });
    };
    $scope.getReport();

    $scope.getSlaveId = function (id, name, lastname, middlename) {
        $scope.Dreport=false;
        $('#chartContainer').html('');
        $scope.slaveId = "";
        $scope.fullname = "";
        $scope.slaveId = id;
        $scope.fullname = name + ' ' + lastname + ' ' + middlename;
    };

    $scope.slaveReport = function () {
        $scope.Dreport=false;
        $('#chartContainer').html('');


        var statuses = {
            status1: {name: "Утверждение вертски", items: []},
            status2: {name: "Разработка проекта", items: []},
            status3: {name: "Тестирование проекта", items: []},
            status4: {name: "Утверждение дизайна", items: []},
            status5: {name: "Дизайн", items: []}
        };

        $http({
            method: 'GET',
            url: '/?route=programmer&action=get-stat-slave&to='+ $scope.slaveTo +'&do='+ $scope.slaveDo +'&slave=' +$scope.slaveId
        }).then(function success(response) {

            if(response.data[0].company.count > 0) {
                var arrayOfResponse = response.data[0].company.data;
                var data = [];
                $.each(arrayOfResponse, function (key, val) {
                    if(val.status === "15") {
                        statuses.status1['items'].push(val);
                    } else if (val.status === "16") {
                        statuses.status2['items'].push(val);
                    } else if (val.status === "17") {
                        statuses.status3['items'].push(val);
                    } else if (val.status === "13") {
                        statuses.status4['items'].push(val);
                    } else if (val.status === "12") {
                        statuses.status5['items'].push(val);
                    }
                });

                $.each(statuses, function (key, val) {
                    if(val['items'].length !== 0) {
                        data.push({  y: val['items'].length, legendText:val['name'] + "("+ val['items'].length +")", indexLabel: val['name'] });
                    }
                });
                makeChart('chartContainer', $scope.fullname, data);

            } else {
                var data = [{  y: 100, legendText: 'У пользователя нет данных', indexLabel: 'У пользователя нет данных' }];
                makeChart('chartContainer', $scope.fullname, data);
            }

        }, function error(response) {});

    };

    // ============================================================================================================
    // Reports tab, END
    // ============================================================================================================



});



//Search Slaves

programmer.directive('searchSlaves', function ($http) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.bind('keyup', function (event) {
                var inputText = event.target.value;
                if(inputText.length < 3) {
                    $http({
                        method: 'GET',
                        url: '/?route=helper&action=search-all-my-slave&value='
                    }).then(function success(response) {
                        scope.report = response.data;
                    }, function error(response) {});
                } else if(inputText.length >= 3) {
                    $http({
                        method: 'GET',
                        url: '/?route=helper&action=search-all-my-slave&value=' + inputText
                    }).then(function success(response) {
                        scope.report = response.data;
                    }, function error(response) {});
                }
            });
        }
    };
});

programmer.directive('baseTemplate', function () {
    return {
        templateUrl: '/resources/programmer/html/base-template.html',
        restrict: 'E',
        link: function (scope, element, attrs) {

        }
    };
});

programmer.directive('reportsModal', function () {
    return {
        templateUrl: '/resources/programmer/html/reports-modal.html',
        restrict: 'E',
        link: function (scope, element, attrs) {

        }
    };
});


// GET Project Details
programmer.directive('getProjectDetail', function ($http, $templateRequest, $sce, $compile) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.bind('click', function() {
                    $http({
                        method: 'POST',
                        url: '/programmer/projects/editDeveloper',
                        data: { id: attrs.getProjectDetail }
                    }).then(function success(response) {
                        scope.projectDetails(attrs.getProjectDetail);

                    }, function error() {});
                });
            }
        };
    }
);

programmer.directive('addComment', ['$http', '$compile', function ($http, $compile) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind('click', function (e) {
                e.preventDefault();

                var data = {
                    projectId: attrs.addComment,
                    comments: scope.addedComment
                };

                $http({
                    method:'POST',
                    url: '/?route=programmer&action=edit-comment',
                    data: data
                }).then(function success(response) {
                    if(response.data !== 'false') {
                        scope.getProjectComments(attrs.addComment);
                        scope.addedComment = '';
                    }
                }, function error(response) {});
            });
        }
    };
}]);

programmer.directive('ideaPopup', function($http) {
    return {
        restrict: 'E',
        templateUrl: '/resources/programmer/html/idea-popup.html',
        link: function(scope, element, attr) {
            scope.ideaPopupShow = false;

            scope.ideaSubmit = function() {
                $http({
                    method: 'POST',
                    url: '/?route=future&action=add-idea',
                    data: scope.ideaData
                }).then(function access(response) {
                    $('#ideaModal').modal('toggle');
                    scope.ideaData = {};
                }, function error(response) {});
            }
        }
    }
});

programmer.directive('dreamPopup', function($http) {
    return {
        restrict: 'E',
        templateUrl: '/resources/programmer/html/dream-popup.html',
        link: function(scope, element, attr) {
            scope.dreamPopupShow = false;

            scope.dreamSubmit = function() {
                $http({
                    method: 'POST',
                    url: '/?route=future&action=add-dream',
                    data: scope.dreamData
                }).then(function access(response) {
                    $('#dereamModal').modal('toggle');
                    scope.dreamData = {};
                }, function error(response) {});
            }
        }
    }
});

programmer.directive('uploadFiles', ['$compile', function ($compile) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.click(function () {
                angular.element('#' + attrs.uploadFiles).val('');
                angular.element('#' + attrs.uploadFiles).click();
            });
        }
    }
}]);

programmer.service('fileUpload', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl, callback){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        }).success(function(response){
            if(response) {
                callback(response);
            }
        }).error(function(response){});
    }
});


programmer.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function(e){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                    scope.uploadFilePreview = (e.srcElement || e.target).files[0];
                    scope.getFile(scope.uploadFilePreview);
                });
            });
        }
    };
}]);

programmer.directive('errSrc', function() {
    return {
        link: function(scope, element, attrs) {
            element.bind('error', function() {
                if (attrs.src !== attrs.errSrc) {
                    attrs.$set('src', attrs.errSrc);
                    element.bind('error', function() {
                        if (attrs.src !== attrs.errSrc1) {
                            attrs.$set('src', attrs.errSrc1);
                        }
                    });
                }
            });
        }
    }
});

programmer.run(function($rootScope, $templateCache) {
    $rootScope.$on('$viewContentLoaded', function() {
        $templateCache.removeAll();
    });
});

