<div class="cmsadmin" ng-controller="NavController" ng-show="!isDeleted" ng-init="settingsOverlay=true">

	<modal is-modal-hidden="settingsOverlay" title="Settings">
		<div class="card text-center">
		  <div class="card-header">
		    <ul class="nav nav-tabs card-header-tabs">
		      <li class="nav-item">
		        <a class="nav-link active" href="#">Active</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li>
		    </ul>
		  </div>
		  <div class="card-block">
		    <h4 class="card-title">Special title treatment</h4>
		    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
		    <a href="#" class="btn btn-primary">Go somewhere</a>
		  </div>
		</div>
	</modal>
        <? if(isset($_GET['preview'])): ?>
        <div class="row">
            <div class="col cmsadmin-frame-wrapper">
                <iframe src="http://demo.luya.io" class="cmsadmin-frame"></iframe>
            </div>
            <div class="col">
        <? endif; ?>
                <div class="row">
                    <div class="col">
                        <div class="cmsadmin-toolbar">
                            <div class="toolbar-item">
                                <label class="switch" for="switch-visibility-status">
                                	<span class="switch__label">
                                        <i class="material-icons" ng-show="!navData.is_hidden">visibility</i>
                                        <i class="material-icons" ng-show="navData.is_hidden">visibility_off</i>
                                    </span>
                                    <span class="switch__switch">
                                        <input class="switch__checkbox"  ng-model="navData.is_hidden" ng-true-value="0" ng-false-value="1" type="checkbox" id="switch-visibility-status"/>
                                        <span class="switch__control"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="toolbar-item">
                                <label class="switch" for="switch-online-status">
                                    <span class="switch__label">
                                        <i class="material-icons" ng-show="!navData.is_offline">cloud_queue</i>
                                        <i class="material-icons" ng-show="navData.is_offline">cloud_off</i>
                                    </span>
                                    <span class="switch__switch">
                                        <input class="switch__checkbox" type="checkbox" id="switch-online-status" ng-model="navData.is_offline" ng-true-value="0" ng-false-value="1"/>
                                        <span class="switch__control"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="toolbar-item" ng-class="{'ml-auto':$first}" ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)">
                                <button class="toolbar-button toolbar-button-flag" ng-class="{'active' : AdminLangService.isInSelection(lang.short_code)}" >
                                    <span class="flag flag--{{lang.short_code}}">
                                        <span class="flag__fallback">{{lang.name}}</span>
                                    </span>
                                </button>
                            </div>
                            <div class="toolbar-item" ng-click="settingsOverlay=!settingsOverlay">
                                <button class="toolbar-button">
                                    <i class="material-icons">more_vert</i>
                                </button>
                            </div>
                        </div>
                        <div class="cmsadmin-pages">
                            <div class="row">
                                <div class="col" ng-repeat="lang in languagesData" ng-if="AdminLangService.isInSelection(lang.short_code)" ng-controller="NavItemController">
                                    <?= $this->render('_navitem'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col blockholder-column" ng-controller="DroppableBlocksController">
                        <div class="blockholder">
                            <div class="blockholder-search">
                                <input class="blockholder-search-input" id="blockholder-search" ng-model="searchQuery" />
                                <label class="blockholder-search-label" for="blockholder-search">
                                    <i class="material-icons">search</i>
                                </label>
                            </div>
                            <div class="blockholder-group blockholder-group-favorites" ng-repeat="item in blocksData | orderBy:'groupPosition'" >
                                <span class="blockholder-group-title">
                                    <i class="material-icons" ng-if="item.group.is_fav">favorite</i>
                                    <span>{{item.group.name}}</span>
                                </span>
                                <ul class="blockholder-list">
                                    <li class="blockholder-item" ng-repeat="block in item.blocks | orderBy:'name' | filter:{name:searchQuery}">
                                        <i class="material-icons blockholder-icon">{{block.icon}}</i>
                                        <span>{{block.name}}</span>

                                        <button class="blockholder-favorite" ng-click="addToFav(block)" ng-if="!item.group.is_fav && !block.favorized">
                                            <i class="material-icons">favorite</i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        <? if(isset($_GET['preview'])): ?>
            </div>
        </div>
         <? endif; ?>
</div>