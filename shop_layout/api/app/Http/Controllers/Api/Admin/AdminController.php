<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\ProductServiceInterface;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Api\ApiController;
use App\Services\BillDetailServiceInterface;
use App\Services\BillServiceInterface;
use App\Services\UserServiceInterface;

class AdminController extends ApiController
{
    protected $productService;
    protected $billService;
    protected $response;
    protected $userService;
    protected $billDetailService;

    public function __construct(
        ProductServiceInterface $productService,
        ApiResponse $response,
        BillServiceInterface $billService,
        UserServiceInterface $userService,
        BillDetailServiceInterface $billDetailService
    ) {
        $this->productService = $productService;
        $this->response = $response;
        $this->billService = $billService;
        $this->userService = $userService;
        $this->billDetailService = $billDetailService;
    }

    public function countOrderOnDay()
    {
        $data = $this->billService->countBillOnDay();
        return $this->response->withData($data);
    }

    public function countUserRegisterOnDay()
    {
        $data = $this->userService->countUserRegisterOnDay();
        return $this->response->withData($data);
    }

    public function revenueOfDay()
    {
        $data = $this->billDetailService->revenueOfDay();
        return $this->response->withData($data);
    }

    public function revenueOfWeek()
    {
        $data = $this->billDetailService->revenueOfWeek();
        return $this->response->withData($data);
    }

    public function revenueOfMonth()
    {
        $data = $this->billDetailService->revenueOfMonth();
        return $this->response->withData($data);
    }

    public function topProductSale()
    {
        $data = $this->billDetailService->topProductSale();
        return $this->response->withData($data);
    }
}
