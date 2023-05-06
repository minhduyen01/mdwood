<?php

namespace App\Services;

interface SaleServiceInterface
{
    public function upsert($params);

    public function delete($id);

    public function get();
}
