<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Services\SlideServiceInterface;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Api\ApiResponse;
use Exception;

class SlideController extends ApiController
{
    protected $slideService;
    protected $response;

    /**
     * Undocumented function
     */
    public function __construct(SlideServiceInterface $slideService, ApiResponse $response)
    {
        $this->slideService = $slideService;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->slideService->GetSlide();
        return $this->response->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $fileNameWithExtention = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtention, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenametostore = $fileName.'_'.time().'.'.$extension;
            $request->file('image')->storeAs('public/uploads', $filenametostore);
            $this->slideService->CreateSlide([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $filenametostore,
                'status' => 0,
            ]);
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
        $slide = $this->slideService->GetDetail($id);
        return $this->response->withData($slide);
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
        try {
            if (isset($request->image)) {
                $fileNameWithExtention = $request->file('image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExtention, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $filenametostore = $fileName.'_'.time().'.'.$extension;
                $request->file('image')->storeAs('public/uploads', $filenametostore);
                $this->slideService->UpdateSlide($id, [
                    'name' => $request->name,
                    'link' => $request->link,
                    'description' => $request->description,
                    'image' => $filenametostore,
                ]);
            } else {
                $this->slideService->UpdateSlide($id, $request->all());
            }
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
            $this->slideService->DeleteSlide($id);
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
