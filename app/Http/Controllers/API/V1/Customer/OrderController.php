<?php

namespace App\Http\Controllers\API\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private $orderService;

    /**
     * Create a new ProductController instance.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param OrderRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function buy(OrderRequest $request)
    {
        return  $this->orderService->store($request);
    }
}
