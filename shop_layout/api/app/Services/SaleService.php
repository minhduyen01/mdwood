<?php

namespace App\Services;

use App\Models\Sale;

class SaleService implements SaleServiceInterface
{
    protected $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function upsert($params)
    {
        $this->sale->updateOrCreate($params);
    }

    public function delete($id)
    {
        $this->sale->findOrFail($id)->delete();
    }

    public function get()
    {
        return $this->sale->with(['category', 'typeProduct', 'supplier'])->get()->map(function ($data)
        {
            return [
                'id' => $data->id,
                'title' => $data->title,
                'sale' => $data->sale,
                'order_no' => $data->order_no,
                'status' => $data->status == 0? false : true
            ];
        });
    }
}
