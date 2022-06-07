<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPost;
use App;
use App\Helper\MyHelper;
use App\Services\Support\userService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $userService;

    public function __construct(userService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view ('rbac.user.index');
    }

    public function dt()
    {
        $users = userService::all();

        return DataTables::of($users)
            ->addColumn('action', function ($model) {
                $actions = [
                    [
                        'onclick' => 'editForm(' . $model->id . ')',
                        'class' => 'btn_edit',
                        'label' => 'Edit',
                        'icon' => 'fas fa-edit',
                        'can' => 'update-user'
                    ],
                    [
                        'onclick' => 'deleteData(' . $model->id . ')',
                        'class' => 'btn_edit',
                        'label' => 'Delete',
                        'icon' => 'fas fa-edit',
                        'can' => 'delete-user'
                    ],
                    [
                        'url' => route('user_store.index') . '?user_id=' . $model->id,
                        'class' => 'btn_store',
                        'label' => 'Store',
                        'icon' => 'fas fa-store',
                    ]
                ];
                return view('component.action-button')
                    ->with('id', $model->id)
                    ->with('actions', $actions);
            })->make(true);
    }

    public function create()
    {

    }

    public function store(UserPost $request)
    {
        DB::beginTransaction();

        try {

            $user = userService::saveData($request->except('_token'));

            $role = App\Role::find($request->role_id);

            $user->attachRole($role);

            DB::commit();

            $output = [
                'icon' => 'success',
                'text' => "User {$request->name} added succesfully",
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = userService::find($id);

        return $user;
    }

    public function update(UserPost $request, $id)
    {
        DB::beginTransaction();

        try {

            userService::updateData($request->except('_token', '_method'), $id);

            $user = App\User::find($id);

            $user->syncRoles([$request->role_id]);

            DB::commit();

            $output = [
                'icon' => 'success',
                'text' => "User {$request->name} updated succesfully",
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

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $user = userService::deleteData($id);

            DB::commit();

            $output = [
                'icon' => 'success',
                'text' => "Data deleted succesfully",
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

    public function selectLecturer(Request $request)
    {
        $role = DB::table('users')->select('*');
        $role->join('role_user', 'users.id', '=', 'role_user.user_id');
        $role->where('role_user.role_id', '=', 4);

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
