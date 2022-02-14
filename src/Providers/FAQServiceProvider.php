<?php

namespace Azuriom\Plugin\FAQ\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\FAQ\Models\Question;
use Illuminate\Database\Eloquent\Relations\Relation;

class FAQServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'faq.admin' => 'faq::admin.permission',
        ]);

        Relation::morphMap(['faq.questions' => Question::class]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'faq.index' => trans('faq::messages.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'faq' => [
                'name' => trans('faq::admin.title'),
                'icon' => 'fas fa-question-circle',
                'permission' => 'faq.admin',
                'route' => 'faq.admin.questions.index',
            ],
        ];
    }
}
