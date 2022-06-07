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
         return User::with('dapartemen', 'role', 'RoleUser.role', 'store')->find($id);
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

    public function update($data, $id)
    {
        return $this->users->where('id', $id)->update($data);
    }

    public function getDetail(){

        $data = DB::table('users')
        ->join('dapartemen', 'users.dapartemen_id', '=', 'dapartemen.id')
        ->join('regions', 'users.region_id', '=', 'regions.id')
        ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.id as user_id',
            'dapartemen.id as dapartemen_id',
            'regions.id as region_id',
            'roles.id as role_id',
            'dapartemen.dapartemen',
            'regions.name as region_name',
            'roles.display_name',
            'users.created_at',
            'users.username',
            'users.name',
            'users.all_store'
        );

        return $data;
    }

    public function finId($id){
        return $this->all()->where('id', $id);
    }

    public function findRoleUser($RoleId){
        return $this->all()->where('role_id', $RoleId);
    }

    public function getUserNotAllStore(){
        return $this->getDetail()->where('users.all_store', 'n')->where('role_id', '!=', null);
    }

    public function getUserAreaKordinator(){
        return $this->getDetail()->where('role_id', '!=', null)->where('role_id', 2);
    }

}
