<?php


namespace App\Services;


use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\StoreResource;
use App\Http\Resources\Api\UserResource;
use App\Repository\ProductRepositoryInterface;
use App\Repository\StoreRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreService
{
    private $storeRepository;

    /**
     * Create a new UserService instance.
     *
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * register a user.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            $store = $this->storeRepository->create($request->all());
            return response()->json(['data' => new StoreResource($store), 'meta' => ['code' => Response::HTTP_OK]]);

        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
