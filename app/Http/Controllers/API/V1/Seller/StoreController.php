<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddInfoRequest;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $storeService;

    /**
     * Create a new ProductController instance.
     *
     * @param StoreService $storeService
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddInfoRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(AddInfoRequest $request)
    {
        return  $this->storeService->store($request);
    }

}
