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
                        'active' => [route('form-pembuatan.index').'/*',route('form-pembuatan.create')],
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
                    [
                        'text' => 'Pemindahan ID',
                        // 'url' => route('approval-pemindahan.index'),
                        'icon' => 'fas fa-file-signature',
                        'active' => ['approval-pemindahan*'],
                        'permission' => 'approval-pemindahan',
                    ],

                ],
            ]);

            $event->menu->add([
                'text' => 'Aplikasi',
                'icon' => '	fas fa-server',
                'permission' => 'rj-server-status',
                'submenu' => [
                    [
                        'text' => 'Rj Server',
                        'url' => route('rj_server.index'),
                        'icon' => '	far fa-square',
                        'active' => ['rj_server*'],
                        'permission' => 'rj-server-status',
                    ],
                    [
                        'text' => 'Vega',
                        'url' => route('vega.index'),
                        'icon' => '	far fa-square',
                        'active' => ['vega*'],
                        'permission' => 'auth',
                    ],
                    [
                        'text' => 'RRAK',
                        // 'url' => route('vega.index'),
                        'icon' => '	far fa-square',
                        // 'active' => ['vega*'],
                        'permission' => 'auth',
                    ],
                    [
                        'text' => 'BAP',
                        // 'url' => route('vega.index'),
                        'icon' => '	far fa-square',
                        // 'active' => ['vega*'],
                        'permission' => 'auth',
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
