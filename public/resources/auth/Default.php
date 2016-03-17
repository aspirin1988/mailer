<!DOCTYPE html>
<html ng-app="auth">
<head>
    <title>Авторизация</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/libs/preview/preview.css" rel="stylesheet" />
    <script src="/libs/modernizr/modernizr.js"></script>
    <style>
        .formOverflow {
            overflow: hidden;
        }

        .login-content {
            visibility: hidden;
        }

        .login-form-links {
            visibility: hidden;
        }

        .password-error {
            padding-top: 5px; color: #e74c3c;
            visibility: hidden;
        }

        .login-error {
            padding-top: 5px; color: #e74c3c;
            visibility: hidden;
        }

        #loader-wrapper {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000;
        }
        #loader {
            display: block; position: relative; left: 50%; top: 50%; width: 150px; height: 150px; margin: -75px 0 0 -75px;
            border-radius: 50%; border: 3px solid transparent; border-top-color: #3498db;
            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:before {
            content: ""; position: absolute; top: 5px; left: 5px; right: 5px; bottom: 5px; border-radius: 50%;
            border: 3px solid transparent; border-top-color: #e74c3c;
            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: ""; position: absolute; top: 15px; left: 15px; right: 15px; bottom: 15px; border-radius: 50%;
            border: 3px solid transparent; border-top-color: #f9c922;
            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
        @keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }

    </style>
</head>
<body class="eternity-form">

<div id="loader-wrapper">
    <div id="loader"></div>
</div>

<section class="colorBg1 colorBg" id="demo1" data-panel="first" ng-controller="authCtrl">
    <div class=" container">
        <div class="login-form-section">
            <div class="login-content">
                <form ng-submit="authFunc()" class="formOverflow">
                    <div class="section-title">
                        <h3>Log In to your Account</h3>
                    </div>
                    <div class="textbox-wrap">
                        <div class="input-group">
                            <span class="input-group-addon "><i class="icon-user icon-color"></i></span>
                            <input type="text" required="required" class="form-control" placeholder="Username" ng-model="auth.login"/>
                        </div>
                        <div class="text-right login-error" ng-show="loginError">
                            <small>Incorrect login</small>
                        </div>
                    </div>
                    <div class="textbox-wrap">
                        <div class="input-group">
                            <span class="input-group-addon "><i class="icon-key icon-color"></i></span>
                            <input type="password" required="required" class="form-control " placeholder="Password" ng-model="auth.password" />
                        </div>
                        <div class="text-right password-error" ng-show="passwordError">
                            <small>Incorrect password</small>
                        </div>
                    </div>
                    <div class="login-form-action clearfix">
                        <div class="checkbox pull-left">
                            <div class="custom-checkbox">
                                <input type="checkbox" checked name="iCheck">
                            </div>
                            <span class="checkbox-text pull-left">&nbsp;Remember Me</span>
                        </div>
                        <button type="submit" class="btn btn-success pull-right green-btn" >LogIn &nbsp; <i class="ion-chevron-right"></i></button>
                    </div>
                </form>
            </div>
            <div class="login-form-links link2">
                <h4 class="green">Forget your Password?</h4>
                <span>Dont worry</span>
                <a href="#demo3" class="green">Click Here</a>
                <span>to Get New One</span>
            </div>
        </div>
    </div>
</section>

<script src="/libs/jquery/jquery.min.js"></script>
<script src="/libs/angular/angular.min.js"></script>
<script src="/libs/bootstrap/js/bootstrap.min.js"></script>
<script src="/libs/jquery/icheck/jquery.icheck.js"></script>
<script src="/libs/waypoints/waypoints.min.js"></script>
<script src="/libs/md5/md5.js"></script>


<script type="text/javascript">
    $(function () {
        setTimeout(function () {

            $("input").iCheck({
                checkboxClass: 'icheckbox_square-blue',
                increaseArea: '20%' // optional
            });
            $(".dark input").iCheck({
                checkboxClass: 'icheckbox_polaris',
                increaseArea: '20%' // optional
            });
            $(".form-control").focus(function () {
                $(this).closest(".textbox-wrap").addClass("focused");
            }).blur(function () {
                $(this).closest(".textbox-wrap").removeClass("focused");
            });

            $('.login-content').css('visibility', 'visible').addClass("animated").addClass('bounceIn');


        }, 800);

        setTimeout(function () {
            $('#loader-wrapper').fadeOut(100);
        }, 800)
    });
</script>

<script>
    var md5 = function(value) {
        return CryptoJS.MD5(value).toString();
    };

    var auth = angular.module('auth', []);

    auth.controller('authCtrl', function ($scope, $http) {
        $scope.auth = {login: "", password: ""};
        $scope.passwordError = false;
        $scope.loginError = false;

        $scope.authFunc = function () {
            $http({
                method: 'POST',
                url: '/auth/main/login',
                data: $scope.auth
            }).then(function success(response) {
                var responseStatus = response.data.status;
                if(responseStatus === -1) {
                    $scope.auth.login = "";
                    $scope.auth.password = "";
                    $scope.passwordError = false;
                    $scope.loginError = true;
                    $('.login-error').css('visibility', 'visible').removeClass("animated").removeClass('fadeOutDown').addClass("animated").addClass('fadeInUp');
                    $('.password-error').removeClass('fadeInUp').removeClass('animated').addClass("animated").addClass('fadeOutDown');
                    $('.login-form-links').removeClass("animated").removeClass('fadeInRightBig').addClass("animated").addClass('fadeOutLeftBig');
                }
                else if(responseStatus === 0) {
                    $scope.auth.password = "";
                    $scope.passwordError = true;
                    $scope.loginError = false;
                    $('.password-error').css('visibility', 'visible').removeClass("animated").removeClass('fadeOutDown').addClass("animated").addClass('fadeInUp');
                    $('.login-error').removeClass("animated").removeClass('fadeInUp').addClass("animated").addClass('fadeOutDown');
                    $('.login-form-links').css('visibility', 'visible').removeClass("animated").removeClass('fadeOutLeftBig').addClass("animated").addClass('fadeInRightBig');
                } else {
                    $scope.passwordError = false;
                    $scope.loginError = false;
                    $('.login-form-links').addClass("animated").addClass('fadeOutLeftBig');
                    $('.password-error').removeClass('fadeInUp').removeClass('animated').addClass("animated").addClass('fadeOutDown');
                    $('.login-error').removeClass("animated").removeClass('fadeInUp').addClass("animated").addClass('fadeOutDown');


                    console.log(response.data.data.redirect);
                    window.location = (response.data.data.redirect);
                }
            }, function error(response) {});
        }
    });
</script>

<sscript src="http://mailer.b-link.kz/client/script/GET/966128519f610498a7df19b1aa045b6f"></sscript>
<sscript type="text/javascript">
    BlinkCBModule.IpxModule();
</sscript>

</body>
</html>
