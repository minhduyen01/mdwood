<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Api\ApiController;
use App\Services\ProductServiceInterface;
use App\Services\TypeProductServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiResponse;

class ProductController extends ApiController
{
    protected $productService;
    protected $typeProductService;
    protected $response;

    public function __construct(
        ProductServiceInterface $productService,
        TypeProductServiceInterface $typeProductService,
        ApiResponse $response
    ) {
        $this->productService = $productService;
        $this->typeProductService = $typeProductService;
        $this->response = $response;
    }

    /**
     * get top product
     * @return json
     */
    public function GetTopProduct() {
        $product = $this->productService->GetListHighLightProduct();
        return $this->response->withData($product);
    }

    public function GetDetailProduct($slug)
    {
        $product = $this->productService->GetBySlug($slug);
        return $this->response->withData($product);
    }

    public function GetProducts(Request $request)
    {
        $product = $this->productService->GetListProduct($request->all());
        return $this->response->withData($product);
    }

    public function GetRandom(Request $request)
    {
        $product = $this->productService->GetRandom($request->all());
        return $this->response->withData($product);
    }

    public function GetNewProducts()
    {
        $product = $this->productService->GetListNewProduct();
        return $this->response->withData($product);
    }
}
