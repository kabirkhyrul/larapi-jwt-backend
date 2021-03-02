<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param JWTAuth $JWTAuth
     * @return JsonResponse
     */
    public function login(JWTAuth $JWTAuth): JsonResponse
    {
        $credentials = request(['email', 'password']);
        if (!$jwt_token = $JWTAuth->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($jwt_token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * @param Request $request
     * @param JWTAuth $JWTAuth
     * @return JsonResponse
     */
    public function signup(Request $request, JWTAuth $JWTAuth): JsonResponse
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:5']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return \response()->json($validator->getMessageBag(), Response::HTTP_BAD_REQUEST);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $user->save();
            $token = $JWTAuth->fromUser($user);
            return response()->json([
                'status' => 'ok',
                'token' => $token
            ], 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @param JWTAuth $JWTAuth
     * @return JsonResponse
     */
    public function me(JWTAuth $JWTAuth): JsonResponse
    {
        try {

            if (!$user = $JWTAuth->parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getCode());
        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getCode());
        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getCode());
        }

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


}
