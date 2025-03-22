<?php

namespace App\Services\Contracts;

interface DoctorServiceInterface
{
    public function list();
    public function show($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
