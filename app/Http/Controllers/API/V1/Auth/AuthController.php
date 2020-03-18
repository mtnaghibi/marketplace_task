<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Repository\UserRepositoryInterface;
use App\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $userService;

    /**
     * Create a new AuthController instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * SignUp a user.
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(RegisterUserRequest $request)
    {
        return $this->userService->register($request);
    }
    /**
     * Log the user in
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginUserRequest $request)
    {
        return $this->userService->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthenticatedUser(Request $request)
    {
        return $this->userService->getAuthenticatedUser($request);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->userService->refresh();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        return $this->userService->logout();
    }
}
