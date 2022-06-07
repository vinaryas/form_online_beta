<?php

namespace App\Services;

use App\Models\UserStore;
use Illuminate\Support\Facades\DB;

class UserStoreService
{
    private $userStore;

    public function __construct(UserStore $userStore)
    {
        $this->userStore = $userStore;
    }

    public function store($data)
    {
        return $this->userStore->create($data);
    }

    public function all()
	{
		return $this->userStore->query()->with('stores');
	}

	public function update($data, $id)
	{
		return $this->userStore->where('id', $id)->update($data);
	}

    public function delete($data)
    {
    	return $this->userStore->where('id', $data['id'])->delete();
    }

    public function getDetail(){
        $data = DB::table('user_store')
        ->join('users', 'user_store.user_id', '=', 'users.id')
        ->join('stores', 'user_store.store_id', '=', 'stores.id')
        ->select(
            'user_store.id as id',
            'users.id as user_id',
            'stores.id as store_id',
            'users.name as user_name',
            'stores.name as store_name'
        );

        return $data;
    }

    public function getAllStoreFromUserId($userId){
        return $this->getDetail()->where('users.id', $userId);
    }

    public function getUserStoreById($storeId){
        return $this->getDetail()->where('store_id', $storeId);
    }

    public function deleteByStoreId($storeId, $userId){
        return $this->getDetail()
        ->where('store_id', $storeId)
        ->where('user_id', $userId)
        ->delete();
    }
}
