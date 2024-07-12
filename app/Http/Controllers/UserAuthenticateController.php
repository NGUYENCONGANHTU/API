<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UsersRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Resources\UserAuthenticate\UserAuthenticateResource;
use App\Http\Resources\UserAuthenticate\UserResource;

class UserAuthenticateController extends Controller
{
    /**
     * @var Repository
     */
    protected $usersRepository;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(null, 204);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    public function userLogin(UserLoginRequest $request)
    {
        try {
            $user = $request->only('email', 'password');
            if (!$token = Auth::guard('app-users')->attempt($user)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }

            $user = Auth::guard('app-users')->user();
            $user->token = $token;
            return new UserResource($user);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $ex) {
            return response()->json(['error', 'could_not_create_token', 500]);
        }
    }

    public function changePassword(ChangePasswordRequest  $request, $id)
    {
        try {

            $model = $this->usersRepository->changePassword($request, $id);
            $user = new UserResource($model);
            return $user;
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        try {
            $user = $this->usersRepository->updateRefreshToken($request);

            $token = JWTAuth::fromUser($user);
            $jsonAuthenticate = [];
            $jsonAuthenticate['token'] = $token;
            $jsonAuthenticate['refreshToken'] = $user['refresh_token'];
            $jsonAuthenticate['user'] = $user;
            return new UserAuthenticateResource($jsonAuthenticate);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
    }

    public function userInfo($id){
        try {
            $user = $this->usersRepository->findOrFail($id);
           return new UserResource( $user);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
    }

    public function userRegister(UserRegisterRequest $request)
    {
        try {
            $password = $request->password;
            $attribute = [];
            $attribute['user_name'] = $request->input('user_name');
            $attribute['password'] = Hash::make($password);
            $attribute['status'] =  1;
            $attribute['email'] = $request->input('email');
            $attribute['version'] = 00.1;
            $attribute['ip'] = Request()->ip();
            $attribute['country'] = 'Việt Nam';
            $attribute['phone_number'] = $request->input('phone_number');
            $attribute['refresh_token'] =  md5($request->input('email').config('constant.keySecret').Carbon::now());
            $attribute['full_name'] = $request->input('user_name');
           
            $user = $this->usersRepository->create($attribute);
            return new UserResource($user);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
    }
}
