<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Services\CategoryServiceInterface;
use App\Services\TypeProductServiceInterface;
use Exception;
use Session;

class CategoryController extends ApiController
{
    protected $categoryService;
    protected $typeProductService;
    protected $response;

    public function __construct(CategoryServiceInterface $categoryService, TypeProductServiceInterface $typeProductService, ApiResponse $response)
    {
        $this->categoryService = $categoryService;
        $this->typeProductService = $typeProductService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $data = $this->categoryService->GetListCategory($request->all());
        return $this->response->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->CreateCategory($request->all());
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
        $category = $this->categoryService->GetDetailCategory($id);
        return $this->response->withData($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->categoryService->UpdateCategory($id, $request->all());
            return $this->response->withMessage('update success!');
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
            $this->categoryService->DeleteCategory($id);
            return $this->response->withMessage('deleted success!');
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs();
        }
    }
}
