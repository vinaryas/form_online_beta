<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Rbac\RoleService as RoleService;
use App\Services\userService;
use App\Http\Requests\RolePost;
use App;
use App\Helper\MyHelper;
use Illuminate\Support\Facades\DB;
use Laratrust;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('rbac.role.index');
    }

    public function dt()
    {
        $roles = App\Role::all();

        // return DataTables::of($roles)
        //         ->addColumn('action', function ($roles) {
        //             $hideEdit = (Laratrust::isAbleTo('update-role')) ? '' : 'd-none';
        //             $hidePermission = (Laratrust::isAbleTo('update-role-pms')) ? '' : 'd-none';

        //             return '
        //             <button type="button" href="#" onClick="editForm(' . $roles->id . ')" style="margin-left:5px;" class="btn btn-success btn-xs btn-flat ' . $hideEdit . '" data-toggle="tooltip" data-placement="top" title="Edit data"><i class="fa fa-edit fa-xs"></i></button>
        //             <button type="button" href="#" onClick="editPermission(' . $roles->id . ')" style="" class="btn btn-success btn-xs btn-flat ' . $hidePermission . '" data-toggle="tooltip" data-placement="top" title="Edit permission"><i class="fas fa-tasks fa-xs"></i></button>
        //             ';
        //         })->make(true);


        return DataTables::of($roles)
            ->addColumn('action', function ($model) {
                $actions = [
                    [
                        'onclick' => 'editForm(' . $model->id . ')',
                        'class' => 'btn_edit',
                        'label' => 'Edit',
                        'icon' => 'fas fa-edit',
                        'can' => 'update-role'
                    ],
                    [
                        'onclick' => 'editPermission(' . $model->id . ')',
                        'class' => 'btn_edit',
                        'label' => 'Permission',
                        'icon' => 'fas fa-edit',
                        'can' => 'update-role-pms'
                    ]
                ];
                return view('component.action-button')
                    ->with('id', $model->id)
                    ->with('actions', $actions);
            })->make(true);
    }

    public function store(RolePost $request, RoleService $roleService)
    {
        DB::beginTransaction();

        try {

            $role = $roleService->saveData($request->except('_token'));

            DB::commit();

            $output = [
                'icon' => 'success',
                'text' => "Role {$request->name} added succesfully",
            ];
        } catch (\Throwable $th) {
            DB::rollback();

            $output = [
                'icon' => 'error',
                'text' => $th->getMessage(),
            ];
        }

        return MyHelper::toastNotification($output);

    }

    public function edit($id)
    {
        $role = App\Role::find($id);

        return $role;
    }

    public function update(RolePost $request, RoleService $roleSerivce, $id)
    {
        DB::beginTransaction();

        try {

            $roleSerivce->updateData($request->except('_token', '_method'), $id);

            DB::commit();

            $output = [
                'icon' => 'success',
                'text' => "Role {$request->name} updated succesfully",
            ];
        } catch (\Throwable $th) {
            DB::rollback();

            $output = [
                'icon' => 'error',
                'text' => $th->getMessage(),
            ];
        }

        return MyHelper::toastNotification($output);
    }

    public function select2(Request $request, userService $userService)
    {
        $roleId = ($userService->isAdministrator()) ? 0 : 1;

        $role = DB::table('roles')->select('*');
        $role->where('id', '>', $roleId);

        if (!empty(trim($request->input))) {
            $role->where(function($input)use($request){
                $input->where('name','LIKE','%'.trim($request->input).'%');
            });
        }

        $tag = [];
        foreach ($role->get() as $index => $value) {
            $tag[] = ['id' => $value->id, 'text' => ($value->id . ' - ' . $value->name)];
        }

        return response()->json($tag);
    }
}
