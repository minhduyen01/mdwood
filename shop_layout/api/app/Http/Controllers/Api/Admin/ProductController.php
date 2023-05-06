<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiResponse;
use App\Http\Requests\ProductRequest;
use App\Services\CategoryServiceInterface;
use App\Services\ImageServiceInterface;
use App\Services\ProductServiceInterface;
use App\Services\SupplierServiceInterface;
use App\Services\TypeProductServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    protected $productService;
    protected $categoryService;
    protected $typePruductService;
    protected $supplierService;
    protected $imageService;
    protected $response;

    public function __construct(
        ProductServiceInterface $productService,
        CategoryServiceInterface $categoryService,
        TypeProductServiceInterface $typePruductService,
        SupplierServiceInterface $supplierService,
        ImageServiceInterface $imageService,
        ApiResponse $response
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->typePruductService = $typePruductService;
        $this->supplierService = $supplierService;
        $this->imageService = $imageService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->all());
        $products = $this->productService->GetListProduct($request->all());
        $products->appends($request->all());
        return $this->response->withData($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $slug = Str::slug($request->name);
            $params = $request->all();
            $params['slug'] = $slug;
            $id = $this->productService->CreateProduct($params);
            if (count($request->images) > 0) {
                foreach ($request->images as $value) {
                    $filenamewithextension = $value->getClientOriginalName();
                    $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $extension = $value->getClientOriginalExtension();
                    $filenametostore = $filename . '_' . time() . '.' . $extension;
                    $value->storeAs('public/uploads', $filenametostore);
                    $this->imageService->Create([
                        'product_id' => $id,
                        'image' => $filenametostore,
                    ]);
                }
            }
            DB::commit();
            return $this->response->withCreated();
        } catch (Exception $ex) {
            DB::rollBack();
            return $this->response->withMessage($ex);
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
        $data = $this->productService->GetDetail($id);
        return $this->response->withData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $slug = Str::slug($request->name);
            $params = $request->all();
            $params['slug'] = $slug;
            $this->productService->UpdateProduct($id, $params);
            if (isset($request->images) && count($request->images) > 0) {
                foreach ($request->images as $value) {
                    $filenamewithextension = $value->getClientOriginalName();
                    $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $extension = $value->getClientOriginalExtension();
                    $filenametostore = $filename . '_' . time() . '.' . $extension;
                    $value->storeAs('public/uploads', $filenametostore);
                    $this->imageService->Create([
                        'product_id' => $id,
                        'image' => $filenametostore,
                    ]);
                }
            }

            if (isset($request->delete_images)) {
                foreach ($request->delete_images as $value) {
                    $this->imageService->Delete($value);
                }
            }

            DB::commit();
            return $this->response->withMessage("Cập nhật thành công!");
        } catch (Exception $ex) {
            DB::rollback();
            return $this->response->withMessage($ex);
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
            $this->productService->DeleteProduct($id);
            return $this->response->withMessage('Xóa thành công');
        } catch (Exception $ex) {
            return $this->response->withMessage('Xóa không thành công');
        }
    }

    public function addSale(Request $request)
    {
        try {
            $this->productService->addSale($request->all());
            return $this->response->withCreated();
        } catch(Exception $ex) {
            return $this->response->errorWrongArgs($ex->getMessage());
        }
    }
}
