<?php

namespace App\Services;

use App\Services\Contracts\HairstylistServiceInterface;
use App\Models\Hairstylist;

class HairstylistService implements HairstylistServiceInterface
{
    public function all()
    {
        return Hairstylist::all();
    }

    public function find($id)
    {
        return Hairstylist::findOrFail($id);
    }

    public function create(array $data)
    {
        return Hairstylist::create($data);
    }

    public function update($id, array $data)
    {
        $hairstylist = Hairstylist::findOrFail($id);
        $hairstylist->update($data);
        return $hairstylist;
    }

    public function delete($id)
    {
        $hairstylist = Hairstylist::findOrFail($id);
        return $hairstylist->delete();
    }

    public function list()
    {
        return Hairstylist::all();
    }

    public function show($id)
    {
        return Hairstylist::findOrFail($id);
    }
}
