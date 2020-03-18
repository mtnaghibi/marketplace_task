<?php


namespace App\Services;


use App\Repository\OrderRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private $orderRepository;

    /**
     * Create a new OrderService instance.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * store a order.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $success = DB::table('products')
                    ->where('id', '=', $request->input('product_id'))
                    ->where('stock_count', '>', 0)
                    ->lockForUpdate()
                    ->decrement('stock_count');
                if ($success)
                    $this->orderRepository->create($request->all());
                else
                   throw new Exception('out of stock!');
            });
            return response()->json(null, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
