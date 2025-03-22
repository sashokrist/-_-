<?php

namespace App\Services\Contracts;

interface TableServiceInterface
{
    public function list();
    public function show($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
