<?php

namespace cmstests\src\widgets;

use cmstests\data\modules\CmsUrlRuleModule;
use luya\cms\models\NavItem;
use luya\cms\widgets\LangSwitcher;
use luya\testsuite\cases\WebApplicationTestCase;
use luya\testsuite\traits\CmsDatabaseTableTrait;

class LangSwitcherSqliteTest extends WebApplicationTestCase
{
    use CmsDatabaseTableTrait;

    public function getConfigArray()
    {
        return [
            'id' => 'ngresttest',
            'basePath' => dirname(__DIR__),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'menu' => 'luya\cms\Menu',
                'composition' => [
                    'default' => ['langShortCode' => 'de']
                ]
            ],
            'modules' => [
                'admin' => 'luya\admin\Module',
                'cmsurlrulemodule' => [
                    'class' => CmsUrlRuleModule::class,
                ]
            ]
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testSetUrlRuleParamsForI18nSlugUrlRules()
    {
        $langFixture = $this->createAdminLangFixture([
            'de' => [
                'id' => 1,
                'short_code' => 'de',
                'is_default' => 1,
                'is_deleted' => 0,
            ],
            'en' => [
                'id' => 2,
                'short_code' => 'en',
                'is_default' => 0,
                'is_deleted' => 0,
            ]
        ]);

        $this->createCmsNavContainerFixture([
            1 => [
                'id' => 1,
                'name' => 'default',
                'alias' => 'default',
            ]
        ]);

        $navFixture = $this->createCmsNavFixture([
            1 => [
                'id' => 1,
                'is_home' => 1,
                'is_hidden' => 0,
                'is_offline' => 0,
                'nav_container_id' => 1,
                'parent_nav_id' => 0,
                'is_draft' => 0,
                'is_deleted' => 0,
            ]
        ]);

        $navItem = $this->createCmsNavItemFixture([
            1 => [
                'id' => 1,
                'nav_id' => 1,
                'lang_id' => 1,
                'title' => 'de',
                'alias' => 'de-slug',
                'nav_item_type' => NavItem::TYPE_MODULE,
                'nav_item_type_id' => 1,
            ],
            2 => [
                'id' => 2,
                'nav_id' => 1,
                'lang_id' => 2,
                'title' => 'en',
                'alias' => 'en-slug',
                'nav_item_type' => NavItem::TYPE_MODULE,
                'nav_item_type_id' => 1,
            ]
        ]);

        $this->createCmsNavItemModuleFixture([
            1 => [
                'id' => 1,
                'module_name' => 'cmsurlrulemodule',
            ],
        ]);

        $x = $this->app->menu->getLanguageContainer('en');

        $this->app->menu->currentUrlRule = [
            'route' => 'go/there',
            'params' => [
                'slug' => 'default',
            ],
        ];

        LangSwitcher::setUrlRuleParam('en', 'slug', 'enslug');
        
        $switcher = LangSwitcher::widget();

        $this->assertContains('slug=default', $switcher);
        $this->assertContains('slug=enslug', $switcher);
    }
}