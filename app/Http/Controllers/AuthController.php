<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
  public function __construct(private readonly AuthService $authService) {}


  /**
   * @param RegisterRequest $request
   * @return JsonResponse
   */
  public function register(RegisterRequest $request): JsonResponse
  {
    $response = $this->authService->register($request->validated());

    return response()->json([
      'success' => true,
      'data' => $response,
    ]);
  }
  /**
   * @param LoginRequest $request
   * @return JsonResponse
   */
  public function login(LoginRequest $request): JsonResponse
  {
    $response = $this->authService->login($request->validated());

    return response()->json([
      'success' => true,
      'data' => $response,
    ]);
  }
}
