<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\TableServiceInterface;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected TableServiceInterface $tableService;

    public function __construct(TableServiceInterface $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {
        return view('restaurant-tables.index', [
            'tables' => $this->tableService->all()
        ]);
    }

    public function show($id)
    {
        return view('restaurant-tables.show', [
            'table' => $this->tableService->find($id)
        ]);
    }

    public function store(Request $request)
    {
        $this->tableService->create($request->all());
        return redirect()->route('restaurant-tables.index')->with('success', 'Table created successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->tableService->update($id, $request->all());
        return redirect()->route('restaurant-tables.index')->with('success', 'Table updated successfully.');
    }

    public function destroy($id)
    {
        $this->tableService->delete($id);
        return redirect()->route('restaurant-tables.index')->with('success', 'Table deleted successfully.');
    }
}
