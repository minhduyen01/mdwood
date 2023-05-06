<?php

namespace App\Http\Controllers\Api\Page;

use App\Services\ProductServiceInterface;
use App\Services\SlideServiceInterface;
use App\Services\TypeProductServiceInterface;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Api\ApiController;
use App\Services\CategoryServiceInterface;

class HomeController extends ApiController
{
    protected $productService;
    protected $slideService;
    protected $typeProductService;
    protected $categoryService;
    protected $response;

    public function __construct(
        ProductServiceInterface $productService,
        SlideServiceInterface $slideService,
        TypeProductServiceInterface $typeProductService,
        CategoryServiceInterface $categoryService,
        ApiResponse $response,
    ) {
        $this->productService = $productService;
        $this->slideService = $slideService;
        $this->typeProductService = $typeProductService;
        $this->response = $response;
        $this->categoryService = $categoryService;
    }

    public function slide()
    {
        $slide = $this->slideService->GetSlidePublic();
        return $this->response->withData($slide);
    }

    public function category()
    {
        $data = $this->categoryService->GetListCategory([]);
        return $this->response->withData($data);
    }

    public function type()
    {
        $data = $this->typeProductService->GetListTypeProduct();
        return $this->response->withData($data);
    }
}
