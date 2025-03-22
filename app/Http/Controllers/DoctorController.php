<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\DoctorServiceInterface;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    protected DoctorServiceInterface $doctorService;

    public function __construct(DoctorServiceInterface $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        return view('doctors.index', [
            'doctors' => $this->doctorService->all()
        ]);
    }

    public function show($id)
    {
        return view('doctors.show', [
            'doctor' => $this->doctorService->find($id)
        ]);
    }

    public function store(Request $request)
    {
        $this->doctorService->create($request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->doctorService->update($id, $request->all());
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy($id)
    {
        $this->doctorService->delete($id);
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
