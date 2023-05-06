<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserServiceInterface;
use Exception;
use App\Http\Controllers\Api\ApiResponse;
use App\Services\BillServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends ApiController
{
    protected $userService;
    protected $response;
    protected $billsService;

    public function __construct(UserServiceInterface $userService, ApiResponse $response, BillServiceInterface $billsService)
    {
        $this->userService = $userService;
        $this->response = $response;
        $this->billsService = $billsService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (! $token = Auth::attempt($credentials)) {
            return $this->response->errorUnauthorized();
        }

        return $this->response->withData([
            'access_token' => $token,
            'token_type' => 'bearer token',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->response->withData(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->response->withData([
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer token',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $this->userService->create($request->all());
            return $this->response->withCreated();
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->userService->update($request->all(), $id);
            return $this->response->withCreated();
        } catch (Exception $ex) {
            return $this->response->errorWrongArgs($ex->getMessage());
        }
    }

    public function order()
    {
        $data = $this->billsService->getListByUserId(Auth::user()->id);
        return $this->response->withData($data);
    }

    public function orderDetail($order_no)
    {
        $data = $this->billsService->getBillDetailByOrderNo($order_no);
        return $this->response->withData($data);
    }

    public function changePassword(Request $request)
    {
        $current_password = Auth::User()->password;
        if(Hash::check($request->old_password, $current_password)) {
            try {
                $this->userService->update([
                    'password' => $request->new_password
                ], Auth::user()->id);
                return $this->response->withCreated();
            } catch (Exception $ex) {
                return $this->response->errorWrongArgs($ex->getMessage());
            }
        }
        return $this->response->errorUnauthorized();
    }

    public function updateOrder(Request $request, $id)
    {
        $this->billsService->update($id, $request->all());
        return $this->response->withMessage('Update success!');
    }
}
