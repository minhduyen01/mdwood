<?php

namespace App\Services;

interface BillDetailServiceInterface
{
    public function create($params);

    public function revenueOfDay();

    public function revenueOfWeek();

    public function revenueOfMonth();

    public function topProductSale();
}
