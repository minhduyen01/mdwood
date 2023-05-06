<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiResponse;
use App\Services\BillServiceInterface;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    protected $billService;
    protected $response;

    public function __construct(BillServiceInterface $billService, ApiResponse $response)
    {
        $this->billService = $billService;
        $this->response = $response;
    }

    public function index(Request $request)
    {
        $data = $this->billService->getBill($request->all());
        $data->appends($request->all());
        return $this->response->withData($data);
    }

    public function update(Request $request, $id)
    {
        $this->billService->update($id, $request->all());
        return $this->response->withMessage('Update success!');
    }

    public function detail($id)
    {
        $data = $this->billService->getBillDetail($id);
        return $this->response->withData($data);
    }
}
