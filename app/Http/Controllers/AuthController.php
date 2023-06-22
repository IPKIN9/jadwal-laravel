<?php

namespace App\Http\Controllers;

use App\Interfaces\UserManageInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private UserManageInterface $userRepo;
    public function __construct(UserManageInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function getToken(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'         ],
        ]);
    
        if (Auth::attempt($credentials)) {
            $user  = Auth::user();
            $token = $user->createToken('token-name', [$request->scope])->plainTextToken;

            $scope = $this->userRepo->getRoles($credentials['email']);

            return response()->json(array(
                'token'   => $token,
                'scope'   => $scope['data']['scope']
            ), 200);
        } else {
            return response()->json(array(
                'message' => 'Username atau password salah',
                'code'    => 401
            ), Response::HTTP_UNAUTHORIZED);
        }
    }

    public function revokeToken(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
    
            $response = [
                'message' => 'Token berhasil dihapus',
                'code'    => Response::HTTP_OK       ,
            ];
        } catch (\Throwable $th) {
            $response = [
                'message' => $th->getMessage(),
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR  ,
            ];
        }
    
        return response()->json($response, $response['code']);
    }
}
