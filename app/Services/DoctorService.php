<?php

namespace App\Services;

use App\Services\Contracts\DoctorServiceInterface;
use App\Models\Doctor;

class DoctorService implements DoctorServiceInterface
{
    public function all()
    {
        return Doctor::all();
    }

    public function find($id)
    {
        return Doctor::findOrFail($id);
    }

    public function create(array $data)
    {
        return Doctor::create($data);
    }

    public function update($id, array $data)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete($id)
    {
        $doctor = Doctor::findOrFail($id);
        return $doctor->delete();
    }

    public function list()
    {
        return Doctor::all();
    }

    public function show($id)
    {
        return Doctor::findOrFail($id);
    }
}
