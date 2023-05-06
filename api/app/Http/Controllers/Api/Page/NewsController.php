<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Api\ApiController;
use App\Services\NewsServiceInterface;
use Illuminate\Http\Request;

class NewsController extends ApiController
{
    protected $response;
    protected $newsService;

    public function __construct(ApiResponse $response, NewsServiceInterface $newsService)
    {
        $this->response = $response;
        $this->newsService = $newsService;
    }

    public function getNewList() {
        return $this->response->withData($this->newsService->getNewList());
    }

    public function getDetail($slug)
    {
        return $this->response->withData($this->newsService->detailBySlug($slug));
    }

    public function getAll()
    {
        return $this->response->withData($this->newsService->getAll());
    }
}
