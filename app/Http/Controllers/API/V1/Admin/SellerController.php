<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterSellerRequest;
use App\Services\UserService;
use App\User;

class SellerController extends Controller
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
    }

    public function create(RegisterSellerRequest $request)
    {
        $request->request->add(['role' => [User::ROLE_SELLER]]);
        return $this->userService->register($request);
    }
}
