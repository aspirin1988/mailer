<div id="wrapper" ng-controller="programmerCtrl">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="top-block black clearfix">
                <div>
                    <img class="img-circle pull-left" src="/images/users/darth-vader.jpg">
                    <p class="nick">Alo</p>
                    <p>Alo</p>
                </div>
                <hr>
                <div class="pull-right ">
                    <button onclick="window.location.href='/?route=auth&action=logoff'" class="btn btn-default">
                        <span class="glyphicon glyphicon-log-out"></span>
                    </button>
                </div>
            </li>
        </ul>
    </div>
    <!-- End Sidebar -->

    <div id="page-content-wrapper">
        <header class="black pageheader clearfix">
            <span id="menu-toggle" class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            <h2>{{locale.Header_Description_programmer}}</h2>
            <div class="pull-right dropdown">
                <span class="glyphicon glyphicon-cloud hidden-xs"  data-toggle="modal" data-target="#dereamModal"></span>
                <span class="glyphicon glyphicon-tree-deciduous hidden-xs"  data-toggle="modal" data-target="#ideaModal"></span>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><p><a role="menuitem" tabindex="-1" href="#">Закоммититься</a></p></li>
                    <li role="presentation"><p><a role="menuitem" tabindex="-1" href="#">Отрефакторить говнокод</a></p></li>
                    <li role="presentation"><p><a role="menuitem" tabindex="-1" href="#">Перейти с Семантака на Бутстрап</a></p></li>
                </ul>
            </div>
        </header>
        <base-template></base-template>

        <div class="modal fade" id="ideaModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <idea-popup></idea-popup>
            </div>
        </div>
        <div class="modal fade" id="dereamModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <dream-popup></dream-popup>
            </div>
        </div>
        <div class="modal fade" id="reportsModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <reports-modal></reports-modal>
            </div>
        </div>

        <popup-dialog></popup-dialog>
    </div>
</div>