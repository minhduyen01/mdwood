<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiResponse;
use App\Services\BillDetailServiceInterface;
use App\Services\BillServiceInterface;
use App\Services\TypeProductServiceInterface;
use Illuminate\Http\Request;
use Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Mail\SendBill;
use Mail;

class CartController extends ApiController
{
    protected $typeProductService;
    protected $billService;
    protected $billDetailService;
    protected $response;

    public function __construct(
        TypeProductServiceInterface $typeProductService,
        BillServiceInterface $billService,
        BillDetailServiceInterface $billDetailService,
        ApiResponse $response
    ) {
        $this->typeProductService = $typeProductService;
        $this->billService = $billService;
        $this->billDetailService = $billDetailService;
        $this->response = $response;
    }

    public function payment(Request $request)
    {
        DB::beginTransaction();
        try {
            $bill = $this->billService->create([
                'order_no' => $request->order_no,
                'customer_id' => Auth::user()->id,
                'payment' => $request->payment,
                'status' => 0,
            ]);
            foreach ($request->products as $value) {
                $this->billDetailService->create([
                    'bill_id' => $bill->id,
                    'product_id' => $value['id'],
                    'quantity' => $value['quantity'],
                    'unit_price' => $value['price'],
                ]);
            }

            $billDetail = $this->billService->getBillDetailAfterOrder($bill->id);
            // dispatch(new \App\Jobs\SendEmailJob($billDetail[0]));
            DB::commit();
            return $this->response->withCreated();
        } catch (Exception $ex) {
            DB::rollback();
            return $this->response->errorWrongArgs();
        }
    }

    public function receipt($id)
    {
        $bill_detail = $this->billService->getBillDetail($id);
        $menu = $this->typeProductService->GetTypeProduct();
        return view('page.receipt', compact(['bill_detail', 'menu']));
    }
}
