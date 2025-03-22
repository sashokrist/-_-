<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\HairstylistServiceInterface;
use Illuminate\Http\Request;

class HairstylistController extends Controller
{
    protected HairstylistServiceInterface $hairstylistService;

    public function __construct(HairstylistServiceInterface $hairstylistService)
    {
        $this->hairstylistService = $hairstylistService;
    }

    public function index()
    {
        return view('hairstylists.index', [
            'hairstylists' => $this->hairstylistService->all()
        ]);
    }

    public function show($id)
    {
        return view('hairstylists.show', [
            'hairstylist' => $this->hairstylistService->find($id)
        ]);
    }

    public function store(Request $request)
    {
        $this->hairstylistService->create($request->all());
        return redirect()->route('hairstylists.index')->with('success', 'Hairstylist created successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->hairstylistService->update($id, $request->all());
        return redirect()->route('hairstylists.index')->with('success', 'Hairstylist updated successfully.');
    }

    public function destroy($id)
    {
        $this->hairstylistService->delete($id);
        return redirect()->route('hairstylists.index')->with('success', 'Hairstylist deleted successfully.');
    }
}
