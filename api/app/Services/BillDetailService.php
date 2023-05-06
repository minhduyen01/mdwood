<?php

namespace App\Services;

use App\Models\BillDetail;
use Illuminate\Support\Facades\DB;

class BillDetailService implements BillDetailServiceInterface
{
    protected $billDetail;

    public function __construct(BillDetail $billDetail)
    {
        $this->billDetail = $billDetail;
    }

    public function create($params)
    {
        $this->billDetail->create($params);
    }

    public function revenueOfDay()
    {
        return $this->billDetail->select(DB::raw('DATE(bill_detail.created_at) as date'))
        ->join('bills', 'bills.id', '=', 'bill_detail.bill_id')
        ->where('bills.status', 1)
        ->whereDate('bill_detail.created_at', '=', today()->toDateString())
        ->groupBy('date')->first();
    }

    public function revenueOfWeek()
    {
        $now = now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        return $this->billDetail->select(DB::raw('DATE(bill_detail.created_at) as date'))
        ->join('bills', 'bills.id', '=', 'bill_detail.bill_id')
        ->where('bills.status', 1)
        ->whereDate('bill_detail.created_at', '>=', $weekStartDate)
        ->whereDate('bill_detail.created_at', '<=', $weekEndDate)
        ->groupBy('date')->get();
    }

    public function revenueOfMonth()
    {
        $now = now();
        return $this->billDetail->select(DB::raw('MONTH(bill_detail.created_at) as month'))
        ->join('bills', 'bills.id', '=', 'bill_detail.bill_id')
        ->where('bills.status', 1)
        ->whereYear('bill_detail.created_at', '=', $now)
        ->groupBy('month')->get();
    }

    public function topProductSale()
    {
        return $this->billDetail->with('product')
        ->select('product_id', DB::raw('COUNT(quantity) as quantity'))
        ->join('bills', 'bills.id', '=', 'bill_detail.bill_id')
        ->where('bills.status', 1)
        ->groupBy('product_id')->orderBy('quantity', 'DESC')->limit(10)->get();
    }
}
