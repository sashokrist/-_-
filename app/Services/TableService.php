<?php

namespace App\Services;

use App\Services\Contracts\TableServiceInterface;
use App\Models\Table;

class TableService implements TableServiceInterface
{
    public function all()
    {
        return Table::all();
    }

    public function find($id)
    {
        return Table::findOrFail($id);
    }

    public function create(array $data)
    {
        return Table::create($data);
    }

    public function update($id, array $data)
    {
        $table = Table::findOrFail($id);
        $table->update($data);
        return $table;
    }

    public function delete($id)
    {
        $table = Table::findOrFail($id);
        return $table->delete();
    }

    public function list()
    {
        return Table::all();
    }

    public function show($id)
    {
        return Table::findOrFail($id);
    }
}
