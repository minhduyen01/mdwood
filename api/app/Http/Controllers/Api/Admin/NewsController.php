<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiResponse;
use App\Services\NewsServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends ApiController
{
    protected $newsService;
    protected $response;

    public function __construct(NewsServiceInterface $newsService, ApiResponse $response)
    {
        $this->newsService = $newsService;
        $this->response = $response;
    }

    public function create(Request $request)
    {
        try {
            $slug = Str::slug($request->title);
            $params = $request->all();
            $params['slug'] = $slug;
            $params['status'] = 1;

            if($request->hasFile('image')) {
                //get filename with extension
                $filenamewithextension = $request->image->getClientOriginalName();
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                //get file extension
                $extension = $request->image->getClientOriginalExtension();
                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;
                //Upload File
                $request->image->storeAs('public/uploads', $filenametostore);
                $params['image'] = $filenametostore;
            }
            $this->newsService->create($params);
            return $this->response->withCreated();
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs($ex->getMessage());
        }
    }

    public function getList()
    {
        return $this->response->withData($this->newsService->get());
    }

    public function update($id, Request $request)
    {
        try {
            $params = $request->all();
            if (isset($request->title)) {
                $slug = Str::slug($request->title);
                $params['slug'] = $slug;
            }
            if (isset($request->image)) {
                //get filename with extension
                $filenamewithextension = $request->image->getClientOriginalName();
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                //get file extension
                $extension = $request->image->getClientOriginalExtension();
                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;
                //Upload File
                $request->image->storeAs('public/uploads', $filenametostore);
                $params['image'] = $filenametostore;
            }
            $this->newsService->update($id, $params);
            return $this->response->withMessage('Update success!');
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs($ex->getMessage());
        }
    }

    public function detail($id)
    {
        return $this->response->withData($this->newsService->detail($id));
    }
}
