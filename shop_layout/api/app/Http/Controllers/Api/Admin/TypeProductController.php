<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\TypeProductRequest;
use App\Services\TypeProductServiceInterface;
use Exception;
use Session;
use App\Http\Controllers\Api\ApiResponse;

class TypeProductController extends ApiController
{
    protected $typeProductService;
    protected $response;

    public function __construct(TypeProductServiceInterface $typeProductService, ApiResponse $response)
    {
        $this->typeProductService = $typeProductService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $data = $this->typeProductService->GetListTypeProduct();
        return $this->response->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeProductRequest $request)
    {
        try {
            $this->typeProductService->CreateTypeProduct([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return $this->response->withCreated();
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typeProduct = $this->typeProductService->GetDetailTypeProduct($id);
        return $this->response->withData($typeProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeProductRequest $request, $id)
    {
        try {
            $this->typeProductService->UpdateTypeProduct($id, $request->all());
            return $this->response->withCreated();
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
            $this->typeProductService->DeleteTypeProduct($id);
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
