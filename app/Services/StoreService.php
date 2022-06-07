<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
	private $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

	public function all()
	{
		return Store::query()->with('region');
	}
    public function store($data)
    {
        return $this->store::create($data);
    }

    public function find($id)
    {
        return $this->all()->where('id', $id);
    }

    public function getById($storeId)
    {
        return $this->all()->where('id', $storeId);
    }
}
