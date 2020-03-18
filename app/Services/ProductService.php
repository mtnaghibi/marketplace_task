<?php


namespace App\Services;


use App\Http\Resources\Api\ProductCollection;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\StoreCollection;
use App\Http\Resources\Api\StoreResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Store;
use App\Repository\ProductRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductService
{
    private $productRepository;

    /**
     * Create a new ProductService instance.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * store a product.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            $product = $this->productRepository->create($request->all());
            return response()->json(['data' => new ProductResource($product), 'meta' => ['code' => Response::HTTP_OK]]);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * get list of nearest store with some products
     * @param Request $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function index(Request $request)
    {
        try {
            $stores = $this->productRepository->all($request->all());
            return StoreResource::collection($stores);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
