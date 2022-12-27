<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\User\LoginUserRequest;
use App\Http\Requests\Api\v1\User\RegisterUserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * register a new user
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->only(["name", "email", "password"]));
        $user->token = $this->userRepository->createToken($user);
        return self::success("register successful", $user, Response::HTTP_CREATED);
    }

    /**
     * login user
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->login($request);
        if (!$user)
            return self::error(code: Response::HTTP_NOT_ACCEPTABLE, error: "email or password are not correct");

        $user->token = $this->userRepository->createToken($user);
        return self::success(message: "logged in successfully", data: $user, code: Response::HTTP_ACCEPTED);
    }
}
