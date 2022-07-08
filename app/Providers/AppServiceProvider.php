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
                'icon' => 'fas fa-layer-group',
                'permission' => 'form',
                'submenu' => [
                    [
                        'text' => 'Pembuatan ID',
                        'url' => route('form-pembuatan.index'),
                        'icon' => 'fas fa-file-alt',
                        'active' => ['form-pembuatan.index*'],
                        'permission' => 'form-pembuatan',
                    ],
                    [
                        'text' => 'Penghapusan ID',
                        'url' => route('form-penghapusan.index'),
                        'icon' => 'fas fa-file-alt',
                        'active' => ['form-penghapusan*'],
                        'permission' => 'form-penghapusan',
                    ],
                    [
                        'text' => 'Pemindahan ID',
                        'url' => route('form-pemindahan.index'),
                        'icon' => 'fas fa-file-alt',
                        'active' => ['form-pemindahan*'],
                        'permission' => 'form-pemindahan',
                    ],

                ],
            ]);

            $event->menu->add([
                'text' => 'Approval',
                'icon' => '	fas fa-file-signature',
                'permission' => 'approval',
                'submenu' => [
                    [
                        'text' => 'Pembuatan ID',
                        'url' => route('approval-pembuatan.index'),
                        'icon' => 'fas fa-file-signature',
                        'active' => ['approval-pembuatan*'],
                        'permission' => 'approval-pembuatan',
                    ],
                    [
                        'text' => 'Penghapusan ID',
                        'url' => route('approval-penghapusan.index'),
                        'icon' => 'fas fa-file-signature',
                        'active' => ['approval-penghapusan*'],
                        'permission' => 'approval-penghapusan',
                    ],
                ],
            ]);

            $event->menu->add([
                'text' => 'User',
                'icon' => 'fas fa-users',
                'permission' => 'auth',
                'submenu' => [
                    [
                        'text' => 'Management',
                        'url' => route('management.index'),
                        'icon' => '	fas fa-user-edit',
                        'active' => ['management*'],
                        'permission' => 'auth'
                    ],
                    [
                        'text' => 'Role',
                        'url' => route('role.index'),
                        'icon' => 'fas fa-user-shield',
                        'active' => ['role*'],
                        'permission' => 'auth'
                    ],
                    [
                        'text' => 'Store',
                        'url' => route('store.index'),
                        'icon' => 'fas fa-house-user',
                        'active' => ['store*'],
                        'permission' => 'auth'
                    ],
                    [
                        'text' => 'Register AK & BO',
                        'url' => route('back_register.index'),
                        'icon' => 'fas fa-user',
                        'active' => ['register*'],
                        'permission' => 'auth'
                    ],
                ],
            ]);
        });
    }
}
