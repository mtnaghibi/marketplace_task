<?php


namespace App\Services;


use App\Http\Resources\Api\UserResource;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    private $userRepository;

    /**
     * Create a new UserService instance.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * register a user.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function register(Request $request)
    {
        try {
            $user = $this->userRepository->create($request->all());
            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Log the user in
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new ModelNotFoundException('invalid_credentials');
            }
        } catch (Exception $exception) {
            throw $exception;
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthenticatedUser(Request $request)
    {
        $user = Auth::user();
        return response()->json(['data' => new UserResource($user), 'meta' => ['code' => Response::HTTP_OK]]);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json(
            ['data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 'meta' => ['code' => Response::HTTP_OK]]
        );
    }
}
