<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Alert;

use App\Helper\MyHelper;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('rbac.permission.index');
    }


    public function dt()
    {
        $permissions = App\Permission::all();

        return DataTables::of($permissions)
                ->addColumn('action', function ($permissions) {
                    return '
                    <a href="#" style="padding-left:10px;" class="" data-toggle="tooltip" data-placement="top" title="Edit data"><i class="fa fa-edit fa-lg"></i></a>
                    ';
                })->make(true);

    }

    public function store(Request $request)
    {
        // App\Permission::create([
        //     'name' => 'create-post',
        //     'display_name' => 'Create Posts',
        //     'description' => 'Create new blog posts'
        // ]);

        // $user = App\User::find(1);
        // $role = App\Role::find(1);

        // $user->attachRole($role);

        try {
        //    $permission = App\Permission::create($request->except('_token', '_method'));

            $output = [
                'text' => 'sukses',
            ];
        } catch (\Throwable $th) {
            $output = [
                'text' => $th->getMessage(),
            ];
        }

        return MyHelper::toastNotification(['text' => 'Sukses']);

        // return redirect()->route('permission.index');
    }
}
