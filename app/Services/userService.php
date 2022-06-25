<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userService
{
    private $users;

    public function __construct(User $register)
     {
         $this->users = $register;
     }

     public function data($data)
     {
         return [
                 'name' => $data['name'],
                 'username' => $data['username'],
                 'email' => $data['email'],
                 'password' => Hash::make($data['password'])
         ];
     }

     public function all()
     {
         return User::query()->with('role', 'stores');
     }

     public function saveData($data)
     {
         $user = User::create($this->data($data));

         return $user;
     }

     public function updateData($data, $id)
     {
         $user = User::where('id', '=', $id)->update($this->data($data));
     }

     public function deleteData($id)
     {
         $user = User::where('id', '=', $id)->delete();

         return $user;
     }

     public function find($id)
     {
         return User::with('role', 'RoleUser.role', 'store')->find($id);
     }

     public function authStoreArray()
     {
         $stores = [];
         foreach (Auth::user()->stores as $store) {
             $stores[] = $store->id;
         }

         return $stores;
     }

    public function store($data)
    {
        return $this->users->create($data);
    }

    public function finId($id){
        return $this->all()->where('id', $id);
    }

    public function update($data, $id)
    {
        return $this->users->where('id', $id)->update($data);
    }

    public function getDetail(){

        $data = DB::table('users')
        ->leftjoin('stores', 'users.store_id', '=', 'stores.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.id as user_id',
            'users.created_at',
            'users.username',
            'users.name',
            'users.all_store',
            'users.role_id',
            'users.store_id',
            'stores.id as store_id',
            'stores.name as store',
            'regions.id as region_id',
            'regions.name as region_name',
            'roles.id as role_id',
            'roles.display_name',
        );

        return $data;
    }

    public function getUserStore($userStore){
        return $this->getDetail()
        ->where('users.role_id', config('setting_app.role_id.kasir'))
        ->where('users.store_id', $userStore);
    }

    public function getById($userId){
        return $this->getDetail()->where('users.id', $userId);
    }

    public function findRoleUser($RoleId){
        return $this->all()->where('role_id', $RoleId);
    }

    public function getUserNotAllStore(){
        return $this->getDetail()->where('users.all_store', 'n')->where('role_id', '!=', null);
    }

    public function getUser(){
        return $this->getDetail()
        ->where('role_id', '!=', config('setting_app.role_id.it'))
        ->where('role_id', '!=', config('setting_app.role_id.bo'))
        ->where('role_id', '!=', config('setting_app.role_id.admin'));
    }
}
