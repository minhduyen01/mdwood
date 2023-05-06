<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Support\Facades\Storage;


class BillService implements BillServiceInterface
{
    protected $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    public function create($params)
    {
        return $this->bill->create($params);
    }

    public function getBillDetail($id)
    {
        return $this->bill->with(['billDetail', 'user', 'billDetail.product', 'billDetail.product.category', 'billDetail.product.images'])->findOrFail($id);
    }

    public function getBill($params)
    {
        $query = $this->bill->with('user');
        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query->orderBy('created_at', 'DESC')->paginate();
    }

    public function update($id, $status)
    {
        $this->bill->findOrFail($id)->update($status);
    }

    public function getListByUserId($id) {
        return $this->bill->where('customer_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    public function getBillDetailByOrderNo($order_no)
    {
        return $this->bill
            ->with(['billDetail', 'billDetail.product', 'billDetail.product.images'])
            ->where('order_no', $order_no)->first();
    }

    public function countBillOnDay()
    {
        return $this->bill->whereDate('created_at', '=', today()->toDateString())->get()->count();
    }

    public function getBillDetailAfterOrder($id)
    {
        $data = $this->bill->with(['billDetail', 'user', 'billDetail.product', 'billDetail.product.images'])
            ->whereId($id)->get();
        return $data->map(function ($data) {
            // dd($data->billDetail);
            return [
                'name' => $data->user->name,
                'phone' => $data->user->phone,
                'email' => $data->user->email,
                'address' => $data->user->address,
                'order_no' => $data->order_no,
                'created_at' => $data->created_at,
                'bill_detail' =>$data->billDetail->map(function ($billDetail) {
                    return [
                        'quantity' => $billDetail->quantity,
                        'unit_price' => $billDetail->unit_price,
                        'sale' => $billDetail->sale,
                        'product_name' => $billDetail->product->name,
                        'image' => base64_encode(Storage::get('public/uploads/' . $billDetail->product->images[0]->image))
                    ];
                }),
            ];
        });
    }
}
