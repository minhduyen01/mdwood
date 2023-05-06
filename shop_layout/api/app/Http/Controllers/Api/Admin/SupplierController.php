<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\SupplierRequest;
use App\Services\SupplierServiceInterface;
use Exception;
use App\Http\Controllers\Api\ApiResponse;

class SupplierController extends ApiController
{
    protected $supplierService;
    protected $response;

    public function __construct(SupplierServiceInterface $supplierService, ApiResponse $response)
    {
        $this->supplierService = $supplierService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $data = $this->supplierService->GetListSupplier();
        return $this->response->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        try {
            $this->supplierService->CreateSupplier($request->all());
            return $this->response->withCreated();
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = $this->supplierService->GetDetailSupplier($id);
        return $this->response->withData($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        try {
            $this->supplierService->UpdateSupplier([
                'id' => $id,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            return $this->response->withMessage('Update success!');
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->supplierService->DeleteSupplier($id);
            return response()->json([
                'message' => 'Xóa thành công'
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'Xóa không thành công'
            ]);
        }
    }
}
