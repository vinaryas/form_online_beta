<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'text' => 'Dashboard',
                'url' => route('home'),
                'icon' => 'fas fa-home',
                'active' => [route('home')],
                'permission' => 'dashboard'
            ]);

            $event->menu->add([
                'text' => 'Form',
                'url' => route('form.index'),
                'icon' => 'fas fa-file-invoice',
                'active' => [route('form.index').'/*',route('form.create')],
                'permission' => 'dashboard',
            ]);

            $event->menu->add([
                'text' => 'Approval',
                'url' => route('approval.index'),
                'icon' => 'fas fa-file-invoice',
                'active' => [route('approval.index').'/*'],
                'permission' => 'approval',
            ]);

            $event->menu->add([
                'text' => 'User',
                'icon' => 'fas fa-user',
                'permission' => 'auth',
                'submenu' => [
                    [
                        'text' => 'Role',
                        'url' => route('role.index'),
                        'icon' => 'fas fa-user-tag',
                        'active' => ['role*'],
                        'permission' => 'auth'
                    ],
                    [
                        'text' => 'Store',
                        'url' => route('store.index'),
                        'icon' => 'fas fa-user-tag ',
                        'active' => ['store*'],
                        'permission' => 'auth'
                    ],
                ],
            ]);
        });
    }
}
